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
use Predis\Cluster\Distributor\HashRing;

/**
 * Default cluster strategy used by Predis to handle client-side sharding.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class PredisStrategy extends ClusterStrategy
{
    protected $distributor;

    /**
     * @param DistributorInterface $distributor Optional distributor instance.
     */
    public function __construct(DistributorInterface $distributor = null)
    {
        parent::__construct();

        $this->distributor = $distributor ?: new HashRing();
    }

    /**
     * {@inheritdoc}
     */
    public function getSlotByKey($key)
    {
        $key = $this->extractKeyTag($key);
        $hash = $this->distributor->hash($key);
        $slot = $this->distributor->getSlot($hash);

        return $slot;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkSameSlotForKeys(array $keys)
    {
        if (!$count = count($keys)) {
            return false;
        }

        $currentKey = $this->extractKeyTag($keys[0]);

        for ($i = 1; $i < $count; ++$i) {
            $nextKey = $this->extractKeyTag($keys[$i]);

            if ($currentKey !== $nextKey) {
                return false;
            }

            $currentKey = $nextKey;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDistributor()
    {
        return $this->distributor;
    }
}
