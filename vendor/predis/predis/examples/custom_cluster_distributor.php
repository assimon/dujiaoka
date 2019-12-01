<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/shared.php';

// Developers can implement Predis\Distribution\DistributorInterface to create
// their own distributors used by the client to distribute keys among a cluster
// of servers.

use Predis\Cluster\Distributor\DistributorInterface;
use Predis\Cluster\Hash\HashGeneratorInterface;
use Predis\Cluster\PredisStrategy;
use Predis\Connection\Aggregate\PredisCluster;

class NaiveDistributor implements DistributorInterface, HashGeneratorInterface
{
    private $nodes;
    private $nodesCount;

    public function __construct()
    {
        $this->nodes = array();
        $this->nodesCount = 0;
    }

    public function add($node, $weight = null)
    {
        $this->nodes[] = $node;
        ++$this->nodesCount;
    }

    public function remove($node)
    {
        $this->nodes = array_filter($this->nodes, function ($n) use ($node) {
            return $n !== $node;
        });

        $this->nodesCount = count($this->nodes);
    }

    public function getSlot($hash)
    {
        return $this->nodesCount > 1 ? abs($hash % $this->nodesCount) : 0;
    }

    public function getBySlot($slot)
    {
        return isset($this->nodes[$slot]) ? $this->nodes[$slot] : null;
    }

    public function getByHash($hash)
    {
        if (!$this->nodesCount) {
            throw new RuntimeException('No connections.');
        }

        $slot = $this->getSlot($hash);
        $node = $this->getBySlot($slot);

        return $node;
    }

    public function get($value)
    {
        $hash = $this->hash($value);
        $node = $this->getByHash($hash);

        return $node;
    }

    public function hash($value)
    {
        return crc32($value);
    }

    public function getHashGenerator()
    {
        return $this;
    }
}

$options = array(
    'cluster' => function () {
        $distributor = new NaiveDistributor();
        $strategy = new PredisStrategy($distributor);
        $cluster = new PredisCluster($strategy);

        return $cluster;
    },
);

$client = new Predis\Client($multiple_servers, $options);

for ($i = 0; $i < 100; ++$i) {
    $client->set("key:$i", str_pad($i, 4, '0', 0));
    $client->get("key:$i");
}

$server1 = $client->getClientFor('first')->info();
$server2 = $client->getClientFor('second')->info();

if (isset($server1['Keyspace'], $server2['Keyspace'])) {
    $server1 = $server1['Keyspace'];
    $server2 = $server2['Keyspace'];
}

printf("Server '%s' has %d keys while server '%s' has %d keys.\n",
    'first', $server1['db15']['keys'], 'second', $server2['db15']['keys']
);
