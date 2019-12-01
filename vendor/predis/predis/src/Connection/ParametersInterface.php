<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Connection;

/**
 * Interface defining a container for connection parameters.
 *
 * The actual list of connection parameters depends on the features supported by
 * each connection backend class (please refer to their specific documentation),
 * but the most common parameters used through the library are:
 *
 * @property-read string scheme             Connection scheme, such as 'tcp' or 'unix'.
 * @property-read string host               IP address or hostname of Redis.
 * @property-read int    port               TCP port on which Redis is listening to.
 * @property-read string path               Path of a UNIX domain socket file.
 * @property-read string alias              Alias for the connection.
 * @property-read float  timeout            Timeout for the connect() operation.
 * @property-read float  read_write_timeout Timeout for read() and write() operations.
 * @property-read bool   async_connect      Performs the connect() operation asynchronously.
 * @property-read bool   tcp_nodelay        Toggles the Nagle's algorithm for coalescing.
 * @property-read bool   persistent         Leaves the connection open after a GC collection.
 * @property-read string password           Password to access Redis (see the AUTH command).
 * @property-read string database           Database index (see the SELECT command).
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface ParametersInterface
{
    /**
     * Checks if the specified parameters is set.
     *
     * @param string $parameter Name of the parameter.
     *
     * @return bool
     */
    public function __isset($parameter);

    /**
     * Returns the value of the specified parameter.
     *
     * @param string $parameter Name of the parameter.
     *
     * @return mixed|null
     */
    public function __get($parameter);

    /**
     * Returns an array representation of the connection parameters.
     *
     * @return array
     */
    public function toArray();
}
