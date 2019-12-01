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
 * A variable name tab completion Matcher.
 *
 * This matcher provides completion for variable names in the current Context.
 *
 * @author Marc Garcia <markcial@gmail.com>
 */
class VariablesMatcher extends AbstractContextAwareMatcher
{
    /**
     * {@inheritdoc}
     */
    public function getMatches(array $tokens, array $info = [])
    {
        $var = \str_replace('$', '', $this->getInput($tokens));

        return \array_filter(\array_keys($this->getVariables()), function ($variable) use ($var) {
            return AbstractMatcher::startsWith($var, $variable);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function hasMatched(array $tokens)
    {
        $token = \array_pop($tokens);

        switch (true) {
            case self::hasToken([self::T_OPEN_TAG, self::T_VARIABLE], $token):
            case \is_string($token) && $token === '$':
            case self::isOperator($token):
                return true;
        }

        return false;
    }
}
