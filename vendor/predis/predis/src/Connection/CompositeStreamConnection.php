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
use Predis\Protocol\ProtocolProcessorInterface;
use Predis\Protocol\Text\ProtocolProcessor as TextProtocolProcessor;

/**
 * Connection abstraction to Redis servers based on PHP's stream that uses an
 * external protocol processor defining the protocol used for the communication.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class CompositeStreamConnection extends StreamConnection implements CompositeConnectionInterface
{
    protected $protocol;

    /**
     * @param ParametersInterface        $parameters Initialization parameters for the connection.
     * @param ProtocolProcessorInterface $protocol   Protocol processor.
     */
    public function __construct(
        ParametersInterface $parameters,
        ProtocolProcessorInterface $protocol = null
    ) {
        $this->parameters = $this->assertParameters($parameters);
        $this->protocol = $protocol ?: new TextProtocolProcessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * {@inheritdoc}
     */
    public function writeBuffer($buffer)
    {
        $this->write($buffer);
    }

    /**
     * {@inheritdoc}
     */
    public function readBuffer($length)
    {
        if ($length <= 0) {
            throw new \InvalidArgumentException('Length parameter must be greater than 0.');
        }

        $value = '';
        $socket = $this->getResource();

        do {
            $chunk = fread($socket, $length);

            if ($chunk === false || $chunk === '') {
                $this->onConnectionError('Error while reading bytes from the server.');
            }

            $value .= $chunk;
        } while (($length -= strlen($chunk)) > 0);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function readLine()
    {
        $value = '';
        $socket = $this->getResource();

        do {
            $chunk = fgets($socket);

            if ($chunk === false || $chunk === '') {
                $this->onConnectionError('Error while reading line from the server.');
            }

            $value .= $chunk;
        } while (substr($value, -2) !== "\r\n");

        return substr($value, 0, -2);
    }

    /**
     * {@inheritdoc}
     */
    public function writeRequest(CommandInterface $command)
    {
        $this->protocol->write($this, $command);
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        return $this->protocol->read($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array_merge(parent::__sleep(), array('protocol'));
    }
}
