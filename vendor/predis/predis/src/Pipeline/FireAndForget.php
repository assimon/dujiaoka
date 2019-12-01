<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Pipeline;

use Predis\Connection\ConnectionInterface;

/**
 * Command pipeline that writes commands to the servers but discards responses.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class FireAndForget extends Pipeline
{
    /**
     * {@inheritdoc}
     */
    protected function executePipeline(ConnectionInterface $connection, \SplQueue $commands)
    {
        while (!$commands->isEmpty()) {
            $connection->writeRequest($commands->dequeue());
        }

        $connection->disconnect();

        return array();
    }
}
