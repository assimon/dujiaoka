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

// This example demonstrates how to use Predis to save PHP sessions on Redis.
//
// The value of `session.gc_maxlifetime` in `php.ini` will be used by default as
// the TTL for keys holding session data but this value can be overridden when
// creating the session handler instance using the `gc_maxlifetime` option.
//
// NOTE: this class requires PHP >= 5.4 but can be used on PHP 5.3 if a polyfill
// for SessionHandlerInterface is provided either by you or an external package
// like `symfony/http-foundation`.
//
// See http://www.php.net/class.sessionhandlerinterface.php for more details.
//

if (!interface_exists('SessionHandlerInterface')) {
    die('ATTENTION: the session handler implemented by Predis requires PHP >= 5.4.0 '.
        "or a polyfill for SessionHandlerInterface provided by an external package.\n");
}

// Instantiate a new client just like you would normally do. Using a prefix for
// keys will effectively prefix all session keys with the specified string.
$client = new Predis\Client($single_server, array('prefix' => 'sessions:'));

// Set `gc_maxlifetime` to specify a time-to-live of 5 seconds for session keys.
$handler = new Predis\Session\Handler($client, array('gc_maxlifetime' => 5));

// Register the session handler.
$handler->register();

// We just set a fixed session ID only for the sake of our example.
session_id('example_session_id');

session_start();

if (isset($_SESSION['foo'])) {
    echo "Session has `foo` set to {$_SESSION['foo']}", PHP_EOL;
} else {
    $_SESSION['foo'] = $value = mt_rand();
    echo "Empty session, `foo` has been set with $value", PHP_EOL;
}
