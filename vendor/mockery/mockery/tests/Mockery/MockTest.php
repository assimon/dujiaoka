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
use Mockery\Mock;

class Mockery_MockTest extends MockeryTestCase
{
    public function testAnonymousMockWorksWithNotAllowingMockingOfNonExistentMethods()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $m = mock();
        $m->shouldReceive("test123")->andReturn(true);
        assertThat($m->test123(), equalTo(true));
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    public function testMockWithNotAllowingMockingOfNonExistentMethodsCanBeGivenAdditionalMethodsToMockEvenIfTheyDontExistOnClass()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $m = mock('ExampleClassForTestingNonExistentMethod');
        $m->shouldAllowMockingMethod('testSomeNonExistentMethod');
        $m->shouldReceive("testSomeNonExistentMethod")->andReturn(true);
        assertThat($m->testSomeNonExistentMethod(), equalTo(true));
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    public function testProtectedMethodMockWithNotAllowingMockingOfNonExistentMethodsWhenShouldAllowMockingProtectedMethodsIsCalled()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $m = mock('ClassWithProtectedMethod');
        $m->shouldAllowMockingProtectedMethods();
        $m->shouldReceive('foo')->andReturn(true);
        assertThat($m->foo(), equalTo(true));
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    public function testShouldAllowMockingMethodReturnsMockInstance()
    {
        $m = Mockery::mock('someClass');
        $this->assertInstanceOf('Mockery\MockInterface', $m->shouldAllowMockingMethod('testFunction'));
    }

    public function testShouldAllowMockingProtectedMethodReturnsMockInstance()
    {
        $m = Mockery::mock('someClass');
        $this->assertInstanceOf('Mockery\MockInterface', $m->shouldAllowMockingProtectedMethods('testFunction'));
    }

    public function testMockAddsToString()
    {
        $mock = mock('ClassWithNoToString');
        $this->assertTrue(method_exists($mock, '__toString'));
    }

    public function testMockToStringMayBeDeferred()
    {
        $mock = mock('ClassWithToString')->makePartial();
        $this->assertEquals("foo", (string)$mock);
    }

    public function testMockToStringShouldIgnoreMissingAlwaysReturnsString()
    {
        $mock = mock('ClassWithNoToString')->shouldIgnoreMissing();
        $this->assertNotEquals('', (string)$mock);

        $mock->asUndefined();
        $this->assertNotEquals('', (string)$mock);
    }

    public function testShouldIgnoreMissing()
    {
        $mock = mock('ClassWithNoToString')->shouldIgnoreMissing();
        $this->assertNull($mock->nonExistingMethod());
    }

    public function testShouldIgnoreMissingDisallowMockingNonExistentMethodsUsingGlobalConfiguration()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = mock('ClassWithMethods')->shouldIgnoreMissing();
        $this->expectException(\Mockery\Exception::class);
        $mock->shouldReceive('nonExistentMethod');
    }

    public function testShouldIgnoreMissingCallingNonExistentMethodsUsingGlobalConfiguration()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = mock('ClassWithMethods')->shouldIgnoreMissing();
        $this->expectException(\BadMethodCallException::class);
        $mock->nonExistentMethod();
    }

    public function testShouldIgnoreMissingCallingExistentMethods()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = mock('ClassWithMethods')->shouldIgnoreMissing();
        assertThat(nullValue($mock->foo()));
        $mock->shouldReceive('bar')->passthru();
        assertThat($mock->bar(), equalTo('bar'));
    }

    public function testShouldIgnoreMissingCallingNonExistentMethods()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
        $mock = mock('ClassWithMethods')->shouldIgnoreMissing();
        assertThat(nullValue($mock->foo()));
        assertThat(nullValue($mock->bar()));
        assertThat(nullValue($mock->nonExistentMethod()));

        $mock->shouldReceive(array('foo' => 'new_foo', 'nonExistentMethod' => 'result'));
        $mock->shouldReceive('bar')->passthru();
        assertThat($mock->foo(), equalTo('new_foo'));
        assertThat($mock->bar(), equalTo('bar'));
        assertThat($mock->nonExistentMethod(), equalTo('result'));
    }

    public function testCanMockException()
    {
        $exception = Mockery::mock('Exception');
        $this->assertInstanceOf('Exception', $exception);
    }

    public function testCanMockSubclassOfException()
    {
        $errorException = Mockery::mock('ErrorException');
        $this->assertInstanceOf('ErrorException', $errorException);
        $this->assertInstanceOf('Exception', $errorException);
    }

    public function testCallingShouldReceiveWithoutAValidMethodName()
    {
        $mock = Mockery::mock();

        $this->expectException("InvalidArgumentException", "Received empty method name");
        $mock->shouldReceive("");
    }

    public function testShouldThrowExceptionWithInvalidClassName()
    {
        $this->expectException(\Mockery\Exception::class);
        mock('ClassName.CannotContainDot');
    }


    /** @test */
    public function expectation_count_will_count_expectations()
    {
        $mock = new Mock();
        $mock->shouldReceive("doThis")->once();
        $mock->shouldReceive("doThat")->once();

        $this->assertEquals(2, $mock->mockery_getExpectationCount());
    }

    /** @test */
    public function expectation_count_will_ignore_defaults_if_overriden()
    {
        $mock = new Mock();
        $mock->shouldReceive("doThis")->once()->byDefault();
        $mock->shouldReceive("doThis")->twice();
        $mock->shouldReceive("andThis")->twice();

        $this->assertEquals(2, $mock->mockery_getExpectationCount());
    }

    /** @test */
    public function expectation_count_will_count_defaults_if_not_overriden()
    {
        $mock = new Mock();
        $mock->shouldReceive("doThis")->once()->byDefault();
        $mock->shouldReceive("doThat")->once()->byDefault();

        $this->assertEquals(2, $mock->mockery_getExpectationCount());
    }
}


class ExampleClassForTestingNonExistentMethod
{
}

class ClassWithToString
{
    public function __toString()
    {
        return 'foo';
    }
}

class ClassWithNoToString
{
}

class ClassWithMethods
{
    public function foo()
    {
        return 'foo';
    }

    public function bar()
    {
        return 'bar';
    }
}

class ClassWithProtectedMethod
{
    protected function foo()
    {
        return 'foo';
    }
}
