<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Connection\Aggregate;

use Predis\Cluster\PredisStrategy;
use Predis\Cluster\StrategyInterface;
use Predis\Command\CommandInterface;
use Predis\Connection\NodeConnectionInterface;
use Predis\NotSupportedException;

/**
 * Abstraction for a cluster of aggregate connections to various Redis servers
 * implementing client-side sharding based on pluggable distribution strategies.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 *
 * @todo Add the ability to remove connections from pool.
 */
class PredisCluster implements ClusterInterface, \IteratorAggregate, \Countable
{
    private $pool;
    private $strategy;
    private $distributor;

    /**
     * @param StrategyInterface $strategy Optional cluster strategy.
     */
    public function __construct(StrategyInterface $strategy = null)
    {
        $this->pool = array();
        $this->strategy = $strategy ?: new PredisStrategy();
        $this->distributor = $this->strategy->getDistributor();
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        foreach ($this->pool as $connection) {
            if ($connection->isConnected()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        foreach ($this->pool as $connection) {
            $connection->connect();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        foreach ($this->pool as $connection) {
            $connection->disconnect();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(NodeConnectionInterface $connection)
    {
        $parameters = $connection->getParameters();

        if (isset($parameters->alias)) {
            $this->pool[$parameters->alias] = $connection;
        } else {
            $this->pool[] = $connection;
        }

        $weight = isset($parameters->weight) ? $parameters->weight : null;
        $this->distributor->add($connection, $weight);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeConnectionInterface $connection)
    {
        if (($id = array_search($connection, $this->pool, true)) !== false) {
            unset($this->pool[$id]);
            $this->distributor->remove($connection);

            return true;
        }

        return false;
    }

    /**
     * Removes a connection instance using its alias or index.
     *
     * @param string $connectionID Alias or index of a connection.
     *
     * @return bool Returns true if the connection was in the pool.
     */
    public function removeById($connectionID)
    {
        if ($connection = $this->getConnectionById($connectionID)) {
            return $this->remove($connection);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(CommandInterface $command)
    {
        $slot = $this->strategy->getSlot($command);

        if (!isset($slot)) {
            throw new NotSupportedException(
                "Cannot use '{$command->getId()}' over clusters of connections."
            );
        }

        $node = $this->distributor->getBySlot($slot);

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectionById($connectionID)
    {
        return isset($this->pool[$connectionID]) ? $this->pool[$connectionID] : null;
    }

    /**
     * Retrieves a connection instance from the cluster using a key.
     *
     * @param string $key Key string.
     *
     * @return NodeConnectionInterface
     */
    public function getConnectionByKey($key)
    {
        $hash = $this->strategy->getSlotByKey($key);
        $node = $this->distributor->getBySlot($hash);

        return $node;
    }

    /**
     * Returns the underlying command hash strategy used to hash commands by
     * using keys found in their arguments.
     *
     * @return StrategyInterface
     */
    public function getClusterStrategy()
    {
        return $this->strategy;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->pool);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->pool);
    }

    /**
     * {@inheritdoc}
     */
    public function writeRequest(CommandInterface $command)
    {
        $this->getConnection($command)->writeRequest($command);
    }

    /**
     * {@inheritdoc}
     */
    public function readResponse(CommandInterface $command)
    {
        return $this->getConnection($command)->readResponse($command);
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(CommandInterface $command)
    {
        return $this->getConnection($command)->executeCommand($command);
    }

    /**
     * Executes the specified Redis command on all the nodes of a cluster.
     *
     * @param CommandInterface $command A Redis command.
     *
     * @return array
     */
    public function executeCommandOnNodes(CommandInterface $command)
    {
        $responses = array();

        foreach ($this->pool as $connection) {
            $responses[] = $connection->executeCommand($command);
        }

        return $responses;
    }
}
