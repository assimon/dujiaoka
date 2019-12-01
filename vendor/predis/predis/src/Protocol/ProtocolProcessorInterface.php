<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Protocol;

use Predis\Command\CommandInterface;
use Predis\Connection\CompositeConnectionInterface;

/**
 * Defines a pluggable protocol processor capable of serializing commands and
 * deserializing responses into PHP objects directly from a connection.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ProtocolProcessorInterface
{
    /**
     * Writes a request over a connection to Redis.
     *
     * @param CompositeConnectionInterface $connection Redis connection.
     * @param CommandInterface             $command    Command instance.
     */
    public function write(CompositeConnectionInterface $connection, CommandInterface $command);

    /**
     * Reads a response from a connection to Redis.
     *
     * @param CompositeConnectionInterface $connection Redis connection.
     *
     * @return mixed
     */
    public function read(CompositeConnectionInterface $connection);
}
