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

use Predis\Command\CommandInterface;

/**
 * A profile defines all the features and commands supported by certain versions
 * of Redis. Instances of Predis\Client should use a server profile matching the
 * version of Redis being used.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ProfileInterface
{
    /**
     * Returns the profile version corresponding to the Redis version.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Checks if the profile supports the specified command.
     *
     * @param string $commandID Command ID.
     *
     * @return bool
     */
    public function supportsCommand($commandID);

    /**
     * Checks if the profile supports the specified list of commands.
     *
     * @param array $commandIDs List of command IDs.
     *
     * @return string
     */
    public function supportsCommands(array $commandIDs);

    /**
     * Creates a new command instance.
     *
     * @param string $commandID Command ID.
     * @param array  $arguments Arguments for the command.
     *
     * @return CommandInterface
     */
    public function createCommand($commandID, array $arguments = array());
}
