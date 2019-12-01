<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command;

/**
 * Defines an abstraction representing a Redis command.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface CommandInterface
{
    /**
     * Returns the ID of the Redis command. By convention, command identifiers
     * must always be uppercase.
     *
     * @return string
     */
    public function getId();

    /**
     * Assign the specified slot to the command for clustering distribution.
     *
     * @param int $slot Slot ID.
     */
    public function setSlot($slot);

    /**
     * Returns the assigned slot of the command for clustering distribution.
     *
     * @return int|null
     */
    public function getSlot();

    /**
     * Sets the arguments for the command.
     *
     * @param array $arguments List of arguments.
     */
    public function setArguments(array $arguments);

    /**
     * Sets the raw arguments for the command without processing them.
     *
     * @param array $arguments List of arguments.
     */
    public function setRawArguments(array $arguments);

    /**
     * Gets the arguments of the command.
     *
     * @return array
     */
    public function getArguments();

    /**
     * Gets the argument of the command at the specified index.
     *
     * @param int $index Index of the desired argument.
     *
     * @return mixed|null
     */
    public function getArgument($index);

    /**
     * Parses a raw response and returns a PHP object.
     *
     * @param string $data Binary string containing the whole response.
     *
     * @return mixed
     */
    public function parseResponse($data);
}
