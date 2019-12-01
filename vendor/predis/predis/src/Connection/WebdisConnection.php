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
use Predis\NotSupportedException;
use Predis\Protocol\ProtocolException;
use Predis\Response\Error as ErrorResponse;
use Predis\Response\Status as StatusResponse;

/**
 * This class implements a Predis connection that actually talks with Webdis
 * instead of connecting directly to Redis. It relies on the cURL extension to
 * communicate with the web server and the phpiredis extension to parse the
 * protocol for responses returned in the http response bodies.
 *
 * Some features are not yet available or they simply cannot be implemented:
 *   - Pipelining commands.
 *   - Publish / Subscribe.
 *   - MULTI / EXEC transactions (not yet supported by Webdis).
 *
 * The connection parameters supported by this class are:
 *
 *  - scheme: must be 'http'.
 *  - host: hostname or IP address of the server.
 *  - port: TCP port of the server.
 *  - timeout: timeout to perform the connection (default is 5 seconds).
 *  - user: username for authentication.
 *  - pass: password for authentication.
 *
 * @link http://webd.is
 * @link http://github.com/nicolasff/webdis
 * @link http://github.com/seppo0010/phpiredis
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class WebdisConnection implements NodeConnectionInterface
{
    private $parameters;
    private $resource;
    private $reader;

    /**
     * @param ParametersInterface $parameters Initialization parameters for the connection.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(ParametersInterface $parameters)
    {
        $this->assertExtensions();

        if ($parameters->scheme !== 'http') {
            throw new \InvalidArgumentException("Invalid scheme: '{$parameters->scheme}'.");
        }

        $this->parameters = $parameters;

        $this->resource = $this->createCurl();
        $this->reader = $this->createReader();
    }

    /**
     * Frees the underlying cURL and protocol reader resources when the garbage
     * collector kicks in.
     */
    public function __destruct()
    {
        curl_close($this->resource);
        phpiredis_reader_destroy($this->reader);
    }

    /**
     * Helper method used to throw on unsupported methods.
     *
     * @param string $method Name of the unsupported method.
     *
     * @throws NotSupportedException
     */
    private function throwNotSupportedException($method)
    {
        $class = __CLASS__;
        throw new NotSupportedException("The method $class::$method() is not supported.");
    }

    /**
     * Checks if the cURL and phpiredis extensions are loaded in PHP.
     */
    private function assertExtensions()
    {
        if (!extension_loaded('curl')) {
            throw new NotSupportedException(
                'The "curl" extension is required by this connection backend.'
            );
        }

        if (!extension_loaded('phpiredis')) {
            throw new NotSupportedException(
                'The "phpiredis" extension is required by this connection backend.'
            );
        }
    }

    /**
     * Initializes cURL.
     *
     * @return resource
     */
    private function createCurl()
    {
        $parameters = $this->getParameters();
        $timeout = (isset($parameters->timeout) ? (float) $parameters->timeout : 5.0) * 1000;

        if (filter_var($host = $parameters->host, FILTER_VALIDATE_IP)) {
            $host = "[$host]";
        }

        $options = array(
            CURLOPT_FAILONERROR => true,
            CURLOPT_CONNECTTIMEOUT_MS => $timeout,
            CURLOPT_URL => "$parameters->scheme://$host:$parameters->port",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_WRITEFUNCTION => array($this, 'feedReader'),
        );

        if (isset($parameters->user, $parameters->pass)) {
            $options[CURLOPT_USERPWD] = "{$parameters->user}:{$parameters->pass}";
        }

        curl_setopt_array($resource = curl_init(), $options);

        return $resource;
    }

    /**
     * Initializes the phpiredis protocol reader.
     *
     * @return resource
     */
    private function createReader()
    {
        $reader = phpiredis_reader_create();

        phpiredis_reader_set_status_handler($reader, $this->getStatusHandler());
        phpiredis_reader_set_error_handler($reader, $this->getErrorHandler());

        return $reader;
    }

    /**
     * Returns the handler used by the protocol reader for inline responses.
     *
     * @return \Closure
     */
    protected function getStatusHandler()
    {
        static $statusHandler;

        if (!$statusHandler) {
            $statusHandler = function ($payload) {
                return StatusResponse::get($payload);
            };
        }

        return $statusHandler;
    }

    /**
     * Returns the handler used by the protocol reader for error responses.
     *
     * @return \Closure
     */
    protected function getErrorHandler()
    {
        static $errorHandler;

        if (!$errorHandler) {
            $errorHandler = function ($errorMessage) {
                return new ErrorResponse($errorMessage);
            };
        }

        return $errorHandler;
    }

    /**
     * Feeds the phpredis reader resource with the data read from the network.
     *
     * @param resource $resource Reader resource.
     * @param string   $buffer   Buffer of data read from a connection.
     *
     * @return int
     */
    protected function feedReader($resource, $buffer)
    {
        phpiredis_reader_feed($this->reader, $buffer);

        return strlen($buffer);
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        // NOOP
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        // NOOP
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        return true;
    }

    /**
     * Checks if the specified command is supported by this connection class.
     *
     * @param CommandInterface $command Command instance.
     *
     * @throws NotSupportedException
     *
     * @return string
     */
    protected function getCommandId(CommandInterface $command)
    {
        switch ($commandID = $command->getId()) {
            case 'AUTH':
            case 'SELECT':
            case 'MULTI':
            case 'EXEC':
            case 'WATCH':
            case 'UNWATCH':
            case 'DISCARD':
            case 'MONITOR':
                throw new NotSupportedException("Command '$commandID' is not allowed by Webdis.");

            default:
                return $commandID;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writeRequest(CommandInterface $command)
    {
        $this->throwNotSupportedException(__FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function readResponse(CommandInterface $command)
    {
        $this->throwNotSupportedException(__FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(CommandInterface $command)
    {
        $resource = $this->resource;
        $commandId = $this->getCommandId($command);

        if ($arguments = $command->getArguments()) {
            $arguments = implode('/', array_map('urlencode', $arguments));
            $serializedCommand = "$commandId/$arguments.raw";
        } else {
            $serializedCommand = "$commandId.raw";
        }

        curl_setopt($resource, CURLOPT_POSTFIELDS, $serializedCommand);

        if (curl_exec($resource) === false) {
            $error = curl_error($resource);
            $errno = curl_errno($resource);

            throw new ConnectionException($this, trim($error), $errno);
        }

        if (phpiredis_reader_get_state($this->reader) !== PHPIREDIS_READER_STATE_COMPLETE) {
            throw new ProtocolException($this, phpiredis_reader_get_error($this->reader));
        }

        return phpiredis_reader_get_reply($this->reader);
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
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
     * {@inheritdoc}
     */
    public function addConnectCommand(CommandInterface $command)
    {
        $this->throwNotSupportedException(__FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        $this->throwNotSupportedException(__FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->parameters->host}:{$this->parameters->port}";
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array('parameters');
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup()
    {
        $this->assertExtensions();

        $this->resource = $this->createCurl();
        $this->reader = $this->createReader();
    }
}
