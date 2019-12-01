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
use Mockery\Generator\MockConfiguration;
use Mockery\Generator\StringManipulation\Pass\ConstantsPass;
use PHPUnit\Framework\TestCase;

class ConstantsPassTest extends TestCase
{
    const CODE = 'class Foo {}';

    /**
     * @test
     */
    public function shouldAddConstants()
    {
        $pass = new ConstantsPass;
        $config = new MockConfiguration(
            array(),
            array(),
            array(),
            "ClassWithConstants",
            false,
            array(),
            false,
            ['ClassWithConstants' => ['FOO' => 'test']]
        );
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, "const FOO = 'test'") !== false);
    }
}
