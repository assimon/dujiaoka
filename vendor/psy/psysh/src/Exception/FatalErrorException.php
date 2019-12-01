<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Exception;

/**
 * A "fatal error" Exception for Psy.
 */
class FatalErrorException extends \ErrorException implements Exception
{
    private $rawMessage;

    /**
     * Create a fatal error.
     *
     * @param string     $message  (default: "")
     * @param int        $code     (default: 0)
     * @param int        $severity (default: 1)
     * @param string     $filename (default: null)
     * @param int        $lineno   (default: null)
     * @param \Exception $previous (default: null)
     */
    public function __construct($message = '', $code = 0, $severity = 1, $filename = null, $lineno = null, $previous = null)
    {
        // Since these are basically always PHP Parser Node line numbers, treat -1 as null.
        if ($lineno === -1) {
            $lineno = null;
        }

        $this->rawMessage = $message;
        $message = \sprintf('PHP Fatal error:  %s in %s on line %d', $message, $filename ?: "eval()'d code", $lineno);
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
    }

    /**
     * Return a raw (unformatted) version of the error message.
     *
     * @return string
     */
    public function getRawMessage()
    {
        return $this->rawMessage;
    }
}
