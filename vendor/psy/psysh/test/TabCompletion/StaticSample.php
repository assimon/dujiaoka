<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\TabCompletion;

/**
 * Class StaticSample.
 */
class StaticSample
{
    const CONSTANT_VALUE = 12;

    public static $staticVariable;

    public static function staticFunction()
    {
        return self::CONSTANT_VALUE;
    }
}
