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

// When you have a whole set of consecutive commands to send to a redis server,
// you can use a pipeline to dramatically improve performances. Pipelines can
// greatly reduce the effects of network round-trips.

$client = new Predis\Client($single_server);

$responses = $client->pipeline(function ($pipe) {
    $pipe->flushdb();
    $pipe->incrby('counter', 10);
    $pipe->incrby('counter', 30);
    $pipe->exists('counter');
    $pipe->get('counter');
    $pipe->mget('does_not_exist', 'counter');
});

var_export($responses);

/* OUTPUT:
array (
  0 => Predis\Response\Status::__set_state(array(
    'payload' => 'OK',
  )),
  1 => 10,
  2 => 40,
  3 => true,
  4 => '40',
  5 => array (
    0 => NULL,
    1 => '40',
  ),
)
*/
