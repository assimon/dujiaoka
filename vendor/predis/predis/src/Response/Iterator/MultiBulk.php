<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Response\Iterator;

use Predis\Connection\NodeConnectionInterface;

/**
 * Streamable multibulk response.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class MultiBulk extends MultiBulkIterator
{
    private $connection;

    /**
     * @param NodeConnectionInterface $connection Connection to Redis.
     * @param int                     $size       Number of elements of the multibulk response.
     */
    public function __construct(NodeConnectionInterface $connection, $size)
    {
        $this->connection = $connection;
        $this->size = $size;
        $this->position = 0;
        $this->current = $size > 0 ? $this->getValue() : null;
    }

    /**
     * Handles the synchronization of the client with the Redis protocol when
     * the garbage collector kicks in (e.g. when the iterator goes out of the
     * scope of a foreach or it is unset).
     */
    public function __destruct()
    {
        $this->drop(true);
    }

    /**
     * Drop queued elements that have not been read from the connection either
     * by consuming the rest of the multibulk response or quickly by closing the
     * underlying connection.
     *
     * @param bool $disconnect Consume the iterator or drop the connection.
     */
    public function drop($disconnect = false)
    {
        if ($disconnect) {
            if ($this->valid()) {
                $this->position = $this->size;
                $this->connection->disconnect();
            }
        } else {
            while ($this->valid()) {
                $this->next();
            }
        }
    }

    /**
     * Reads the next item of the multibulk response from the connection.
     *
     * @return mixed
     */
    protected function getValue()
    {
        return $this->connection->read();
    }
}
