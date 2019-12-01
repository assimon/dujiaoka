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
 * @link http://redis.io/commands/georadius
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class GeospatialGeoRadius extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'GEORADIUS';
    }

    /**
     * {@inheritdoc}
     */
    protected function filterArguments(array $arguments)
    {
        if ($arguments && is_array(end($arguments))) {
            $options = array_change_key_case(array_pop($arguments), CASE_UPPER);

            if (isset($options['WITHCOORD']) && $options['WITHCOORD'] == true) {
                $arguments[] = 'WITHCOORD';
            }

            if (isset($options['WITHDIST']) && $options['WITHDIST'] == true) {
                $arguments[] = 'WITHDIST';
            }

            if (isset($options['WITHHASH']) && $options['WITHHASH'] == true) {
                $arguments[] = 'WITHHASH';
            }

            if (isset($options['COUNT'])) {
                $arguments[] = 'COUNT';
                $arguments[] = $options['COUNT'];
            }

            if (isset($options['SORT'])) {
                $arguments[] = strtoupper($options['SORT']);
            }

            if (isset($options['STORE'])) {
                $arguments[] = 'STORE';
                $arguments[] = $options['STORE'];
            }

            if (isset($options['STOREDIST'])) {
                $arguments[] = 'STOREDIST';
                $arguments[] = $options['STOREDIST'];
            }
        }

        return $arguments;
    }
}
