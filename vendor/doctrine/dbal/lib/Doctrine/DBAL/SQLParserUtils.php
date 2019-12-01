<?php

namespace Doctrine\DBAL;

use const PREG_OFFSET_CAPTURE;
use function array_fill;
use function array_key_exists;
use function array_merge;
use function array_slice;
use function array_values;
use function count;
use function implode;
use function is_int;
use function key;
use function ksort;
use function preg_match_all;
use function sprintf;
use function strlen;
use function strpos;
use function substr;

/**
 * Utility class that parses sql statements with regard to types and parameters.
 */
class SQLParserUtils
{
    /**#@+
     *
     * @deprecated Will be removed as internal implementation details.
     */
    public const POSITIONAL_TOKEN = '\?';
    public const NAMED_TOKEN      = '(?<!:):[a-zA-Z_][a-zA-Z0-9_]*';
    // Quote characters within string literals can be preceded by a backslash.
    public const ESCAPED_SINGLE_QUOTED_TEXT   = "(?:'(?:\\\\\\\\)+'|'(?:[^'\\\\]|\\\\'?|'')*')";
    public const ESCAPED_DOUBLE_QUOTED_TEXT   = '(?:"(?:\\\\\\\\)+"|"(?:[^"\\\\]|\\\\"?)*")';
    public const ESCAPED_BACKTICK_QUOTED_TEXT = '(?:`(?:\\\\\\\\)+`|`(?:[^`\\\\]|\\\\`?)*`)';
    /**#@-*/

    private const ESCAPED_BRACKET_QUOTED_TEXT = '(?<!\b(?i:ARRAY))\[(?:[^\]])*\]';

    /**
     * Gets an array of the placeholders in an sql statements as keys and their positions in the query string.
     *
     * For a statement with positional parameters, returns a zero-indexed list of placeholder position.
     * For a statement with named parameters, returns a map of placeholder positions to their parameter names.
     *
     * @deprecated Will be removed as internal implementation detail.
     *
     * @param string $statement
     * @param bool   $isPositional
     *
     * @return int[]|string[]
     */
    public static function getPlaceholderPositions($statement, $isPositional = true)
    {
        return $isPositional
            ? self::getPositionalPlaceholderPositions($statement)
            : self::getNamedPlaceholderPositions($statement);
    }

    /**
     * Returns a zero-indexed list of placeholder position.
     *
     * @return int[]
     */
    private static function getPositionalPlaceholderPositions(string $statement) : array
    {
        return self::collectPlaceholders(
            $statement,
            '?',
            self::POSITIONAL_TOKEN,
            static function (string $_, int $placeholderPosition, int $fragmentPosition, array &$carry) : void {
                $carry[] = $placeholderPosition + $fragmentPosition;
            }
        );
    }

    /**
     * Returns a map of placeholder positions to their parameter names.
     *
     * @return string[]
     */
    private static function getNamedPlaceholderPositions(string $statement) : array
    {
        return self::collectPlaceholders(
            $statement,
            ':',
            self::NAMED_TOKEN,
            static function (string $placeholder, int $placeholderPosition, int $fragmentPosition, array &$carry) : void {
                $carry[$placeholderPosition + $fragmentPosition] = substr($placeholder, 1);
            }
        );
    }

    /**
     * @return mixed[]
     */
    private static function collectPlaceholders(string $statement, string $match, string $token, callable $collector) : array
    {
        if (strpos($statement, $match) === false) {
            return [];
        }

        $carry = [];

        foreach (self::getUnquotedStatementFragments($statement) as $fragment) {
            preg_match_all('/' . $token . '/', $fragment[0], $matches, PREG_OFFSET_CAPTURE);
            foreach ($matches[0] as $placeholder) {
                $collector($placeholder[0], $placeholder[1], $fragment[1], $carry);
            }
        }

        return $carry;
    }

    /**
     * For a positional query this method can rewrite the sql statement with regard to array parameters.
     *
     * @param string         $query  The SQL query to execute.
     * @param mixed[]        $params The parameters to bind to the query.
     * @param int[]|string[] $types  The types the previous parameters are in.
     *
     * @return mixed[]
     *
     * @throws SQLParserUtilsException
     */
    public static function expandListParameters($query, $params, $types)
    {
        $isPositional   = is_int(key($params));
        $arrayPositions = [];
        $bindIndex      = -1;

        if ($isPositional) {
            ksort($params);
            ksort($types);
        }

        foreach ($types as $name => $type) {
            ++$bindIndex;

            if ($type !== Connection::PARAM_INT_ARRAY && $type !== Connection::PARAM_STR_ARRAY) {
                continue;
            }

            if ($isPositional) {
                $name = $bindIndex;
            }

            $arrayPositions[$name] = false;
        }

        if (( ! $arrayPositions && $isPositional)) {
            return [$query, $params, $types];
        }

        if ($isPositional) {
            $paramOffset = 0;
            $queryOffset = 0;
            $params      = array_values($params);
            $types       = array_values($types);

            $paramPos = self::getPositionalPlaceholderPositions($query);

            foreach ($paramPos as $needle => $needlePos) {
                if (! isset($arrayPositions[$needle])) {
                    continue;
                }

                $needle    += $paramOffset;
                $needlePos += $queryOffset;
                $count      = count($params[$needle]);

                $params = array_merge(
                    array_slice($params, 0, $needle),
                    $params[$needle],
                    array_slice($params, $needle + 1)
                );

                $types = array_merge(
                    array_slice($types, 0, $needle),
                    $count ?
                        // array needles are at {@link \Doctrine\DBAL\ParameterType} constants
                        // + {@link Doctrine\DBAL\Connection::ARRAY_PARAM_OFFSET}
                        array_fill(0, $count, $types[$needle] - Connection::ARRAY_PARAM_OFFSET) :
                        [],
                    array_slice($types, $needle + 1)
                );

                $expandStr = $count ? implode(', ', array_fill(0, $count, '?')) : 'NULL';
                $query     = substr($query, 0, $needlePos) . $expandStr . substr($query, $needlePos + 1);

                $paramOffset += ($count - 1); // Grows larger by number of parameters minus the replaced needle.
                $queryOffset += (strlen($expandStr) - 1);
            }

            return [$query, $params, $types];
        }

        $queryOffset = 0;
        $typesOrd    = [];
        $paramsOrd   = [];

        $paramPos = self::getNamedPlaceholderPositions($query);

        foreach ($paramPos as $pos => $paramName) {
            $paramLen = strlen($paramName) + 1;
            $value    = static::extractParam($paramName, $params, true);

            if (! isset($arrayPositions[$paramName]) && ! isset($arrayPositions[':' . $paramName])) {
                $pos         += $queryOffset;
                $queryOffset -= ($paramLen - 1);
                $paramsOrd[]  = $value;
                $typesOrd[]   = static::extractParam($paramName, $types, false, ParameterType::STRING);
                $query        = substr($query, 0, $pos) . '?' . substr($query, ($pos + $paramLen));

                continue;
            }

            $count     = count($value);
            $expandStr = $count > 0 ? implode(', ', array_fill(0, $count, '?')) : 'NULL';

            foreach ($value as $val) {
                $paramsOrd[] = $val;
                $typesOrd[]  = static::extractParam($paramName, $types, false) - Connection::ARRAY_PARAM_OFFSET;
            }

            $pos         += $queryOffset;
            $queryOffset += (strlen($expandStr) - $paramLen);
            $query        = substr($query, 0, $pos) . $expandStr . substr($query, ($pos + $paramLen));
        }

        return [$query, $paramsOrd, $typesOrd];
    }

    /**
     * Slice the SQL statement around pairs of quotes and
     * return string fragments of SQL outside of quoted literals.
     * Each fragment is captured as a 2-element array:
     *
     * 0 => matched fragment string,
     * 1 => offset of fragment in $statement
     *
     * @param string $statement
     *
     * @return mixed[][]
     */
    private static function getUnquotedStatementFragments($statement)
    {
        $literal    = self::ESCAPED_SINGLE_QUOTED_TEXT . '|' .
            self::ESCAPED_DOUBLE_QUOTED_TEXT . '|' .
            self::ESCAPED_BACKTICK_QUOTED_TEXT . '|' .
            self::ESCAPED_BRACKET_QUOTED_TEXT;
        $expression = sprintf('/((.+(?i:ARRAY)\\[.+\\])|([^\'"`\\[]+))(?:%s)?/s', $literal);

        preg_match_all($expression, $statement, $fragments, PREG_OFFSET_CAPTURE);

        return $fragments[1];
    }

    /**
     * @param string $paramName     The name of the parameter (without a colon in front)
     * @param mixed  $paramsOrTypes A hash of parameters or types
     * @param bool   $isParam
     * @param mixed  $defaultValue  An optional default value. If omitted, an exception is thrown
     *
     * @return mixed
     *
     * @throws SQLParserUtilsException
     */
    private static function extractParam($paramName, $paramsOrTypes, $isParam, $defaultValue = null)
    {
        if (array_key_exists($paramName, $paramsOrTypes)) {
            return $paramsOrTypes[$paramName];
        }

        // Hash keys can be prefixed with a colon for compatibility
        if (array_key_exists(':' . $paramName, $paramsOrTypes)) {
            return $paramsOrTypes[':' . $paramName];
        }

        if ($defaultValue !== null) {
            return $defaultValue;
        }

        if ($isParam) {
            throw SQLParserUtilsException::missingParam($paramName);
        }

        throw SQLParserUtilsException::missingType($paramName);
    }
}
