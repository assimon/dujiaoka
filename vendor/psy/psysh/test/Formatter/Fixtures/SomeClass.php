<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Formatter\Fixtures;

class SomeClass
{
    const SOME_CONST = 'some const';
    private $someProp = 'some prop';

    public function someMethod($someParam)
    {
        return 'some method';
    }

    public static function someClosure()
    {
        return function () {
            return 'some closure';
        };
    }
}
