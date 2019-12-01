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

// Starting from Redis 2.0 clients can subscribe and listen for events published
// on certain channels using a Publish/Subscribe (PUB/SUB) approach.

// Create a client and disable r/w timeout on the socket
$client = new Predis\Client($single_server + array('read_write_timeout' => 0));

// Initialize a new pubsub consumer.
$pubsub = $client->pubSubLoop();

// Subscribe to your channels
$pubsub->subscribe('control_channel', 'notifications');

// Start processing the pubsup messages. Open a terminal and use redis-cli
// to push messages to the channels. Examples:
//   ./redis-cli PUBLISH notifications "this is a test"
//   ./redis-cli PUBLISH control_channel quit_loop
foreach ($pubsub as $message) {
    switch ($message->kind) {
        case 'subscribe':
            echo "Subscribed to {$message->channel}", PHP_EOL;
            break;

        case 'message':
            if ($message->channel == 'control_channel') {
                if ($message->payload == 'quit_loop') {
                    echo 'Aborting pubsub loop...', PHP_EOL;
                    $pubsub->unsubscribe();
                } else {
                    echo "Received an unrecognized command: {$message->payload}.", PHP_EOL;
                }
            } else {
                echo "Received the following message from {$message->channel}:",
                     PHP_EOL, "  {$message->payload}", PHP_EOL, PHP_EOL;
            }
            break;
    }
}

// Always unset the pubsub consumer instance when you are done! The
// class destructor will take care of cleanups and prevent protocol
// desynchronizations between the client and the server.
unset($pubsub);

// Say goodbye :-)
$version = redis_version($client->info());
echo "Goodbye from Redis $version!", PHP_EOL;
