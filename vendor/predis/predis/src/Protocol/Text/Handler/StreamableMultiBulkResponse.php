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

use Predis\CommunicationException;
use Predis\Connection\CompositeConnectionInterface;
use Predis\Protocol\ProtocolException;
use Predis\Response\Iterator\MultiBulk as MultiBulkIterator;

/**
 * Handler for the multibulk response type in the standard Redis wire protocol.
 * It returns multibulk responses as iterators that can stream bulk elements.
 *
 * Streamable multibulk responses are not globally supported by the abstractions
 * built-in into Predis, such as transactions or pipelines. Use them with care!
 *
 * @link http://redis.io/topics/protocol
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class StreamableMultiBulkResponse implements ResponseHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(CompositeConnectionInterface $connection, $payload)
    {
        $length = (int) $payload;

        if ("$length" != $payload) {
            CommunicationException::handle(new ProtocolException(
                $connection, "Cannot parse '$payload' as a valid length for a multi-bulk response."
            ));
        }

        return new MultiBulkIterator($connection, $length);
    }
}
