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
 * A RuntimeException for Psy.
 */
class RuntimeException extends \RuntimeException implements Exception
{
    private $rawMessage;

    /**
     * Make this bad boy.
     *
     * @param string     $message  (default: "")
     * @param int        $code     (default: 0)
     * @param \Exception $previous (default: null)
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        $this->rawMessage = $message;
        parent::__construct($message, $code, $previous);
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
