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
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SpyTest extends MockeryTestCase
{
    /** @test */
    public function itVerifiesAMethodWasCalled()
    {
        $spy = m::spy();
        $spy->myMethod();
        $spy->shouldHaveReceived("myMethod");

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->shouldHaveReceived("someMethodThatWasNotCalled");
    }

    /** @test */
    public function itVerifiesAMethodWasNotCalled()
    {
        $spy = m::spy();
        $spy->shouldNotHaveReceived("myMethod");

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->myMethod();
        $spy->shouldNotHaveReceived("myMethod");
    }

    /** @test */
    public function itVerifiesAMethodWasNotCalledWithParticularArguments()
    {
        $spy = m::spy();
        $spy->myMethod(123, 456);

        $spy->shouldNotHaveReceived("myMethod", array(789, 10));

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->shouldNotHaveReceived("myMethod", array(123, 456));
    }

    /** @test */
    public function itVerifiesAMethodWasCalledASpecificNumberOfTimes()
    {
        $spy = m::spy();
        $spy->myMethod();
        $spy->myMethod();
        $spy->shouldHaveReceived("myMethod")->twice();

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->myMethod();
        $spy->shouldHaveReceived("myMethod")->twice();
    }

    /** @test */
    public function itVerifiesAMethodWasCalledWithSpecificArguments()
    {
        $spy = m::spy();
        $spy->myMethod(123, "a string");
        $spy->shouldHaveReceived("myMethod")->with(123, "a string");
        $spy->shouldHaveReceived("myMethod", array(123, "a string"));

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->shouldHaveReceived("myMethod")->with(123);
    }

    /** @test */
    public function itIncrementsExpectationCountWhenShouldHaveReceivedIsUsed()
    {
        $spy = m::spy();
        $spy->myMethod('param1', 'param2');
        $spy->shouldHaveReceived('myMethod')->with('param1', 'param2');
        $this->assertEquals(1, $spy->mockery_getExpectationCount());
    }

    /** @test */
    public function itIncrementsExpectationCountWhenShouldNotHaveReceivedIsUsed()
    {
        $spy = m::spy();
        $spy->shouldNotHaveReceived('method');
        $this->assertEquals(1, $spy->mockery_getExpectationCount());
    }

    /** @test */
    public function any_args_can_be_used_with_alternative_syntax()
    {
        $spy = m::spy();
        $spy->foo(123, 456);

        $spy->shouldHaveReceived()->foo(anyArgs());
    }

    /** @test */
    public function should_have_received_higher_order_message_call_a_method_with_correct_arguments()
    {
        $spy = m::spy();
        $spy->foo(123);

        $spy->shouldHaveReceived()->foo(123);
    }

    /** @test */
    public function should_have_received_higher_order_message_call_a_method_with_incorrect_arguments_throws_exception()
    {
        $spy = m::spy();
        $spy->foo(123);

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->shouldHaveReceived()->foo(456);
    }

    /** @test */
    public function should_not_have_received_higher_order_message_call_a_method_with_incorrect_arguments()
    {
        $spy = m::spy();
        $spy->foo(123);

        $spy->shouldNotHaveReceived()->foo(456);
    }

    /** @test */
    public function should_not_have_received_higher_order_message_call_a_method_with_correct_arguments_throws_an_exception()
    {
        $spy = m::spy();
        $spy->foo(123);

        $this->expectException("Mockery\Exception\InvalidCountException");
        $spy->shouldNotHaveReceived()->foo(123);
    }
}
