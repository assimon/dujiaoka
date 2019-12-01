<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Connection;

use Predis\Command\CommandInterface;
use Predis\CommunicationException;
use Predis\Protocol\ProtocolException;

/**
 * Base class with the common logic used by connection classes to communicate
 * with Redis.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class AbstractConnection implements NodeConnectionInterface
{
    private $resource;
    private $cachedId;

    protected $parameters;
    protected $initCommands = array();

    /**
     * @param ParametersInterface $parameters Initialization parameters for the connection.
     */
    public function __construct(ParametersInterface $parameters)
    {
        $this->parameters = $this->assertParameters($parameters);
    }

    /**
     * Disconnects from the server and destroys the underlying resource when
     * PHP's garbage collector kicks in.
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Checks some of the parameters used to initialize the connection.
     *
     * @param ParametersInterface $parameters Initialization parameters for the connection.
     *
     * @throws \InvalidArgumentException
     *
     * @return ParametersInterface
     */
    abstract protected function assertParameters(ParametersInterface $parameters);

    /**
     * Creates the underlying resource used to communicate with Redis.
     *
     * @return mixed
     */
    abstract protected function createResource();

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        return isset($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        if (!$this->isConnected()) {
            $this->resource = $this->createResource();

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        unset($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function addConnectCommand(CommandInterface $command)
    {
        $this->initCommands[] = $command;
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(CommandInterface $command)
    {
        $this->writeRequest($command);

        return $this->readResponse($command);
    }

    /**
     * {@inheritdoc}
     */
    public function readResponse(CommandInterface $command)
    {
        return $this->read();
    }

    /**
     * Helper method that returns an exception message augmented with useful
     * details from the connection parameters.
     *
     * @param string $message Error message.
     *
     * @return string
     */
    private function createExceptionMessage($message)
    {
        $parameters = $this->parameters;

        if ($parameters->scheme === 'unix') {
            return "$message [$parameters->scheme:$parameters->path]";
        }

        if (filter_var($parameters->host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "$message [$parameters->scheme://[$parameters->host]:$parameters->port]";
        }

        return "$message [$parameters->scheme://$parameters->host:$parameters->port]";
    }

    /**
     * Helper method to handle connection errors.
     *
     * @param string $message Error message.
     * @param int    $code    Error code.
     */
    protected function onConnectionError($message, $code = null)
    {
        CommunicationException::handle(
            new ConnectionException($this, static::createExceptionMessage($message), $code)
        );
    }

    /**
     * Helper method to handle protocol errors.
     *
     * @param string $message Error message.
     */
    protected function onProtocolError($message)
    {
        CommunicationException::handle(
            new ProtocolException($this, static::createExceptionMessage($message))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        if (isset($this->resource)) {
            return $this->resource;
        }

        $this->connect();

        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Gets an identifier for the connection.
     *
     * @return string
     */
    protected function getIdentifier()
    {
        if ($this->parameters->scheme === 'unix') {
            return $this->parameters->path;
        }

        return "{$this->parameters->host}:{$this->parameters->port}";
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if (!isset($this->cachedId)) {
            $this->cachedId = $this->getIdentifier();
        }

        return $this->cachedId;
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('parameters', 'initCommands');
    }
}
