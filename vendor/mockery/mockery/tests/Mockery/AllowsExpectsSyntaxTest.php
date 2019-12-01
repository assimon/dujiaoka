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

use Mockery as m;
use Mockery\Spy;
use Mockery\Exception\InvalidCountException;
use PHPUnit\Framework\TestCase;

class ClassWithAllowsMethod
{
    public function allows()
    {
        return 123;
    }
}
    
class ClassWithExpectsMethod
{
    public function expects()
    {
        return 123;
    }
}


class AllowsExpectsSyntaxTest extends TestCase
{
    /** @test */
    public function allowsSetsUpMethodStub()
    {
        $stub = m::mock();
        $stub->allows()->foo(123)->andReturns(456);

        $this->assertEquals(456, $stub->foo(123));
    }

    /** @test */
    public function allowsCanTakeAnArrayOfCalls()
    {
        $stub = m::mock();
        $stub->allows([
            "foo" => "bar",
            "bar" => "baz",
        ]);

        $this->assertEquals("bar", $stub->foo());
        $this->assertEquals("baz", $stub->bar());
    }

    /** @test */
    public function allowsCanTakeAString()
    {
        $stub = m::mock();
        $stub->allows("foo")->andReturns("bar");
        $this->assertEquals("bar", $stub->foo());
    }

    /** @test */
    public function expects_can_optionally_match_on_any_arguments()
    {
        $mock = m::mock();
        $mock->allows()->foo()->withAnyArgs()->andReturns(123);

        $this->assertEquals(123, $mock->foo(456, 789));
    }

    /** @test */
    public function expects_can_take_a_string()
    {
        $mock = m::mock();
        $mock->expects("foo")->andReturns(123);

        $this->assertEquals(123, $mock->foo(456, 789));
    }

    /** @test */
    public function expectsSetsUpExpectationOfOneCall()
    {
        $mock = m::mock();
        $mock->expects()->foo(123);

        $this->expectException("Mockery\Exception\InvalidCountException");
        m::close();
    }

    /** @test */
    public function callVerificationCountCanBeOverridenAfterExpectsThrowsExceptionWhenIncorrectNumberOfCalls()
    {
        $mock = m::mock();
        $mock->expects()->foo(123)->twice();

        $mock->foo(123);
        $this->expectException("Mockery\Exception\InvalidCountException");
        m::close();
    }

    /** @test */
    public function callVerificationCountCanBeOverridenAfterExpects()
    {
        $mock = m::mock();
        $mock->expects()->foo(123)->twice();

        $mock->foo(123);
        $mock->foo(123);

        m::close();
    }

    /** @test */
    public function generateSkipsAllowsMethodIfAlreadyExists()
    {
        $stub = m::mock("test\Mockery\ClassWithAllowsMethod");
    
        $stub->shouldReceive('allows')->andReturn(123);
    
        $this->assertEquals(123, $stub->allows());
    }
    
    /** @test */
    public function generateSkipsExpectsMethodIfAlreadyExists()
    {
        $stub = m::mock("test\Mockery\ClassWithExpectsMethod");
    
        $stub->shouldReceive('expects')->andReturn(123);
    
        $this->assertEquals(123, $stub->expects());
    }
}
