<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\TabCompletion;

use Psy\TabCompletion\Matcher\AbstractMatcher;

/**
 * A readline tab completion service.
 *
 * @author Marc Garcia <markcial@gmail.com>
 */
class AutoCompleter
{
    /** @var Matcher\AbstractMatcher[] */
    protected $matchers;

    /**
     * Register a tab completion Matcher.
     *
     * @param AbstractMatcher $matcher
     */
    public function addMatcher(AbstractMatcher $matcher)
    {
        $this->matchers[] = $matcher;
    }

    /**
     * Activate readline tab completion.
     */
    public function activate()
    {
        \readline_completion_function([&$this, 'callback']);
    }

    /**
     * Handle readline completion.
     *
     * @param string $input Readline current word
     * @param int    $index Current word index
     * @param array  $info  readline_info() data
     *
     * @return array
     */
    public function processCallback($input, $index, $info = [])
    {
        // Some (Windows?) systems provide incomplete `readline_info`, so let's
        // try to work around it.
        $line = $info['line_buffer'];
        if (isset($info['end'])) {
            $line = \substr($line, 0, $info['end']);
        }
        if ($line === '' && $input !== '') {
            $line = $input;
        }

        $tokens = \token_get_all('<?php ' . $line);

        // remove whitespaces
        $tokens = \array_filter($tokens, function ($token) {
            return !AbstractMatcher::tokenIs($token, AbstractMatcher::T_WHITESPACE);
        });

        $matches = [];
        foreach ($this->matchers as $matcher) {
            if ($matcher->hasMatched($tokens)) {
                $matches = \array_merge($matcher->getMatches($tokens), $matches);
            }
        }

        $matches = \array_unique($matches);

        return !empty($matches) ? $matches : [''];
    }

    /**
     * The readline_completion_function callback handler.
     *
     * @see processCallback
     *
     * @param string $input
     * @param int    $index
     *
     * @return array
     */
    public function callback($input, $index)
    {
        return $this->processCallback($input, $index, \readline_info());
    }

    /**
     * Remove readline callback handler on destruct.
     */
    public function __destruct()
    {
        // PHP didn't implement the whole readline API when they first switched
        // to libedit. And they still haven't.
        if (\function_exists('readline_callback_handler_remove')) {
            \readline_callback_handler_remove();
        }
    }
}
