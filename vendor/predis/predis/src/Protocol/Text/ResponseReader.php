<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Protocol\Text;

use Predis\CommunicationException;
use Predis\Connection\CompositeConnectionInterface;
use Predis\Protocol\ProtocolException;
use Predis\Protocol\ResponseReaderInterface;

/**
 * Response reader for the standard Redis wire protocol.
 *
 * @link http://redis.io/topics/protocol
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ResponseReader implements ResponseReaderInterface
{
    protected $handlers;

    /**
     *
     */
    public function __construct()
    {
        $this->handlers = $this->getDefaultHandlers();
    }

    /**
     * Returns the default handlers for the supported type of responses.
     *
     * @return array
     */
    protected function getDefaultHandlers()
    {
        return array(
            '+' => new Handler\StatusResponse(),
            '-' => new Handler\ErrorResponse(),
            ':' => new Handler\IntegerResponse(),
            '$' => new Handler\BulkResponse(),
            '*' => new Handler\MultiBulkResponse(),
        );
    }

    /**
     * Sets the handler for the specified prefix identifying the response type.
     *
     * @param string                           $prefix  Identifier of the type of response.
     * @param Handler\ResponseHandlerInterface $handler Response handler.
     */
    public function setHandler($prefix, Handler\ResponseHandlerInterface $handler)
    {
        $this->handlers[$prefix] = $handler;
    }

    /**
     * Returns the response handler associated to a certain type of response.
     *
     * @param string $prefix Identifier of the type of response.
     *
     * @return Handler\ResponseHandlerInterface
     */
    public function getHandler($prefix)
    {
        if (isset($this->handlers[$prefix])) {
            return $this->handlers[$prefix];
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function read(CompositeConnectionInterface $connection)
    {
        $header = $connection->readLine();

        if ($header === '') {
            $this->onProtocolError($connection, 'Unexpected empty reponse header.');
        }

        $prefix = $header[0];

        if (!isset($this->handlers[$prefix])) {
            $this->onProtocolError($connection, "Unknown response prefix: '$prefix'.");
        }

        $payload = $this->handlers[$prefix]->handle($connection, substr($header, 1));

        return $payload;
    }

    /**
     * Handles protocol errors generated while reading responses from a
     * connection.
     *
     * @param CompositeConnectionInterface $connection Redis connection that generated the error.
     * @param string                       $message    Error message.
     */
    protected function onProtocolError(CompositeConnectionInterface $connection, $message)
    {
        CommunicationException::handle(
            new ProtocolException($connection, $message)
        );
    }
}
