<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\TabCompletion\Matcher;

/**
 * A class name tab completion Matcher.
 *
 * This matcher provides completion for all declared classes.
 *
 * @author Marc Garcia <markcial@gmail.com>
 */
class ClassNamesMatcher extends AbstractMatcher
{
    /**
     * {@inheritdoc}
     */
    public function getMatches(array $tokens, array $info = [])
    {
        $class = $this->getNamespaceAndClass($tokens);
        if (\strlen($class) > 0 && $class[0] === '\\') {
            $class = \substr($class, 1, \strlen($class));
        }
        $quotedClass = \preg_quote($class);

        return \array_map(
            function ($className) use ($class) {
                // get the number of namespace separators
                $nsPos = \substr_count($class, '\\');
                $pieces = \explode('\\', $className);
                //$methods = Mirror::get($class);
                return \implode('\\', \array_slice($pieces, $nsPos, \count($pieces)));
            },
            \array_filter(
                \get_declared_classes(),
                function ($className) use ($quotedClass) {
                    return AbstractMatcher::startsWith($quotedClass, $className);
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function hasMatched(array $tokens)
    {
        $token     = \array_pop($tokens);
        $prevToken = \array_pop($tokens);

        $blacklistedTokens = [
            self::T_INCLUDE, self::T_INCLUDE_ONCE, self::T_REQUIRE, self::T_REQUIRE_ONCE,
        ];

        switch (true) {
            case self::hasToken([$blacklistedTokens], $token):
            case self::hasToken([$blacklistedTokens], $prevToken):
            case \is_string($token) && $token === '$':
                return false;
            case self::hasToken([self::T_NEW, self::T_OPEN_TAG, self::T_NS_SEPARATOR, self::T_STRING], $prevToken):
            case self::hasToken([self::T_NEW, self::T_OPEN_TAG, self::T_NS_SEPARATOR], $token):
            case self::hasToken([self::T_OPEN_TAG, self::T_VARIABLE], $token):
            case self::isOperator($token):
                return true;
        }

        return false;
    }
}
