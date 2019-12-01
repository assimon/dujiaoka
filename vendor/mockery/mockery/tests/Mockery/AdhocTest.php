<?php
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
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * Ad-hoc unit tests for various scenarios reported by users
 */
class Mockery_AdhocTest extends MockeryTestCase
{
    public function mockeryTestSetUp()
    {
        $this->container = new \Mockery\Container(\Mockery::getDefaultGenerator(), \Mockery::getDefaultLoader());
    }

    public function mockeryTestTearDown()
    {
        $this->container->mockery_close();
    }

    public function testSimplestMockCreation()
    {
        $m = $this->container->mock('MockeryTest_NameOfExistingClass');
        $this->assertInstanceOf(MockeryTest_NameOfExistingClass::class, $m);
    }

    public function testMockeryInterfaceForClass()
    {
        $m = $this->container->mock('SplFileInfo');
        $this->assertInstanceOf(\Mockery\MockInterface::class, $m);
    }

    public function testMockeryInterfaceForNonExistingClass()
    {
        $m = $this->container->mock('ABC_IDontExist');
        $this->assertInstanceOf(\Mockery\MockInterface::class, $m);
    }

    public function testMockeryInterfaceForInterface()
    {
        $m = $this->container->mock('MockeryTest_NameOfInterface');
        $this->assertInstanceOf(\Mockery\MockInterface::class, $m);
    }

    public function testMockeryInterfaceForAbstract()
    {
        $m = $this->container->mock('MockeryTest_NameOfAbstract');
        $this->assertInstanceOf(\Mockery\MockInterface::class, $m);
    }

    public function testInvalidCountExceptionThrowsRuntimeExceptionOnIllegalComparativeSymbol()
    {
        $this->expectException('Mockery\Exception\RuntimeException');
        $e = new \Mockery\Exception\InvalidCountException;
        $e->setExpectedCountComparative('X');
    }

    public function testMockeryConstructAndDestructIsNotCalled()
    {
        MockeryTest_NameOfExistingClassWithDestructor::$isDestructorWasCalled = false;
        // We pass no arguments in constructor, so it's not being called. Then destructor shouldn't be called too.
        $this->container->mock('MockeryTest_NameOfExistingClassWithDestructor');
        // Clear references to trigger destructor
        $this->container->mockery_close();
        $this->assertFalse(MockeryTest_NameOfExistingClassWithDestructor::$isDestructorWasCalled);
    }

    public function testMockeryConstructAndDestructIsCalled()
    {
        MockeryTest_NameOfExistingClassWithDestructor::$isDestructorWasCalled = false;

        $this->container->mock('MockeryTest_NameOfExistingClassWithDestructor', array());
        // Clear references to trigger destructor
        $this->container->mockery_close();
        $this->assertTrue(MockeryTest_NameOfExistingClassWithDestructor::$isDestructorWasCalled);
    }
}

class MockeryTest_NameOfExistingClass
{
}

interface MockeryTest_NameOfInterface
{
    public function foo();
}

abstract class MockeryTest_NameOfAbstract
{
    abstract public function foo();
}

class MockeryTest_NameOfExistingClassWithDestructor
{
    public static $isDestructorWasCalled = false;

    public function __destruct()
    {
        self::$isDestructorWasCalled = true;
    }
}
