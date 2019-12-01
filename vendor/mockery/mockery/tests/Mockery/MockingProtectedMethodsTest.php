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

namespace test\Mockery;

use Mockery\Adapter\Phpunit\MockeryTestCase;

class MockingProtectedMethodsTest extends MockeryTestCase
{
    /**
     * @test
     *
     * This is a regression test, basically we don't want the mock handling
     * interfering with calling protected methods partials
     */
    public function shouldAutomaticallyDeferCallsToProtectedMethodsForPartials()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods[foo]");
        $this->assertEquals("bar", $mock->bar());
    }

    /**
     * @test
     *
     * This is a regression test, basically we don't want the mock handling
     * interfering with calling protected methods partials
     */
    public function shouldAutomaticallyDeferCallsToProtectedMethodsForRuntimePartials()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods")->makePartial();
        $this->assertEquals("bar", $mock->bar());
    }

    /** @test */
    public function shouldAutomaticallyIgnoreAbstractProtectedMethods()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods")->makePartial();
        $this->assertNull($mock->foo());
    }

    /** @test */
    public function shouldAllowMockingProtectedMethods()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods")
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive("protectedBar")->andReturn("notbar");
        $this->assertEquals("notbar", $mock->bar());
    }

    /** @test */
    public function shouldAllowMockingProtectedMethodOnDefinitionTimePartial()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods[protectedBar]")
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive("protectedBar")->andReturn("notbar");
        $this->assertEquals("notbar", $mock->bar());
    }

    /** @test */
    public function shouldAllowMockingAbstractProtectedMethods()
    {
        $mock = mock("test\Mockery\TestWithProtectedMethods")
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive("abstractProtected")->andReturn("abstractProtected");
        $this->assertEquals("abstractProtected", $mock->foo());
    }

    /** @test */
    public function shouldAllowMockingIncreasedVisabilityMethods()
    {
        $mock = mock("test\Mockery\TestIncreasedVisibilityChild");
        $mock->shouldReceive('foobar')->andReturn("foobar");
        $this->assertEquals('foobar', $mock->foobar());
    }
}


abstract class TestWithProtectedMethods
{
    public function foo()
    {
        return $this->abstractProtected();
    }

    abstract protected function abstractProtected();

    public function bar()
    {
        return $this->protectedBar();
    }

    protected function protectedBar()
    {
        return 'bar';
    }
}

class TestIncreasedVisibilityParent
{
    protected function foobar()
    {
    }
}

class TestIncreasedVisibilityChild extends TestIncreasedVisibilityParent
{
    public function foobar()
    {
    }
}
