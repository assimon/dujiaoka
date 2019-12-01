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
 * A custom error Exception for Psy with a formatted $message.
 */
class ErrorException extends \ErrorException implements Exception
{
    private $rawMessage;

    /**
     * Construct a Psy ErrorException.
     *
     * @param string    $message  (default: "")
     * @param int       $code     (default: 0)
     * @param int       $severity (default: 1)
     * @param string    $filename (default: null)
     * @param int       $lineno   (default: null)
     * @param Exception $previous (default: null)
     */
    public function __construct($message = '', $code = 0, $severity = 1, $filename = null, $lineno = null, $previous = null)
    {
        $this->rawMessage = $message;

        if (!empty($filename) && \preg_match('{Psy[/\\\\]ExecutionLoop}', $filename)) {
            $filename = '';
        }

        switch ($severity) {
            case E_STRICT:
                $type = 'Strict error';
                break;

            case E_NOTICE:
            case E_USER_NOTICE:
                $type = 'Notice';
                break;

            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                $type = 'Warning';
                break;

            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                $type = 'Deprecated';
                break;

            case E_RECOVERABLE_ERROR:
                $type = 'Recoverable fatal error';
                break;

            default:
                $type = 'Error';
                break;
        }

        $message = \sprintf('PHP %s:  %s%s on line %d', $type, $message, $filename ? ' in ' . $filename : '', $lineno);
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
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
     * Helper for throwing an ErrorException.
     *
     * This allows us to:
     *
     *     set_error_handler(array('Psy\Exception\ErrorException', 'throwException'));
     *
     * @throws ErrorException
     *
     * @param int    $errno   Error type
     * @param string $errstr  Message
     * @param string $errfile Filename
     * @param int    $errline Line number
     */
    public static function throwException($errno, $errstr, $errfile, $errline)
    {
        throw new self($errstr, 0, $errno, $errfile, $errline);
    }

    /**
     * Create an ErrorException from an Error.
     *
     * @param \Error $e
     *
     * @return ErrorException
     */
    public static function fromError(\Error $e)
    {
        return new self($e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e);
    }
}
