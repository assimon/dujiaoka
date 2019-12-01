<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner\Fixtures;

class ClassWithCallStatic
{
    public static function __callStatic($name, $arguments)
    {
        // wheee!
    }
}
