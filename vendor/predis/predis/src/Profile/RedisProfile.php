<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Profile;

use Predis\ClientException;
use Predis\Command\Processor\ProcessorInterface;

/**
 * Base class implementing common functionalities for Redis server profiles.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class RedisProfile implements ProfileInterface
{
    private $commands;
    private $processor;

    /**
     *
     */
    public function __construct()
    {
        $this->commands = $this->getSupportedCommands();
    }

    /**
     * Returns a map of all the commands supported by the profile and their
     * actual PHP classes.
     *
     * @return array
     */
    abstract protected function getSupportedCommands();

    /**
     * {@inheritdoc}
     */
    public function supportsCommand($commandID)
    {
        return isset($this->commands[strtoupper($commandID)]);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsCommands(array $commandIDs)
    {
        foreach ($commandIDs as $commandID) {
            if (!$this->supportsCommand($commandID)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the fully-qualified name of a class representing the specified
     * command ID registered in the current server profile.
     *
     * @param string $commandID Command ID.
     *
     * @return string|null
     */
    public function getCommandClass($commandID)
    {
        if (isset($this->commands[$commandID = strtoupper($commandID)])) {
            return $this->commands[$commandID];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createCommand($commandID, array $arguments = array())
    {
        $commandID = strtoupper($commandID);

        if (!isset($this->commands[$commandID])) {
            throw new ClientException("Command '$commandID' is not a registered Redis command.");
        }

        $commandClass = $this->commands[$commandID];
        $command = new $commandClass();
        $command->setArguments($arguments);

        if (isset($this->processor)) {
            $this->processor->process($command);
        }

        return $command;
    }

    /**
     * Defines a new command in the server profile.
     *
     * @param string $commandID Command ID.
     * @param string $class     Fully-qualified name of a Predis\Command\CommandInterface.
     *
     * @throws \InvalidArgumentException
     */
    public function defineCommand($commandID, $class)
    {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->isSubclassOf('Predis\Command\CommandInterface')) {
            throw new \InvalidArgumentException("The class '$class' is not a valid command class.");
        }

        $this->commands[strtoupper($commandID)] = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function setProcessor(ProcessorInterface $processor = null)
    {
        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * Returns the version of server profile as its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getVersion();
    }
}
