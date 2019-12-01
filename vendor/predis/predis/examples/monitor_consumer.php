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

// This is a basic example on how to use the Predis\Monitor\Consumer class. You
// can use redis-cli to send commands to the same Redis instance your client is
// connected to, and then type "ECHO QUIT_MONITOR" in redis-cli when you want to
// exit the monitor loop and terminate this script in a graceful way.

// Create a client and disable r/w timeout on the socket.
$client = new Predis\Client($single_server + array('read_write_timeout' => 0));

// Use only one instance of DateTime, we will update the timestamp later.
$timestamp = new DateTime();

foreach (($monitor = $client->monitor()) as $event) {
    $timestamp->setTimestamp((int) $event->timestamp);

    // If we notice a ECHO command with the message QUIT_MONITOR, we stop the
    // monitor consumer and then break the loop.
    if ($event->command === 'ECHO' && $event->arguments === '"QUIT_MONITOR"') {
        echo 'Exiting the monitor loop...', PHP_EOL;
        $monitor->stop();
        break;
    }

    echo "* Received {$event->command} on DB {$event->database} at {$timestamp->format(DateTime::W3C)}", PHP_EOL;
    if (isset($event->arguments)) {
        echo "    Arguments: {$event->arguments}", PHP_EOL;
    }
}

// Say goodbye :-)
$version = redis_version($client->info());
echo "Goodbye from Redis $version!", PHP_EOL;
