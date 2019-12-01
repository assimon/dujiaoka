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

use Predis\Connection\Aggregate\MasterSlaveReplication;
use Predis\Connection\Aggregate\ReplicationInterface;
use Predis\Connection\Aggregate\SentinelReplication;

/**
 * Configures an aggregate connection used for master/slave replication among
 * multiple Redis nodes.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ReplicationOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     *
     * @todo There's more code than needed due to a bug in filter_var() as
     *       discussed here https://bugs.php.net/bug.php?id=49510 and  different
     *       behaviours when encountering NULL values on PHP 5.3.
     */
    public function filter(OptionsInterface $options, $value)
    {
        if ($value instanceof ReplicationInterface) {
            return $value;
        }

        if (is_bool($value) || $value === null) {
            return $value ? $this->getDefault($options) : null;
        }

        if ($value === 'sentinel') {
            return function ($sentinels, $options) {
                return new SentinelReplication($options->service, $sentinels, $options->connections);
            };
        }

        if (
            !is_object($value) &&
            null !== $asbool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        ) {
            return $asbool ? $this->getDefault($options) : null;
        }

        throw new \InvalidArgumentException(
            "An instance of type 'Predis\Connection\Aggregate\ReplicationInterface' was expected."
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        $replication = new MasterSlaveReplication();

        if ($options->autodiscovery) {
            $replication->setConnectionFactory($options->connections);
            $replication->setAutoDiscovery(true);
        }

        return $replication;
    }
}
