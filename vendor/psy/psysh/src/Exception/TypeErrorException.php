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
 * A "type error" Exception for Psy.
 */
class TypeErrorException extends \Exception implements Exception
{
    private $rawMessage;

    /**
     * Constructor!
     *
     * @param string $message (default: "")
     * @param int    $code    (default: 0)
     */
    public function __construct($message = '', $code = 0)
    {
        $this->rawMessage = $message;
        $message = \preg_replace('/, called in .*?: eval\\(\\)\'d code/', '', $message);
        parent::__construct(\sprintf('TypeError: %s', $message), $code);
    }

    /**
     * Get the raw (unformatted) message for this error.
     *
     * @return string
     */
    public function getRawMessage()
    {
        return $this->rawMessage;
    }

    /**
     * Create a TypeErrorException from a TypeError.
     *
     * @param \TypeError $e
     *
     * @return TypeErrorException
     */
    public static function fromTypeError(\TypeError $e)
    {
        return new self($e->getMessage(), $e->getCode());
    }
}
