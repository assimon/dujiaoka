<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Cluster;

use Predis\Cluster\Distributor\DistributorInterface;
use Predis\Command\CommandInterface;

/**
 * Interface for classes defining the strategy used to calculate an hash out of
 * keys extracted from supported commands.
 *
 * This is mostly useful to support clustering via client-side sharding.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface StrategyInterface
{
    /**
     * Returns a slot for the given command used for clustering distribution or
     * NULL when this is not possible.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return int
     */
    public function getSlot(CommandInterface $command);

    /**
     * Returns a slot for the given key used for clustering distribution or NULL
     * when this is not possible.
     *
     * @param string $key Key string.
     *
     * @return int
     */
    public function getSlotByKey($key);

    /**
     * Returns a distributor instance to be used by the cluster.
     *
     * @return DistributorInterface
     */
    public function getDistributor();
}
