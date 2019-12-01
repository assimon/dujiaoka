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
 * @link http://redis.io/commands/sort
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class KeySort extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'SORT';
    }

    /**
     * {@inheritdoc}
     */
    protected function filterArguments(array $arguments)
    {
        if (count($arguments) === 1) {
            return $arguments;
        }

        $query = array($arguments[0]);
        $sortParams = array_change_key_case($arguments[1], CASE_UPPER);

        if (isset($sortParams['BY'])) {
            $query[] = 'BY';
            $query[] = $sortParams['BY'];
        }

        if (isset($sortParams['GET'])) {
            $getargs = $sortParams['GET'];

            if (is_array($getargs)) {
                foreach ($getargs as $getarg) {
                    $query[] = 'GET';
                    $query[] = $getarg;
                }
            } else {
                $query[] = 'GET';
                $query[] = $getargs;
            }
        }

        if (isset($sortParams['LIMIT']) &&
            is_array($sortParams['LIMIT']) &&
            count($sortParams['LIMIT']) == 2) {
            $query[] = 'LIMIT';
            $query[] = $sortParams['LIMIT'][0];
            $query[] = $sortParams['LIMIT'][1];
        }

        if (isset($sortParams['SORT'])) {
            $query[] = strtoupper($sortParams['SORT']);
        }

        if (isset($sortParams['ALPHA']) && $sortParams['ALPHA'] == true) {
            $query[] = 'ALPHA';
        }

        if (isset($sortParams['STORE'])) {
            $query[] = 'STORE';
            $query[] = $sortParams['STORE'];
        }

        return $query;
    }
}
