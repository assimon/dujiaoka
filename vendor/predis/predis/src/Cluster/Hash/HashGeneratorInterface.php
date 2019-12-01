<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Cluster\Hash;

/**
 * An hash generator implements the logic used to calculate the hash of a key to
 * distribute operations among Redis nodes.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface HashGeneratorInterface
{
    /**
     * Generates an hash from a string to be used for distribution.
     *
     * @param string $value String value.
     *
     * @return int
     */
    public function hash($value);
}
