<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command;

/**
 * @link http://redis.io/topics/sentinel
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ServerSentinel extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'SENTINEL';
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        switch (strtolower($this->getArgument(0))) {
            case 'masters':
            case 'slaves':
                return self::processMastersOrSlaves($data);

            default:
                return $data;
        }
    }

    /**
     * Returns a processed response to SENTINEL MASTERS or SENTINEL SLAVES.
     *
     * @param array $servers List of Redis servers.
     *
     * @return array
     */
    protected static function processMastersOrSlaves(array $servers)
    {
        foreach ($servers as $idx => $node) {
            $processed = array();
            $count = count($node);

            for ($i = 0; $i < $count; ++$i) {
                $processed[$node[$i]] = $node[++$i];
            }

            $servers[$idx] = $processed;
        }

        return $servers;
    }
}
