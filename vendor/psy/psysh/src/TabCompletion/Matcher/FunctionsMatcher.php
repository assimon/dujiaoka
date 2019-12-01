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
 * A function name tab completion Matcher.
 *
 * This matcher provides completion for all internal and user-defined functions.
 *
 * @author Marc Garcia <markcial@gmail.com>
 */
class FunctionsMatcher extends AbstractMatcher
{
    /**
     * {@inheritdoc}
     */
    public function getMatches(array $tokens, array $info = [])
    {
        $func = $this->getInput($tokens);

        $functions    = \get_defined_functions();
        $allFunctions = \array_merge($functions['user'], $functions['internal']);

        return \array_filter($allFunctions, function ($function) use ($func) {
            return AbstractMatcher::startsWith($func, $function);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function hasMatched(array $tokens)
    {
        $token     = \array_pop($tokens);
        $prevToken = \array_pop($tokens);

        switch (true) {
            case self::tokenIs($prevToken, self::T_NEW):
                return false;
            case self::hasToken([self::T_OPEN_TAG, self::T_STRING], $token):
            case self::isOperator($token):
                return true;
        }

        return false;
    }
}
