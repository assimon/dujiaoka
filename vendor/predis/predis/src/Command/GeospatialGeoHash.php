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
 * @link http://redis.io/commands/geohash
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class GeospatialGeoHash extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'GEOHASH';
    }

    /**
     * {@inheritdoc}
     */
    protected function filterArguments(array $arguments)
    {
        if (count($arguments) === 2 && is_array($arguments[1])) {
            $members = array_pop($arguments);
            $arguments = array_merge($arguments, $members);
        }

        return $arguments;
    }
}
