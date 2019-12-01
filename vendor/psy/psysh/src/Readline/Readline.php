<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Readline;

/**
 * An interface abstracting the various readline_* functions.
 */
interface Readline
{
    /**
     * Check whether this Readline class is supported by the current system.
     *
     * @return bool
     */
    public static function isSupported();

    /**
     * Add a line to the command history.
     *
     * @param string $line
     *
     * @return bool Success
     */
    public function addHistory($line);

    /**
     * Clear the command history.
     *
     * @return bool Success
     */
    public function clearHistory();

    /**
     * List the command history.
     *
     * @return array
     */
    public function listHistory();

    /**
     * Read the command history.
     *
     * @return bool Success
     */
    public function readHistory();

    /**
     * Read a single line of input from the user.
     *
     * @param null|string $prompt
     *
     * @return false|string
     */
    public function readline($prompt = null);

    /**
     * Redraw readline to redraw the display.
     */
    public function redisplay();

    /**
     * Write the command history to a file.
     *
     * @return bool Success
     */
    public function writeHistory();
}
