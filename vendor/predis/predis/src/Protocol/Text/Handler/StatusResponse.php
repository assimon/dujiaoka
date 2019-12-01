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
use Predis\Response\Status;

/**
 * Handler for the status response type in the standard Redis wire protocol. It
 * translates certain classes of status response to PHP objects or just returns
 * the payload as a string.
 *
 * @link http://redis.io/topics/protocol
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class StatusResponse implements ResponseHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(CompositeConnectionInterface $connection, $payload)
    {
        return Status::get($payload);
    }
}
