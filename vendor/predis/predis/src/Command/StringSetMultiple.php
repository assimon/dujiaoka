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
 * @link http://redis.io/commands/mset
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class StringSetMultiple extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'MSET';
    }

    /**
     * {@inheritdoc}
     */
    protected function filterArguments(array $arguments)
    {
        if (count($arguments) === 1 && is_array($arguments[0])) {
            $flattenedKVs = array();
            $args = $arguments[0];

            foreach ($args as $k => $v) {
                $flattenedKVs[] = $k;
                $flattenedKVs[] = $v;
            }

            return $flattenedKVs;
        }

        return $arguments;
    }
}
