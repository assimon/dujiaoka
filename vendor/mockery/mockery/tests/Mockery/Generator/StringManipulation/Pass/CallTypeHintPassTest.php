<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Generator\StringManipulation\Pass\CallTypeHintPass;
use PHPUnit\Framework\TestCase;

class CallTypeHintPassTest extends TestCase
{
    const CODE = ' public function __call($method, array $args) {}
                   public static function __callStatic($method, array $args) {}
    ';

    /**
     * @test
     */
    public function shouldRemoveCallTypeHintIfRequired()
    {
        $pass = new CallTypeHintPass;
        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "requiresCallTypeHintRemoval" => true,
        ))->makePartial();
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, '__call($method, $args)') !== false);
    }

    /**
     * @test
     */
    public function shouldRemoveCallStaticTypeHintIfRequired()
    {
        $pass = new CallTypeHintPass;
        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "requiresCallStaticTypeHintRemoval" => true,
        ))->makePartial();
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, '__callStatic($method, $args)') !== false);
    }
}
