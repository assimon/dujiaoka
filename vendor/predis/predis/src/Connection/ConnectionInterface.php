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

/**
 * Defines a connection object used to communicate with one or multiple
 * Redis servers.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * Opens the connection to Redis.
     */
    public function connect();

    /**
     * Closes the connection to Redis.
     */
    public function disconnect();

    /**
     * Checks if the connection to Redis is considered open.
     *
     * @return bool
     */
    public function isConnected();

    /**
     * Writes the request for the given command over the connection.
     *
     * @param CommandInterface $command Command instance.
     */
    public function writeRequest(CommandInterface $command);

    /**
     * Reads the response to the given command from the connection.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return mixed
     */
    public function readResponse(CommandInterface $command);

    /**
     * Writes a request for the given command over the connection and reads back
     * the response returned by Redis.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return mixed
     */
    public function executeCommand(CommandInterface $command);
}
