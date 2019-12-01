<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test;

class ClassWithSecrets
{
    private const PRIVATE_CONST = 'private and const';
    private static $privateStaticProp = 'private and static and prop';
    private $privateProp = 'private and prop';

    private static function privateStaticMethod($extra = null)
    {
        if ($extra !== null) {
            return 'private and static and method with ' . \json_encode($extra);
        }

        return 'private and static and method';
    }

    private function privateMethod($extra = null)
    {
        if ($extra !== null) {
            return 'private and method with ' . \json_encode($extra);
        }

        return 'private and method';
    }
}
