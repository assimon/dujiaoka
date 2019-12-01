<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Util;

/**
 * A docblock representation.
 *
 * Based on PHP-DocBlock-Parser by Paul Scott:
 *
 * {@link http://www.github.com/icio/PHP-DocBlock-Parser}
 *
 * @author Paul Scott <paul@duedil.com>
 * @author Justin Hileman <justin@justinhileman.info>
 */
class Docblock
{
    /**
     * Tags in the docblock that have a whitespace-delimited number of parameters
     * (such as `@param type var desc` and `@return type desc`) and the names of
     * those parameters.
     *
     * @var array
     */
    public static $vectors = [
        'throws' => ['type', 'desc'],
        'param'  => ['type', 'var', 'desc'],
        'return' => ['type', 'desc'],
    ];

    protected $reflector;

    /**
     * The description of the symbol.
     *
     * @var string
     */
    public $desc;

    /**
     * The tags defined in the docblock.
     *
     * The array has keys which are the tag names (excluding the @) and values
     * that are arrays, each of which is an entry for the tag.
     *
     * In the case where the tag name is defined in {@see DocBlock::$vectors} the
     * value within the tag-value array is an array in itself with keys as
     * described by {@see DocBlock::$vectors}.
     *
     * @var array
     */
    public $tags;

    /**
     * The entire DocBlock comment that was parsed.
     *
     * @var string
     */
    public $comment;

    /**
     * Docblock constructor.
     *
     * @param \Reflector $reflector
     */
    public function __construct(\Reflector $reflector)
    {
        $this->reflector = $reflector;
        $this->setComment($reflector->getDocComment());
    }

    /**
     * Set and parse the docblock comment.
     *
     * @param string $comment The docblock
     */
    protected function setComment($comment)
    {
        $this->desc    = '';
        $this->tags    = [];
        $this->comment = $comment;

        $this->parseComment($comment);
    }

    /**
     * Find the length of the docblock prefix.
     *
     * @param array $lines
     *
     * @return int Prefix length
     */
    protected static function prefixLength(array $lines)
    {
        // find only lines with interesting things
        $lines = \array_filter($lines, function ($line) {
            return \substr($line, \strspn($line, "* \t\n\r\0\x0B"));
        });

        // if we sort the lines, we only have to compare two items
        \sort($lines);

        $first = \reset($lines);
        $last  = \end($lines);

        // find the longest common substring
        $count = \min(\strlen($first), \strlen($last));
        for ($i = 0; $i < $count; $i++) {
            if ($first[$i] !== $last[$i]) {
                return $i;
            }
        }

        return $count;
    }

    /**
     * Parse the comment into the component parts and set the state of the object.
     *
     * @param string $comment The docblock
     */
    protected function parseComment($comment)
    {
        // Strip the opening and closing tags of the docblock
        $comment = \substr($comment, 3, -2);

        // Split into arrays of lines
        $comment = \array_filter(\preg_split('/\r?\n\r?/', $comment));

        // Trim asterisks and whitespace from the beginning and whitespace from the end of lines
        $prefixLength = self::prefixLength($comment);
        $comment = \array_map(function ($line) use ($prefixLength) {
            return \rtrim(\substr($line, $prefixLength));
        }, $comment);

        // Group the lines together by @tags
        $blocks = [];
        $b = -1;
        foreach ($comment as $line) {
            if (self::isTagged($line)) {
                $b++;
                $blocks[] = [];
            } elseif ($b === -1) {
                $b = 0;
                $blocks[] = [];
            }
            $blocks[$b][] = $line;
        }

        // Parse the blocks
        foreach ($blocks as $block => $body) {
            $body = \trim(\implode("\n", $body));

            if ($block === 0 && !self::isTagged($body)) {
                // This is the description block
                $this->desc = $body;
            } else {
                // This block is tagged
                $tag  = \substr(self::strTag($body), 1);
                $body = \ltrim(\substr($body, \strlen($tag) + 2));

                if (isset(self::$vectors[$tag])) {
                    // The tagged block is a vector
                    $count = \count(self::$vectors[$tag]);
                    if ($body) {
                        $parts = \preg_split('/\s+/', $body, $count);
                    } else {
                        $parts = [];
                    }

                    // Default the trailing values
                    $parts = \array_pad($parts, $count, null);

                    // Store as a mapped array
                    $this->tags[$tag][] = \array_combine(self::$vectors[$tag], $parts);
                } else {
                    // The tagged block is only text
                    $this->tags[$tag][] = $body;
                }
            }
        }
    }

    /**
     * Whether or not a docblock contains a given @tag.
     *
     * @param string $tag The name of the @tag to check for
     *
     * @return bool
     */
    public function hasTag($tag)
    {
        return \is_array($this->tags) && \array_key_exists($tag, $this->tags);
    }

    /**
     * The value of a tag.
     *
     * @param string $tag
     *
     * @return array
     */
    public function tag($tag)
    {
        return $this->hasTag($tag) ? $this->tags[$tag] : null;
    }

    /**
     * Whether or not a string begins with a @tag.
     *
     * @param string $str
     *
     * @return bool
     */
    public static function isTagged($str)
    {
        return isset($str[1]) && $str[0] === '@' && !\preg_match('/[^A-Za-z]/', $str[1]);
    }

    /**
     * The tag at the beginning of a string.
     *
     * @param string $str
     *
     * @return string|null
     */
    public static function strTag($str)
    {
        if (\preg_match('/^@[a-z0-9_]+/', $str, $matches)) {
            return $matches[0];
        }
    }
}
