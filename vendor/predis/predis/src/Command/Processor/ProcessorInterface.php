<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Processor;

use Predis\Command\CommandInterface;

/**
 * A command processor processes Redis commands before they are sent to Redis.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ProcessorInterface
{
    /**
     * Processes the given Redis command.
     *
     * @param CommandInterface $command Command instance.
     */
    public function process(CommandInterface $command);
}
