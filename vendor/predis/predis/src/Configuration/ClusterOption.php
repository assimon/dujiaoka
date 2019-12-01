<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Configuration;

use Predis\Connection\Aggregate\ClusterInterface;
use Predis\Connection\Aggregate\PredisCluster;
use Predis\Connection\Aggregate\RedisCluster;

/**
 * Configures an aggregate connection used for clustering
 * multiple Redis nodes using various implementations with
 * different algorithms or strategies.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ClusterOption implements OptionInterface
{
    /**
     * Creates a new cluster connection from on a known descriptive name.
     *
     * @param OptionsInterface $options Instance of the client options.
     * @param string           $id      Descriptive identifier of the cluster type (`predis`, `redis-cluster`)
     *
     * @return ClusterInterface|null
     */
    protected function createByDescription(OptionsInterface $options, $id)
    {
        switch ($id) {
            case 'predis':
            case 'predis-cluster':
                return new PredisCluster();

            case 'redis':
            case 'redis-cluster':
                return new RedisCluster($options->connections);

            default:
                return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filter(OptionsInterface $options, $value)
    {
        if (is_string($value)) {
            $value = $this->createByDescription($options, $value);
        }

        if (!$value instanceof ClusterInterface) {
            throw new \InvalidArgumentException(
                "An instance of type 'Predis\Connection\Aggregate\ClusterInterface' was expected."
            );
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        return new PredisCluster();
    }
}
