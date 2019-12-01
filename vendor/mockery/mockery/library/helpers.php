<?php

use Mockery\Matcher\AndAnyOtherArgs;
use Mockery\Matcher\AnyArgs;

/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2016 Dave Marshall
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

if (!function_exists("mock")) {
    function mock(...$args)
    {
        return Mockery::mock(...$args);
    }
}

if (!function_exists("spy")) {
    function spy(...$args)
    {
        return Mockery::spy(...$args);
    }
}

if (!function_exists("namedMock")) {
    function namedMock(...$args)
    {
        return Mockery::namedMock(...$args);
    }
}

if (!function_exists("anyArgs")) {
    function anyArgs()
    {
        return new AnyArgs();
    }
}

if (!function_exists("andAnyOtherArgs")) {
    function andAnyOtherArgs()
    {
        return new AndAnyOtherArgs();
    }
}

if (!function_exists("andAnyOthers")) {
    function andAnyOthers()
    {
        return new AndAnyOtherArgs();
    }
}
