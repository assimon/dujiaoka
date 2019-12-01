<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Response;

/**
 * Represents an error returned by Redis (responses identified by "-" in the
 * Redis protocol) during the execution of an operation on the server.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ErrorInterface extends ResponseInterface
{
    /**
     * Returns the error message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Returns the error type (e.g. ERR, ASK, MOVED).
     *
     * @return string
     */
    public function getErrorType();
}
