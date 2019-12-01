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

// Predis supports redis-sentinel to provide high availability in master / slave
// scenarios. The only but relevant difference with a basic replication scenario
// is that sentinel servers can manage the master server and its slaves based on
// their state, which means that they are able to provide an authoritative and
// updated configuration to clients thus avoiding static configurations for the
// replication servers and their roles.

// Instead of connection parameters pointing to redis nodes, we provide a list
// of instances of redis-sentinel. Users should always provide a timeout value
// low enough to not hinder operations just in case a sentinel is unreachable
// but Predis uses a default value of 100 milliseconds for sentinel parameters
// without an explicit timeout value.
//
// NOTE: in real-world scenarios sentinels should be running on different hosts!
$sentinels = array(
    'tcp://127.0.0.1:5380?timeout=0.100',
    'tcp://127.0.0.1:5381?timeout=0.100',
    'tcp://127.0.0.1:5382?timeout=0.100',
);

$client = new Predis\Client($sentinels, array(
    'replication' => 'sentinel',
    'service' => 'mymaster',
));

// Read operation.
$exists = $client->exists('foo') ? 'yes' : 'no';
$current = $client->getConnection()->getCurrent()->getParameters();
echo "Does 'foo' exist on {$current->alias}? $exists.", PHP_EOL;

// Write operation.
$client->set('foo', 'bar');
$current = $client->getConnection()->getCurrent()->getParameters();
echo "Now 'foo' has been set to 'bar' on {$current->alias}!", PHP_EOL;

// Read operation.
$bar = $client->get('foo');
$current = $client->getConnection()->getCurrent()->getParameters();
echo "We fetched 'foo' from {$current->alias} and its value is '$bar'.", PHP_EOL;

/* OUTPUT:
Does 'foo' exist on slave-127.0.0.1:6381? yes.
Now 'foo' has been set to 'bar' on master!
We fetched 'foo' from master and its value is 'bar'.
*/
