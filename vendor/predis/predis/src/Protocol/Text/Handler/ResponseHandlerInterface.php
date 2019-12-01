<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Protocol\Text\Handler;

use Predis\Connection\CompositeConnectionInterface;

/**
 * Defines a pluggable handler used to parse a particular type of response.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ResponseHandlerInterface
{
    /**
     * Deserializes a response returned by Redis and reads more data from the
     * connection if needed.
     *
     * @param CompositeConnectionInterface $connection Redis connection.
     * @param string                       $payload    String payload.
     *
     * @return mixed
     */
    public function handle(CompositeConnectionInterface $connection, $payload);
}
