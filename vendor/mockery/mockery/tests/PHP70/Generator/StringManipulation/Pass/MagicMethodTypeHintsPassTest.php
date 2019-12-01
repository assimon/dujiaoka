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

declare(strict_types=1);

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Generator\DefinedTargetClass;
use Mockery\Generator\StringManipulation\Pass\MagicMethodTypeHintsPass;

class MagicMethodTypeHintsPassTest extends MockeryTestCase
{
    /**
     * @var MagicMethodTypeHintsPass
     */
    private $pass;

    /**
     * @var MockConfiguration
     */
    private $mockedConfiguration;

    /**
     * Setup method
     * @return void
     */
    public function mockeryTestSetUp()
    {
        $this->pass = new MagicMethodTypeHintsPass;
        $this->mockedConfiguration = m::mock(
            'Mockery\Generator\MockConfiguration'
        );
    }

    /**
     * @test
     */
    public function itShouldWork()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function itShouldGrabClassMagicMethods()
    {
        $targetClass = DefinedTargetClass::factory(
            'Mockery\Test\Generator\StringManipulation\Pass\MagicDummy'
        );
        $magicMethods = $this->pass->getMagicMethods($targetClass);

        $this->assertCount(6, $magicMethods);
        $this->assertEquals('__isset', $magicMethods[0]->getName());
    }

    /**
     * @test
     */
    public function itShouldGrabInterfaceMagicMethods()
    {
        $targetClass = DefinedTargetClass::factory(
            'Mockery\Test\Generator\StringManipulation\Pass\MagicInterfaceDummy'
        );
        $magicMethods = $this->pass->getMagicMethods($targetClass);

        $this->assertCount(6, $magicMethods);
        $this->assertEquals('__isset', $magicMethods[0]->getName());
    }

    /**
     * @test
     */
    public function itShouldAddStringTypeHintOnMagicMethod()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public function __isset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $name') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public function __isset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $name') !== false);
    }

    /**
     * @test
     */
    public function itShouldAddStringTypeHintOnAllMagicMethods()
    {
        $this->configureForInterfaces([
            'Mockery\Test\Generator\StringManipulation\Pass\MagicInterfaceDummy',
            'Mockery\Test\Generator\StringManipulation\Pass\MagicUnsetInterfaceDummy'
        ]);
        $code = $this->pass->apply(
            'public function __isset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $name') !== false);
        $code = $this->pass->apply(
            'public function __unset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $name') !== false);
    }

    /**
     * @test
     */
    public function itShouldAddBooleanReturnOnMagicMethod()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public function __isset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ' : bool') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public function __isset($name) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ' : bool') !== false);
    }

    /**
     * @test
     */
    public function itShouldAddTypeHintsOnToStringMethod()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public function __toString() {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ' : string') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public function __toString() {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ' : string') !== false);
    }

    /**
     * @test
     */
    public function itShouldAddTypeHintsOnCallMethod()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public function __call($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $method') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public function __call($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $method') !== false);
    }

    /**
     * @test
     */
    public function itShouldAddTypeHintsOnCallStaticMethod()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public static function __callStatic($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $method') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public static function __callStatic($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, 'string $method') !== false);
    }

    /**
     * @test
     */
    public function itShouldNotAddReturnTypeHintIfOneIsNotFound()
    {
        $this->configureForClass('Mockery\Test\Generator\StringManipulation\Pass\MagicReturnDummy');
        $code = $this->pass->apply(
            'public static function __isset($parameter) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ') {') !== false);

        $this->configureForInterface('Mockery\Test\Generator\StringManipulation\Pass\MagicReturnInterfaceDummy');
        $code = $this->pass->apply(
            'public static function __isset($parameter) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, ') {') !== false);
    }

    /**
     * @test
     */
    public function itShouldReturnEmptyArrayIfClassDoesNotHaveMagicMethods()
    {
        $targetClass = DefinedTargetClass::factory(
            '\StdClass'
        );
        $magicMethods = $this->pass->getMagicMethods($targetClass);
        $this->assertTrue(is_array($magicMethods));
        $this->assertEmpty($magicMethods);
    }

    /**
     * @test
     */
    public function itShouldReturnEmptyArrayIfClassTypeIsNotExpected()
    {
        $magicMethods = $this->pass->getMagicMethods(null);
        $this->assertTrue(is_array($magicMethods));
        $this->assertEmpty($magicMethods);
    }

    /**
     * Tests if the pass correclty replaces all the magic
     * method parameters with those found in the
     * Mock class. This is made to avoid variable
     * conflicts withing Mock's magic methods
     * implementations.
     *
     * @test
     */
    public function itShouldGrabAndReplaceAllParametersWithTheCodeStringMatches()
    {
        $this->configureForClass();
        $code = $this->pass->apply(
            'public function __call($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, '$method') !== false);
        $this->assertTrue(\mb_strpos($code, 'array $args') !== false);

        $this->configureForInterface();
        $code = $this->pass->apply(
            'public function __call($method, array $args) {}',
            $this->mockedConfiguration
        );
        $this->assertTrue(\mb_strpos($code, '$method') !== false);
        $this->assertTrue(\mb_strpos($code, 'array $args') !== false);
    }

    protected function configureForClass(string $className = 'Mockery\Test\Generator\StringManipulation\Pass\MagicDummy')
    {
        $targetClass = DefinedTargetClass::factory($className);

        $this->mockedConfiguration
            ->shouldReceive('getTargetClass')
            ->andReturn($targetClass)
            ->byDefault();
        $this->mockedConfiguration
            ->shouldReceive('getTargetInterfaces')
            ->andReturn([])
            ->byDefault();
    }

    protected function configureForInterface(string $interfaceName = 'Mockery\Test\Generator\StringManipulation\Pass\MagicDummy')
    {
        $targetInterface = DefinedTargetClass::factory($interfaceName);

        $this->mockedConfiguration
            ->shouldReceive('getTargetClass')
            ->andReturn(null)
            ->byDefault();
        $this->mockedConfiguration
            ->shouldReceive('getTargetInterfaces')
            ->andReturn([$targetInterface])
            ->byDefault();
    }

    protected function configureForInterfaces(array $interfaceNames)
    {
        $targetInterfaces = array_map([DefinedTargetClass::class, 'factory'], $interfaceNames);

        $this->mockedConfiguration
            ->shouldReceive('getTargetClass')
            ->andReturn(null)
            ->byDefault();
        $this->mockedConfiguration
            ->shouldReceive('getTargetInterfaces')
            ->andReturn($targetInterfaces)
            ->byDefault();
    }
}

class MagicDummy
{
    public function __isset(string $name) : bool
    {
        return false;
    }

    public function __toString() : string
    {
        return '';
    }

    public function __wakeup()
    {
    }

    public function __destruct()
    {
    }

    public function __call(string $name, array $arguments) : string
    {
    }

    public static function __callStatic(string $name, array $arguments) : int
    {
    }

    public function nonMagicMethod()
    {
    }
}

class MagicReturnDummy
{
    public function __isset(string $name)
    {
        return false;
    }
}

interface MagicInterfaceDummy
{
    public function __isset(string $name) : bool;

    public function __toString() : string;

    public function __wakeup();

    public function __destruct();

    public function __call(string $name, array $arguments) : string;

    public static function __callStatic(string $name, array $arguments) : int;

    public function nonMagicMethod();
}

interface MagicReturnInterfaceDummy
{
    public function __isset(string $name);
}

interface MagicUnsetInterfaceDummy
{
    public function __unset(string $name);
}
