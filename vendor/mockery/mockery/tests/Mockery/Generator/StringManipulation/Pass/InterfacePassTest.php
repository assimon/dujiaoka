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
use Mockery\Generator\StringManipulation\Pass\InterfacePass;
use PHPUnit\Framework\TestCase;

class InterfacePassTest extends TestCase
{
    const CODE = "class Mock implements MockInterface";

    /**
     * @test
     */
    public function shouldNotAlterCodeIfNoTargetInterfaces()
    {
        $pass = new InterfacePass;

        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "getTargetInterfaces" => array(),
        ));

        $code = $pass->apply(static::CODE, $config);
        $this->assertEquals(static::CODE, $code);
    }

    /**
     * @test
     */
    public function shouldAddAnyInterfaceNamesToImplementsDefinition()
    {
        $pass = new InterfacePass;

        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "getTargetInterfaces" => array(
                m::mock(array("getName" => "Dave\Dave")),
                m::mock(array("getName" => "Paddy\Paddy")),
            ),
        ));

        $code = $pass->apply(static::CODE, $config);

        $this->assertTrue(\mb_strpos($code, "implements MockInterface, \Dave\Dave, \Paddy\Paddy") !== false);
    }
}
