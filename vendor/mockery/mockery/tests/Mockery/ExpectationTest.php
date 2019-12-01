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

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Exception\InvalidCountException;
use Mockery\MockInterface;

class ExpectationTest extends MockeryTestCase
{
    public function mockeryTestSetUp()
    {
        parent::mockeryTestSetUp();
        $this->mock = mock();
    }

    public function mockeryTestTearDown()
    {
        parent::mockeryTestTearDown();
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    public function testReturnsNullWhenNoArgs()
    {
        $this->mock->shouldReceive('foo');
        $this->assertNull($this->mock->foo());
    }

    public function testReturnsNullWhenSingleArg()
    {
        $this->mock->shouldReceive('foo');
        $this->assertNull($this->mock->foo(1));
    }

    public function testReturnsNullWhenManyArgs()
    {
        $this->mock->shouldReceive('foo');
        $this->assertNull($this->mock->foo('foo', array(), new stdClass));
    }

    public function testReturnsNullIfNullIsReturnValue()
    {
        $this->mock->shouldReceive('foo')->andReturn(null);
        $this->assertNull($this->mock->foo());
    }

    public function testReturnsNullForMockedExistingClassIfAndreturnnullCalled()
    {
        $mock = mock('MockeryTest_Foo');
        $mock->shouldReceive('foo')->andReturn(null);
        $this->assertNull($mock->foo());
    }

    public function testReturnsNullForMockedExistingClassIfNullIsReturnValue()
    {
        $mock = mock('MockeryTest_Foo');
        $mock->shouldReceive('foo')->andReturnNull();
        $this->assertNull($mock->foo());
    }

    public function testReturnsSameValueForAllIfNoArgsExpectationAndNoneGiven()
    {
        $this->mock->shouldReceive('foo')->andReturn(1);
        $this->assertEquals(1, $this->mock->foo());
    }

    public function testSetsPublicPropertyWhenRequested()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->andSet('bar', 'baz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
    }

    public function testSetsPublicPropertyWhenRequestedUsingAlias()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->set('bar', 'baz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequested()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->andSet('bar', 'baz', 'bazz', 'bazzz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazzz', $this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequestedUsingAlias()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->set('bar', 'baz', 'bazz', 'bazzz');
        $this->assertTrue(empty($this->mock->bar));
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazzz', $this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequestedMoreTimesThanSetValues()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->andSet('bar', 'baz', 'bazz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequestedMoreTimesThanSetValuesUsingAlias()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->andSet('bar', 'baz', 'bazz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequestedMoreTimesThanSetValuesWithDirectSet()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->andSet('bar', 'baz', 'bazz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->bar = null;
        $this->mock->foo();
        $this->assertNull($this->mock->bar);
    }

    public function testSetsPublicPropertiesWhenRequestedMoreTimesThanSetValuesWithDirectSetUsingAlias()
    {
        $this->mock->bar = null;
        $this->mock->shouldReceive('foo')->set('bar', 'baz', 'bazz');
        $this->assertNull($this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('baz', $this->mock->bar);
        $this->mock->foo();
        $this->assertEquals('bazz', $this->mock->bar);
        $this->mock->bar = null;
        $this->mock->foo();
        $this->assertNull($this->mock->bar);
    }

    /**
     * @group issue/1005
     */
    public function testSetsPublicPropertiesCorrectlyForDifferentInstancesOfSameClass()
    {
        $mockInstanceOne = mock('MockeryTest_Foo');
        $mockInstanceTwo = mock('MockeryTest_Foo');

        $mockInstanceOne->shouldReceive('foo')
            ->andSet('bar', 'baz');

        $mockInstanceTwo->shouldReceive('foo')
            ->andSet('bar', 'bazz');

        $mockInstanceOne->foo();
        $mockInstanceTwo->foo();

        $this->assertEquals('baz', $mockInstanceOne->bar);
        $this->assertEquals('bazz', $mockInstanceTwo->bar);
    }

    public function testReturnsSameValueForAllIfNoArgsExpectationAndSomeGiven()
    {
        $this->mock->shouldReceive('foo')->andReturn(1);
        $this->assertEquals(1, $this->mock->foo('foo'));
    }

    public function testReturnsValueFromSequenceSequentially()
    {
        $this->mock->shouldReceive('foo')->andReturn(1, 2, 3);
        $this->mock->foo('foo');
        $this->assertEquals(2, $this->mock->foo('foo'));
    }

    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCalls()
    {
        $this->mock->shouldReceive('foo')->andReturn(1, 2, 3);
        $this->mock->foo('foo');
        $this->mock->foo('foo');
        $this->assertEquals(3, $this->mock->foo('foo'));
        $this->assertEquals(3, $this->mock->foo('foo'));
    }

    public function testReturnsValueFromSequenceSequentiallyAndRepeatedlyReturnsFinalValueOnExtraCallsWithManyAndReturnCalls()
    {
        $this->mock->shouldReceive('foo')->andReturn(1)->andReturn(2, 3);
        $this->mock->foo('foo');
        $this->mock->foo('foo');
        $this->assertEquals(3, $this->mock->foo('foo'));
        $this->assertEquals(3, $this->mock->foo('foo'));
    }

    public function testReturnsValueOfClosure()
    {
        $this->mock->shouldReceive('foo')->with(5)->andReturnUsing(function ($v) {
            return $v+1;
        });
        $this->assertEquals(6, $this->mock->foo(5));
    }

    public function testReturnsValueOfArgument()
    {
        $args = [1, 2, 3, 4, 5];
        $index = 2;
        $this->mock->shouldReceive('foo')->withArgs($args)->andReturnArg($index);
        $this->assertEquals($args[$index], $this->mock->foo(...$args));
    }

    public function testReturnsNullArgument()
    {
        $args = [1, null, 3];
        $index = 1;
        $this->mock->shouldReceive('foo')->withArgs($args)->andReturnArg($index);
        $this->assertNull($this->mock->foo(...$args));
    }

    public function testExceptionOnInvalidArgumentIndexValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mock->shouldReceive('foo')->andReturnArg("invalid");
    }

    public function testExceptionOnArgumentIndexOutOfRange()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->mock->shouldReceive('foo')->andReturnArg(2);
        $this->mock->foo(0, 1); // only pass 2 arguments so index #2 won't exist
    }

    public function testReturnsUndefined()
    {
        $this->mock->shouldReceive('foo')->andReturnUndefined();
        $this->assertInstanceOf(\Mockery\Undefined::class, $this->mock->foo());
    }

    public function testReturnsValuesSetAsArray()
    {
        $this->mock->shouldReceive('foo')->andReturnValues(array(1, 2, 3));
        $this->assertEquals(1, $this->mock->foo());
        $this->assertEquals(2, $this->mock->foo());
        $this->assertEquals(3, $this->mock->foo());
    }

    public function testThrowsException()
    {
        $this->mock->shouldReceive('foo')->andThrow(new OutOfBoundsException);
        $this->expectException(OutOfBoundsException::class);
        $this->mock->foo();
        Mockery::close();
    }

    /** @test */
    public function and_throws_is_an_alias_to_and_throw()
    {
        $this->mock->shouldReceive('foo')->andThrows(new OutOfBoundsException);

        $this->expectException(OutOfBoundsException::class);
        $this->mock->foo();
    }

    /**
     * @test
     * @requires PHP 7.0.0
     */
    public function it_can_throw_a_throwable()
    {
        $this->expectException(\Error::class);
        $this->mock->shouldReceive('foo')->andThrow(new \Error());
        $this->mock->foo();
    }

    public function testThrowsExceptionBasedOnArgs()
    {
        $this->mock->shouldReceive('foo')->andThrow('OutOfBoundsException');
        $this->expectException(OutOfBoundsException::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testThrowsExceptionBasedOnArgsWithMessage()
    {
        $this->mock->shouldReceive('foo')->andThrow('OutOfBoundsException', 'foo');
        try {
            $this->mock->foo();
        } catch (OutOfBoundsException $e) {
            $this->assertEquals('foo', $e->getMessage());
        }
    }

    public function testThrowsExceptionSequentially()
    {
        $this->mock->shouldReceive('foo')->andThrow(new Exception)->andThrow(new OutOfBoundsException);
        try {
            $this->mock->foo();
        } catch (Exception $e) {
        }
        $this->expectException(OutOfBoundsException::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testAndThrowExceptions()
    {
        $this->mock->shouldReceive('foo')->andThrowExceptions(array(
            new OutOfBoundsException,
            new InvalidArgumentException,
        ));

        try {
            $this->mock->foo();
            throw new Exception("Expected OutOfBoundsException, non thrown");
        } catch (\Exception $e) {
            $this->assertInstanceOf("OutOfBoundsException", $e, "Wrong or no exception thrown: {$e->getMessage()}");
        }

        try {
            $this->mock->foo();
            throw new Exception("Expected InvalidArgumentException, non thrown");
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e, "Wrong or no exception thrown: {$e->getMessage()}");
        }
    }

    public function testAndThrowExceptionsCatchNonExceptionArgument()
    {
        $this->expectException(\Mockery\Exception::class);
        $this->expectExceptionMessage('You must pass an array of exception objects to andThrowExceptions');
        $this->mock
            ->shouldReceive('foo')
            ->andThrowExceptions(array('NotAnException'));
        Mockery::close();
    }

    public function testMultipleExpectationsWithReturns()
    {
        $this->mock->shouldReceive('foo')->with(1)->andReturn(10);
        $this->mock->shouldReceive('bar')->with(2)->andReturn(20);
        $this->assertEquals(10, $this->mock->foo(1));
        $this->assertEquals(20, $this->mock->bar(2));
    }

    public function testExpectsNoArguments()
    {
        $this->mock->shouldReceive('foo')->withNoArgs();
        $this->mock->foo();
    }

    public function testExpectsNoArgumentsThrowsExceptionIfAnyPassed()
    {
        $this->mock->shouldReceive('foo')->withNoArgs();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testExpectsArgumentsArray()
    {
        $this->mock->shouldReceive('foo')->withArgs(array(1, 2));
        $this->mock->foo(1, 2);
    }

    public function testExpectsArgumentsArrayThrowsExceptionIfPassedEmptyArray()
    {
        $this->mock->shouldReceive('foo')->withArgs(array());
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1, 2);
        Mockery::close();
    }

    public function testExpectsArgumentsArrayThrowsExceptionIfNoArgumentsPassed()
    {
        $this->mock->shouldReceive('foo')->with();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testExpectsArgumentsArrayThrowsExceptionIfPassedWrongArguments()
    {
        $this->mock->shouldReceive('foo')->withArgs(array(1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(3, 4);
        Mockery::close();
    }

    public function testExpectsStringArgumentExceptionMessageDifferentiatesBetweenNullAndEmptyString()
    {
        $this->mock->shouldReceive('foo')->withArgs(array('a string'));
        $this->expectException(\Mockery\Exception::class);
        $this->expectExceptionMessageRegExp('/foo\(NULL\)/');
        $this->mock->foo(null);
        Mockery::close();
    }

    public function testExpectsArgumentsArrayThrowsExceptionIfPassedWrongArgumentType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/invalid argument (.+), only array and closure are allowed/');
        $this->mock->shouldReceive('foo')->withArgs(5);
        Mockery::close();
    }

    public function testExpectsArgumentsArrayAcceptAClosureThatValidatesPassedArguments()
    {
        $closure = function ($odd, $even) {
            return ($odd % 2 != 0) && ($even % 2 == 0);
        };
        $this->mock->shouldReceive('foo')->withArgs($closure);
        $this->mock->foo(1, 2);
    }

    public function testExpectsArgumentsArrayThrowsExceptionWhenClosureEvaluatesToFalse()
    {
        $closure = function ($odd, $even) {
            return ($odd % 2 != 0) && ($even % 2 == 0);
        };
        $this->mock->shouldReceive('foo')->withArgs($closure);
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(4, 2);
        Mockery::close();
    }

    public function testExpectsArgumentsArrayClosureDoesNotThrowExceptionIfOptionalArgumentsAreMissing()
    {
        $closure = function ($odd, $even, $sum = null) {
            $result = ($odd % 2 != 0) && ($even % 2 == 0);
            if (!is_null($sum)) {
                return $result && ($odd + $even == $sum);
            }
            return $result;
        };
        $this->mock->shouldReceive('foo')->withArgs($closure);
        $this->mock->foo(1, 4);
    }

    public function testExpectsArgumentsArrayClosureDoesNotThrowExceptionIfOptionalArgumentsMathTheExpectation()
    {
        $closure = function ($odd, $even, $sum = null) {
            $result = ($odd % 2 != 0) && ($even % 2 == 0);
            if (!is_null($sum)) {
                return $result && ($odd + $even == $sum);
            }
            return $result;
        };
        $this->mock->shouldReceive('foo')->withArgs($closure);
        $this->mock->foo(1, 4, 5);
    }

    public function testExpectsArgumentsArrayClosureThrowsExceptionIfOptionalArgumentsDontMatchTheExpectation()
    {
        $closure = function ($odd, $even, $sum = null) {
            $result = ($odd % 2 != 0) && ($even % 2 == 0);
            if (!is_null($sum)) {
                return $result && ($odd + $even == $sum);
            }
            return $result;
        };
        $this->mock->shouldReceive('foo')->withArgs($closure);
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1, 4, 2);
        Mockery::close();
    }

    public function testExpectsSomeOfArgumentsMatchRealArguments()
    {
        $this->mock->shouldReceive('foo')->withSomeOfArgs(1, 3, 5)->times(4);
        $this->mock->foo(1, 2, 3, 4, 5);
        $this->mock->foo(1, 3, 5, 2, 4);
        $this->mock->foo(1, 'foo', 3, 'bar', 5);
        $this->mock->foo(1, 3, 5);
        $this->mock->shouldReceive('foo')->withSomeOfArgs('foo')->times(2);
        $this->mock->foo('foo', 'bar');
        $this->mock->foo('bar', 'foo');
    }

    public function testExpectsSomeOfArgumentsGivenArgsDoNotMatchRealArgsAndThrowNoMatchingException()
    {
        $this->mock->shouldReceive('foo')->withSomeOfArgs(1, 3, 5);
        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->mock->foo(1, 2, 4, 5);
    }

    public function testExpectsAnyArguments()
    {
        $this->mock->shouldReceive('foo')->withAnyArgs();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 'k', new stdClass);
    }

    public function testExpectsArgumentMatchingObjectType()
    {
        $this->mock->shouldReceive('foo')->with('\stdClass');
        $this->mock->foo(new stdClass);
    }

    public function testThrowsExceptionOnNoArgumentMatch()
    {
        $this->mock->shouldReceive('foo')->with(1);
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(2);
        Mockery::close();
    }

    public function testNeverCalled()
    {
        $this->mock->shouldReceive('foo')->never();
    }

    public function testShouldNotReceive()
    {
        $this->mock->shouldNotReceive('foo');
    }

    public function testShouldNotReceiveThrowsExceptionIfMethodCalled()
    {
        $this->mock->shouldNotReceive('foo');
        $this->expectException(\Mockery\Exception\InvalidCountException::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testShouldNotReceiveWithArgumentThrowsExceptionIfMethodCalled()
    {
        $this->mock->shouldNotReceive('foo')->with(2);
        $this->expectException(\Mockery\Exception\InvalidCountException::class);
        $this->mock->foo(2);
        Mockery::close();
    }

    public function testNeverCalledThrowsExceptionOnCall()
    {
        $this->mock->shouldReceive('foo')->never();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testCalledOnce()
    {
        $this->mock->shouldReceive('foo')->once();
        $this->mock->foo();
    }

    public function testCalledOnceThrowsExceptionIfNotCalled()
    {
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->shouldReceive('foo')->once();
        Mockery::close();
    }

    public function testCalledOnceThrowsExceptionIfCalledTwice()
    {
        $this->mock->shouldReceive('foo')->once();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testCalledTwice()
    {
        $this->mock->shouldReceive('foo')->twice();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testCalledTwiceThrowsExceptionIfNotCalled()
    {
        $this->mock->shouldReceive('foo')->twice();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testCalledOnceThrowsExceptionIfCalledThreeTimes()
    {
        $this->mock->shouldReceive('foo')->twice();
        $this->mock->foo();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testCalledZeroOrMoreTimesAtZeroCalls()
    {
        $this->mock->shouldReceive('foo')->zeroOrMoreTimes();
    }

    public function testCalledZeroOrMoreTimesAtThreeCalls()
    {
        $this->mock->shouldReceive('foo')->zeroOrMoreTimes();
        $this->mock->foo();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testTimesCountCalls()
    {
        $this->mock->shouldReceive('foo')->times(4);
        $this->mock->foo();
        $this->mock->foo();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testTimesCountCallThrowsExceptionOnTooFewCalls()
    {
        $this->mock->shouldReceive('foo')->times(2);
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testTimesCountCallThrowsExceptionOnTooManyCalls()
    {
        $this->mock->shouldReceive('foo')->times(2);
        $this->mock->foo();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testCalledAtLeastOnceAtExactlyOneCall()
    {
        $this->mock->shouldReceive('foo')->atLeast()->once();
        $this->mock->foo();
    }

    public function testCalledAtLeastOnceAtExactlyThreeCalls()
    {
        $this->mock->shouldReceive('foo')->atLeast()->times(3);
        $this->mock->foo();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testCalledAtLeastThrowsExceptionOnTooFewCalls()
    {
        $this->mock->shouldReceive('foo')->atLeast()->twice();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testCalledAtMostOnceAtExactlyOneCall()
    {
        $this->mock->shouldReceive('foo')->atMost()->once();
        $this->mock->foo();
    }

    public function testCalledAtMostAtExactlyThreeCalls()
    {
        $this->mock->shouldReceive('foo')->atMost()->times(3);
        $this->mock->foo();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testCalledAtLeastThrowsExceptionOnTooManyCalls()
    {
        $this->mock->shouldReceive('foo')->atMost()->twice();
        $this->mock->foo();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testExactCountersOverrideAnyPriorSetNonExactCounters()
    {
        $this->mock->shouldReceive('foo')->atLeast()->once()->once();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        Mockery::close();
    }

    public function testComboOfLeastAndMostCallsWithOneCall()
    {
        $this->mock->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->mock->foo();
    }

    public function testComboOfLeastAndMostCallsWithTwoCalls()
    {
        $this->mock->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->mock->foo();
        $this->mock->foo();
    }

    public function testComboOfLeastAndMostCallsThrowsExceptionAtTooFewCalls()
    {
        $this->mock->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testComboOfLeastAndMostCallsThrowsExceptionAtTooManyCalls()
    {
        $this->mock->shouldReceive('foo')->atleast()->once()->atMost()->twice();
        $this->mock->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo();
        $this->mock->foo();
        Mockery::close();
    }

    public function testCallCountingOnlyAppliesToMatchedExpectations()
    {
        $this->mock->shouldReceive('foo')->with(1)->once();
        $this->mock->shouldReceive('foo')->with(2)->twice();
        $this->mock->shouldReceive('foo')->with(3);
        $this->mock->foo(1);
        $this->mock->foo(2);
        $this->mock->foo(2);
        $this->mock->foo(3);
    }

    public function testCallCountingThrowsExceptionOnAnyMismatch()
    {
        $this->mock->shouldReceive('foo')->with(1)->once();
        $this->mock->shouldReceive('foo')->with(2)->twice();
        $this->mock->shouldReceive('foo')->with(3);
        $this->mock->shouldReceive('bar');
        $this->mock->foo(1);
        $this->mock->foo(2);
        $this->mock->foo(3);
        $this->mock->bar();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testCallCountingThrowsExceptionFirst()
    {
        $number_of_calls = 0;
        $this->mock->shouldReceive('foo')
            ->times(2)
            ->with(\Mockery::on(function ($argument) use (&$number_of_calls) {
                $number_of_calls++;
                return $number_of_calls <= 3;
            }));

        $this->mock->foo(1);
        $this->mock->foo(1);
        $this->expectException(\Mockery\CountValidator\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testOrderedCallsWithoutError()
    {
        $this->mock->shouldReceive('foo')->ordered();
        $this->mock->shouldReceive('bar')->ordered();
        $this->mock->foo();
        $this->mock->bar();
    }

    public function testOrderedCallsWithOutOfOrderError()
    {
        $this->mock->shouldReceive('foo')->ordered();
        $this->mock->shouldReceive('bar')->ordered();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->bar();
        $this->mock->foo();
        Mockery::close();
    }

    public function testDifferentArgumentsAndOrderingsPassWithoutException()
    {
        $this->mock->shouldReceive('foo')->with(1)->ordered();
        $this->mock->shouldReceive('foo')->with(2)->ordered();
        $this->mock->foo(1);
        $this->mock->foo(2);
    }

    public function testDifferentArgumentsAndOrderingsThrowExceptionWhenInWrongOrder()
    {
        $this->mock->shouldReceive('foo')->with(1)->ordered();
        $this->mock->shouldReceive('foo')->with(2)->ordered();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(2);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testUnorderedCallsIgnoredForOrdering()
    {
        $this->mock->shouldReceive('foo')->with(1)->ordered();
        $this->mock->shouldReceive('foo')->with(2);
        $this->mock->shouldReceive('foo')->with(3)->ordered();
        $this->mock->foo(2);
        $this->mock->foo(1);
        $this->mock->foo(2);
        $this->mock->foo(3);
        $this->mock->foo(2);
    }

    public function testOrderingOfDefaultGrouping()
    {
        $this->mock->shouldReceive('foo')->ordered();
        $this->mock->shouldReceive('bar')->ordered();
        $this->mock->foo();
        $this->mock->bar();
    }

    public function testOrderingOfDefaultGroupingThrowsExceptionOnWrongOrder()
    {
        $this->mock->shouldReceive('foo')->ordered();
        $this->mock->shouldReceive('bar')->ordered();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->bar();
        $this->mock->foo();
        Mockery::close();
    }

    public function testOrderingUsingNumberedGroups()
    {
        $this->mock->shouldReceive('start')->ordered(1);
        $this->mock->shouldReceive('foo')->ordered(2);
        $this->mock->shouldReceive('bar')->ordered(2);
        $this->mock->shouldReceive('final')->ordered();
        $this->mock->start();
        $this->mock->bar();
        $this->mock->foo();
        $this->mock->bar();
        $this->mock->final();
    }

    public function testOrderingUsingNamedGroups()
    {
        $this->mock->shouldReceive('start')->ordered('start');
        $this->mock->shouldReceive('foo')->ordered('foobar');
        $this->mock->shouldReceive('bar')->ordered('foobar');
        $this->mock->shouldReceive('final')->ordered();
        $this->mock->start();
        $this->mock->bar();
        $this->mock->foo();
        $this->mock->bar();
        $this->mock->final();
    }

    /**
     * @group 2A
     */
    public function testGroupedUngroupedOrderingDoNotOverlap()
    {
        $s = $this->mock->shouldReceive('start')->ordered();
        $m = $this->mock->shouldReceive('mid')->ordered('foobar');
        $e = $this->mock->shouldReceive('end')->ordered();
        $this->assertLessThan($m->getOrderNumber(), $s->getOrderNumber());
        $this->assertLessThan($e->getOrderNumber(), $m->getOrderNumber());
    }

    public function testGroupedOrderingThrowsExceptionWhenCallsDisordered()
    {
        $this->mock->shouldReceive('foo')->ordered('first');
        $this->mock->shouldReceive('bar')->ordered('second');
        $this->expectException(\Mockery\Exception::class);
        $this->mock->bar();
        $this->mock->foo();
        Mockery::close();
    }

    public function testExpectationMatchingWithNoArgsOrderings()
    {
        $this->mock->shouldReceive('foo')->withNoArgs()->once()->ordered();
        $this->mock->shouldReceive('bar')->withNoArgs()->once()->ordered();
        $this->mock->shouldReceive('foo')->withNoArgs()->once()->ordered();
        $this->mock->foo();
        $this->mock->bar();
        $this->mock->foo();
    }

    public function testExpectationMatchingWithAnyArgsOrderings()
    {
        $this->mock->shouldReceive('foo')->withAnyArgs()->once()->ordered();
        $this->mock->shouldReceive('bar')->withAnyArgs()->once()->ordered();
        $this->mock->shouldReceive('foo')->withAnyArgs()->once()->ordered();
        $this->mock->foo();
        $this->mock->bar();
        $this->mock->foo();
    }

    public function testEnsuresOrderingIsNotCrossMockByDefault()
    {
        $this->mock->shouldReceive('foo')->ordered();
        $mock2 = mock('bar');
        $mock2->shouldReceive('bar')->ordered();
        $mock2->bar();
        $this->mock->foo();
    }

    public function testEnsuresOrderingIsCrossMockWhenGloballyFlagSet()
    {
        $this->mock->shouldReceive('foo')->globally()->ordered();
        $mock2 = mock('bar');
        $mock2->shouldReceive('bar')->globally()->ordered();
        $this->expectException(\Mockery\Exception::class);
        $mock2->bar();
        $this->mock->foo();
        Mockery::close();
    }

    public function testExpectationCastToStringFormatting()
    {
        $exp = $this->mock->shouldReceive('foo')->with(1, 'bar', new stdClass, array('Spam' => 'Ham', 'Bar' => 'Baz'));
        $this->assertEquals("[foo(1, 'bar', object(stdClass), ['Spam' => 'Ham', 'Bar' => 'Baz'])]", (string) $exp);
    }

    public function testLongExpectationCastToStringFormatting()
    {
        $exp = $this->mock->shouldReceive('foo')->with(array('Spam' => 'Ham', 'Bar' => 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'Bar', 'Baz', 'End'));
        $this->assertEquals("[foo(['Spam' => 'Ham', 'Bar' => 'Baz', 0 => 'Bar', 1 => 'Baz', 2 => 'Bar', 3 => 'Baz', 4 => 'Bar', 5 => 'Baz', 6 => 'Bar', 7 => 'Baz', 8 => 'Bar', 9 => 'Baz', 10 => 'Bar', 11 => 'Baz', 12 => 'Bar', 13 => 'Baz', 14 => 'Bar', 15 => 'Baz', 16 => 'Bar', 17 => 'Baz', 18 => 'Bar', 19 => 'Baz', 20 => 'Bar', 21 => 'Baz', 22 => 'Bar', 23 => 'Baz', 24 => 'Bar', 25 => 'Baz', 26 => 'Bar', 27 => 'Baz', 28 => 'Bar', 29 => 'Baz', 30 => 'Bar', 31 => 'Baz', 32 => 'Bar', 33 => 'Baz', 34 => 'Bar', 35 => 'Baz', 36 => 'Bar', 37 => 'Baz', 38 => 'Bar', 39 => 'Baz', 40 => 'Bar', 41 => 'Baz', 42 => 'Bar', 43 => 'Baz', 44 => 'Bar', 45 => 'Baz', 46 => 'Baz', 47 => 'Bar', 48 => 'Baz', 49 => 'Bar', 50 => 'Baz', 51 => 'Bar', 52 => 'Baz', 53 => 'Bar', 54 => 'Baz', 55 => 'Bar', 56 => 'Baz', 57 => 'Baz', 58 => 'Bar', 59 => 'Baz', 60 => 'Bar', 61 => 'Baz', 62 => 'Bar', 63 => 'Baz', 64 => 'Bar', 65 => 'Baz', 66 => 'Bar', 67 => 'Baz', 68 => 'Baz', 69 => 'Bar', 70 => 'Baz', 71 => 'Bar', 72 => 'Baz', 73 => 'Bar', 74 => 'Baz', 7...])]", (string) $exp);
    }

    public function testMultipleExpectationCastToStringFormatting()
    {
        $exp = $this->mock->shouldReceive('foo', 'bar')->with(1);
        $this->assertEquals('[foo(1), bar(1)]', (string) $exp);
    }

    public function testGroupedOrderingWithLimitsAllowsMultipleReturnValues()
    {
        $this->mock->shouldReceive('foo')->with(2)->once()->andReturn('first');
        $this->mock->shouldReceive('foo')->with(2)->twice()->andReturn('second/third');
        $this->mock->shouldReceive('foo')->with(2)->andReturn('infinity');
        $this->assertEquals('first', $this->mock->foo(2));
        $this->assertEquals('second/third', $this->mock->foo(2));
        $this->assertEquals('second/third', $this->mock->foo(2));
        $this->assertEquals('infinity', $this->mock->foo(2));
        $this->assertEquals('infinity', $this->mock->foo(2));
        $this->assertEquals('infinity', $this->mock->foo(2));
    }

    public function testExpectationsCanBeMarkedAsDefaults()
    {
        $this->mock->shouldReceive('foo')->andReturn('bar')->byDefault();
        $this->assertEquals('bar', $this->mock->foo());
    }

    public function testDefaultExpectationsValidatedInCorrectOrder()
    {
        $this->mock->shouldReceive('foo')->with(1)->once()->andReturn('first')->byDefault();
        $this->mock->shouldReceive('foo')->with(2)->once()->andReturn('second')->byDefault();
        $this->assertEquals('first', $this->mock->foo(1));
        $this->assertEquals('second', $this->mock->foo(2));
    }

    public function testDefaultExpectationsAreReplacedByLaterConcreteExpectations()
    {
        $this->mock->shouldReceive('foo')->andReturn('bar')->once()->byDefault();
        $this->mock->shouldReceive('foo')->andReturn('baz')->twice();
        $this->assertEquals('baz', $this->mock->foo());
        $this->assertEquals('baz', $this->mock->foo());
    }

    public function testExpectationFallsBackToDefaultExpectationWhenConcreteExpectationsAreUsedUp()
    {
        $this->mock->shouldReceive('foo')->with(1)->andReturn('bar')->once()->byDefault();
        $this->mock->shouldReceive('foo')->with(2)->andReturn('baz')->once();
        $this->assertEquals('baz', $this->mock->foo(2));
        $this->assertEquals('bar', $this->mock->foo(1));
    }

    public function testDefaultExpectationsCanBeOrdered()
    {
        $this->mock->shouldReceive('foo')->ordered()->byDefault();
        $this->mock->shouldReceive('bar')->ordered()->byDefault();
        $this->expectException(\Mockery\Exception::class);
        $this->mock->bar();
        $this->mock->foo();
        Mockery::close();
    }

    public function testDefaultExpectationsCanBeOrderedAndReplaced()
    {
        $this->mock->shouldReceive('foo')->ordered()->byDefault();
        $this->mock->shouldReceive('bar')->ordered()->byDefault();
        $this->mock->shouldReceive('bar')->ordered();
        $this->mock->shouldReceive('foo')->ordered();
        $this->mock->bar();
        $this->mock->foo();
    }

    public function testByDefaultOperatesFromMockConstruction()
    {
        $container = new \Mockery\Container(\Mockery::getDefaultGenerator(), \Mockery::getDefaultLoader());
        $mock = $container->mock('f', array('foo'=>'rfoo', 'bar'=>'rbar', 'baz'=>'rbaz'))->byDefault();
        $mock->shouldReceive('foo')->andReturn('foobar');
        $this->assertEquals('foobar', $mock->foo());
        $this->assertEquals('rbar', $mock->bar());
        $this->assertEquals('rbaz', $mock->baz());
    }

    public function testByDefaultOnAMockDoesSquatWithoutExpectations()
    {
        $this->assertInstanceOf(MockInterface::class, mock('f')->byDefault());
    }

    public function testDefaultExpectationsCanBeOverridden()
    {
        $this->mock->shouldReceive('foo')->with('test')->andReturn('bar')->byDefault();
        $this->mock->shouldReceive('foo')->with('test')->andReturn('newbar')->byDefault();
        $this->mock->foo('test');
        $this->assertEquals('newbar', $this->mock->foo('test'));
    }

    public function testByDefaultPreventedFromSettingDefaultWhenDefaultingExpectationWasReplaced()
    {
        $exp = $this->mock->shouldReceive('foo')->andReturn(1);
        $this->mock->shouldReceive('foo')->andReturn(2);
        $this->expectException(\Mockery\Exception::class);
        $exp->byDefault();
        Mockery::close();
    }

    /**
     * Argument Constraint Tests
     */

    public function testAnyConstraintMatchesAnyArg()
    {
        $this->mock->shouldReceive('foo')->with(1, Mockery::any())->twice();
        $this->mock->foo(1, 2);
        $this->mock->foo(1, 'str');
    }

    public function testAnyConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::any())->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testAndAnyOtherConstraintMatchesTheRestOfTheArguments()
    {
        $this->mock->shouldReceive('foo')->with(1, 2, Mockery::andAnyOthers())->twice();
        $this->mock->foo(1, 2, 3, 4, 5);
        $this->mock->foo(1, 'str', 3, 4);
    }

    public function testAndAnyOtherConstraintDoesNotPreventMatchingOfRegularArguments()
    {
        $this->mock->shouldReceive('foo')->with(1, 2, Mockery::andAnyOthers());
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(10, 2, 3, 4, 5);
        Mockery::close();
    }

    public function testArrayConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('array'))->once();
        $this->mock->foo(array());
    }

    public function testArrayConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('array'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testArrayConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('array'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testBoolConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('bool'))->once();
        $this->mock->foo(true);
    }

    public function testBoolConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('bool'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testBoolConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('bool'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testCallableConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('callable'))->once();
        $this->mock->foo(function () {
            return 'f';
        });
    }

    public function testCallableConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('callable'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testCallableConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('callable'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testDoubleConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('double'))->once();
        $this->mock->foo(2.25);
    }

    public function testDoubleConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('double'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testDoubleConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('double'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testFloatConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('float'))->once();
        $this->mock->foo(2.25);
    }

    public function testFloatConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('float'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testFloatConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('float'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testIntConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('int'))->once();
        $this->mock->foo(2);
    }

    public function testIntConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('int'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testIntConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('int'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testLongConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('long'))->once();
        $this->mock->foo(2);
    }

    public function testLongConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('long'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testLongConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('long'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testNullConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('null'))->once();
        $this->mock->foo(null);
    }

    public function testNullConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('null'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testNullConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('null'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testNumericConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('numeric'))->once();
        $this->mock->foo('2');
    }

    public function testNumericConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('numeric'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testNumericConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('numeric'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testObjectConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('object'))->once();
        $this->mock->foo(new stdClass);
    }

    public function testObjectConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('object`'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testObjectConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('object'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testRealConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('float'))->once();
        $this->mock->foo(2.25);
    }

    public function testRealConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('float'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testRealConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('float'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testResourceConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('resource'))->once();
        $r = fopen(dirname(__FILE__) . '/_files/file.txt', 'r');
        $this->mock->foo($r);
    }

    public function testResourceConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('resource'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testResourceConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('resource'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('f');
        Mockery::close();
    }

    public function testScalarConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('scalar'))->once();
        $this->mock->foo(2);
    }

    public function testScalarConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('scalar'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testScalarConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('scalar'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(array());
        Mockery::close();
    }

    public function testStringConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('string'))->once();
        $this->mock->foo('2');
    }

    public function testStringConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('string'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testStringConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('string'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(1);
        Mockery::close();
    }

    public function testClassConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('stdClass'))->once();
        $this->mock->foo(new stdClass);
    }

    public function testClassConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::type('stdClass'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testClassConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::type('stdClass'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(new \DateTime());
        Mockery::close();
    }

    public function testDucktypeConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::ducktype('quack', 'swim'))->once();
        $this->mock->foo(new Mockery_Duck);
    }

    public function testDucktypeConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::ducktype('quack', 'swim'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testDucktypeConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::ducktype('quack', 'swim'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(new Mockery_Duck_Nonswimmer);
        Mockery::close();
    }

    public function testArrayContentConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::subset(array('a'=>1, 'b'=>2)))->once();
        $this->mock->foo(array('a'=>1, 'b'=>2, 'c'=>3));
    }

    public function testArrayContentConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::subset(array('a'=>1, 'b'=>2)))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testArrayContentConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::subset(array('a'=>1, 'b'=>2)));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(array('a'=>1, 'c'=>3));
        Mockery::close();
    }

    public function testContainsConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::contains(1, 2))->once();
        $this->mock->foo(array('a'=>1, 'b'=>2, 'c'=>3));
    }

    public function testContainsConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::contains(1, 2))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testContainsConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::contains(1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(array('a'=>1, 'c'=>3));
        Mockery::close();
    }

    public function testHasKeyConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::hasKey('c'))->once();
        $this->mock->foo(array('a'=>1, 'b'=>2, 'c'=>3));
    }

    public function testHasKeyConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::hasKey('a'))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, array('a'=>1), 3);
    }

    public function testHasKeyConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::hasKey('c'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(array('a'=>1, 'b'=>3));
        Mockery::close();
    }

    public function testHasValueConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::hasValue(1))->once();
        $this->mock->foo(array('a'=>1, 'b'=>2, 'c'=>3));
    }

    public function testHasValueConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::hasValue(1))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, array('a'=>1), 3);
    }

    public function testHasValueConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::hasValue(2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(array('a'=>1, 'b'=>3));
        Mockery::close();
    }

    public function testCaptureStoresArgumentOfTypeScalar_ClosureEvaluatesToTrue()
    {
        $temp = null;
        $this->mock->shouldReceive('foo')->with(Mockery::capture($temp))->once();
        $this->mock->foo(4);

        $this->assertSame(4, $temp);
    }

    public function testCaptureStoresArgumentOfTypeArgument_ClosureEvaluatesToTrue()
    {
        $object = new stdClass();
        $temp = null;
        $this->mock->shouldReceive('foo')->with(Mockery::capture($temp))->once();
        $this->mock->foo($object);

        $this->assertSame($object, $temp);
    }

    public function testOnConstraintMatchesArgument_ClosureEvaluatesToTrue()
    {
        $function = function ($arg) {
            return $arg % 2 == 0;
        };
        $this->mock->shouldReceive('foo')->with(Mockery::on($function))->once();
        $this->mock->foo(4);
    }

    public function testOnConstraintMatchesArgumentOfTypeArray_ClosureEvaluatesToTrue()
    {
        $function = function ($arg) {
            return is_array($arg);
        };
        $this->mock->shouldReceive('foo')->with(Mockery::on($function))->once();
        $this->mock->foo([4, 5]);
    }

    public function testOnConstraintThrowsExceptionWhenConstraintUnmatched_ClosureEvaluatesToFalse()
    {
        $function = function ($arg) {
            return $arg % 2 == 0;
        };
        $this->mock->shouldReceive('foo')->with(Mockery::on($function));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(5);
        Mockery::close();
    }

    public function testMustBeConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::mustBe(2))->once();
        $this->mock->foo(2);
    }

    public function testMustBeConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::mustBe(2))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testMustBeConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::mustBe(2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('2');
        Mockery::close();
    }

    public function testMustBeConstraintMatchesObjectArgumentWithEqualsComparisonNotIdentical()
    {
        $a = new stdClass;
        $a->foo = 1;
        $b = new stdClass;
        $b->foo = 1;
        $this->mock->shouldReceive('foo')->with(Mockery::mustBe($a))->once();
        $this->mock->foo($b);
    }

    public function testMustBeConstraintNonMatchingCaseWithObject()
    {
        $a = new stdClass;
        $a->foo = 1;
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::mustBe($a))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, $a, 3);
    }

    public function testMustBeConstraintThrowsExceptionWhenConstraintUnmatchedWithObject()
    {
        $a = new stdClass;
        $a->foo = 1;
        $b = new stdClass;
        $b->foo = 2;
        $this->mock->shouldReceive('foo')->with(Mockery::mustBe($a));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo($b);
        Mockery::close();
    }

    public function testMatchPrecedenceBasedOnExpectedCallsFavouringExplicitMatch()
    {
        $this->mock->shouldReceive('foo')->with(1)->once();
        $this->mock->shouldReceive('foo')->with(Mockery::any())->never();
        $this->mock->foo(1);
    }

    public function testMatchPrecedenceBasedOnExpectedCallsFavouringAnyMatch()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::any())->once();
        $this->mock->shouldReceive('foo')->with(1)->never();
        $this->mock->foo(1);
    }

    public function testReturnNullIfIgnoreMissingMethodsSet()
    {
        $this->mock->shouldIgnoreMissing();
        $this->assertNull($this->mock->g(1, 2));
    }

    public function testReturnUndefinedIfIgnoreMissingMethodsSet()
    {
        $this->mock->shouldIgnoreMissing()->asUndefined();
        $this->assertInstanceOf(\Mockery\Undefined::class, $this->mock->g(1, 2));
    }

    public function testReturnAsUndefinedAllowsForInfiniteSelfReturningChain()
    {
        $this->mock->shouldIgnoreMissing()->asUndefined();
        $this->assertInstanceOf(\Mockery\Undefined::class, $this->mock->g(1, 2)->a()->b()->c());
    }

    public function testShouldIgnoreMissingFluentInterface()
    {
        $this->assertInstanceOf(\Mockery\MockInterface::class, $this->mock->shouldIgnoreMissing());
    }

    public function testShouldIgnoreMissingAsUndefinedFluentInterface()
    {
        $this->assertInstanceOf(\Mockery\MockInterface::class, $this->mock->shouldIgnoreMissing()->asUndefined());
    }

    public function testShouldIgnoreMissingAsDefinedProxiesToUndefinedAllowingToString()
    {
        $this->mock->shouldIgnoreMissing()->asUndefined();
        $this->assertTrue(is_string("{$this->mock->g()}"));
        $this->assertTrue(is_string("{$this->mock}"));
    }

    public function testShouldIgnoreMissingDefaultReturnValue()
    {
        $this->mock->shouldIgnoreMissing(1);
        $this->assertEquals(1, $this->mock->a());
    }

    /** @issue #253 */
    public function testShouldIgnoreMissingDefaultSelfAndReturnsSelf()
    {
        $this->mock->shouldIgnoreMissing(\Mockery::self());
        $this->assertSame($this->mock, $this->mock->a()->b());
    }

    public function testToStringMagicMethodCanBeMocked()
    {
        $this->mock->shouldReceive("__toString")->andReturn('dave');
        $this->assertEquals("{$this->mock}", "dave");
    }

    public function testOptionalMockRetrieval()
    {
        $m = mock('f')->shouldReceive('foo')->with(1)->andReturn(3)->mock();
        $this->assertInstanceOf(\Mockery\MockInterface::class, $m);
    }

    public function testNotConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::not(1))->once();
        $this->mock->foo(2);
    }

    public function testNotConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::not(2))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testNotConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::not(2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(2);
        Mockery::close();
    }

    public function testAnyOfConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::anyOf(1, 2))->twice();
        $this->mock->foo(2);
        $this->mock->foo(1);
    }

    public function testAnyOfConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::anyOf(1, 2))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 2, 3);
    }

    public function testAnyOfConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::anyOf(1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(3);
        Mockery::close();
    }

    public function testAnyOfConstraintThrowsExceptionWhenTrueIsNotAnExpectedArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::anyOf(1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(true);
    }

    public function testAnyOfConstraintThrowsExceptionWhenFalseIsNotAnExpectedArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::anyOf(0, 1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(false);
    }

    public function testNotAnyOfConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::notAnyOf(1, 2))->once();
        $this->mock->foo(3);
    }

    public function testNotAnyOfConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->times(3);
        $this->mock->shouldReceive('foo')->with(1, Mockery::notAnyOf(1, 2))->never();
        $this->mock->foo();
        $this->mock->foo(1);
        $this->mock->foo(1, 4, 3);
    }

    public function testNotAnyOfConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::notAnyOf(1, 2));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo(2);
        Mockery::close();
    }

    public function testPatternConstraintMatchesArgument()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::pattern('/foo.*/'))->once();
        $this->mock->foo('foobar');
    }

    public function testPatternConstraintNonMatchingCase()
    {
        $this->mock->shouldReceive('foo')->once();
        $this->mock->shouldReceive('foo')->with(Mockery::pattern('/foo.*/'))->never();
        $this->mock->foo('bar');
    }

    public function testPatternConstraintThrowsExceptionWhenConstraintUnmatched()
    {
        $this->mock->shouldReceive('foo')->with(Mockery::pattern('/foo.*/'));
        $this->expectException(\Mockery\Exception::class);
        $this->mock->foo('bar');
        Mockery::close();
    }

    public function testGlobalConfigMayForbidMockingNonExistentMethodsOnClasses()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = mock('stdClass');
        $this->expectException(\Mockery\Exception::class);
        $mock->shouldReceive('foo');
        Mockery::close();
    }

    public function testGlobalConfigMayForbidMockingNonExistentMethodsOnAutoDeclaredClasses()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $this->expectException(\Mockery\Exception::class);
        $this->expectExceptionMessage("Mockery can't find 'SomeMadeUpClass' so can't mock it");
        $mock = mock('SomeMadeUpClass');
        $mock->shouldReceive('foo');
        Mockery::close();
    }

    public function testGlobalConfigMayForbidMockingNonExistentMethodsOnObjects()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $mock = mock(new stdClass);
        $this->expectException(\Mockery\Exception::class);
        $mock->shouldReceive('foo');
        Mockery::close();
    }

    public function testAnExampleWithSomeExpectationAmends()
    {
        $service = mock('MyService');
        $service->shouldReceive('login')->with('user', 'pass')->once()->andReturn(true);
        $service->shouldReceive('hasBookmarksTagged')->with('php')->once()->andReturn(false);
        $service->shouldReceive('addBookmark')->with(Mockery::pattern('/^http:/'), \Mockery::type('string'))->times(3)->andReturn(true);
        $service->shouldReceive('hasBookmarksTagged')->with('php')->once()->andReturn(true);

        $this->assertTrue($service->login('user', 'pass'));
        $this->assertFalse($service->hasBookmarksTagged('php'));
        $this->assertTrue($service->addBookmark('http://example.com/1', 'some_tag1'));
        $this->assertTrue($service->addBookmark('http://example.com/2', 'some_tag2'));
        $this->assertTrue($service->addBookmark('http://example.com/3', 'some_tag3'));
        $this->assertTrue($service->hasBookmarksTagged('php'));
    }

    public function testAnExampleWithSomeExpectationAmendsOnCallCounts()
    {
        $service = mock('MyService');
        $service->shouldReceive('login')->with('user', 'pass')->once()->andReturn(true);
        $service->shouldReceive('hasBookmarksTagged')->with('php')->once()->andReturn(false);
        $service->shouldReceive('addBookmark')->with(Mockery::pattern('/^http:/'), \Mockery::type('string'))->times(3)->andReturn(true);
        $service->shouldReceive('hasBookmarksTagged')->with('php')->twice()->andReturn(true);

        $this->assertTrue($service->login('user', 'pass'));
        $this->assertFalse($service->hasBookmarksTagged('php'));
        $this->assertTrue($service->addBookmark('http://example.com/1', 'some_tag1'));
        $this->assertTrue($service->addBookmark('http://example.com/2', 'some_tag2'));
        $this->assertTrue($service->addBookmark('http://example.com/3', 'some_tag3'));
        $this->assertTrue($service->hasBookmarksTagged('php'));
        $this->assertTrue($service->hasBookmarksTagged('php'));
    }

    public function testAnExampleWithSomeExpectationAmendsOnCallCounts_PHPUnitTest()
    {
        $service = $this->createMock('MyService2');
        $service->expects($this->once())->method('login')->with('user', 'pass')->will($this->returnValue(true));
        $service->expects($this->exactly(3))->method('hasBookmarksTagged')->with('php')
            ->will($this->onConsecutiveCalls(false, true, true));
        $service->expects($this->exactly(3))->method('addBookmark')
            ->with($this->matchesRegularExpression('/^http:/'), $this->isType('string'))
            ->will($this->returnValue(true));

        $this->assertTrue($service->login('user', 'pass'));
        $this->assertFalse($service->hasBookmarksTagged('php'));
        $this->assertTrue($service->addBookmark('http://example.com/1', 'some_tag1'));
        $this->assertTrue($service->addBookmark('http://example.com/2', 'some_tag2'));
        $this->assertTrue($service->addBookmark('http://example.com/3', 'some_tag3'));
        $this->assertTrue($service->hasBookmarksTagged('php'));
        $this->assertTrue($service->hasBookmarksTagged('php'));
    }

    public function testMockedMethodsCallableFromWithinOriginalClass()
    {
        $mock = mock('MockeryTest_InterMethod1[doThird]');
        $mock->shouldReceive('doThird')->andReturn(true);
        $this->assertTrue($mock->doFirst());
    }

    /**
     * @group issue #20
     */
    public function testMockingDemeterChainsPassesMockeryExpectationToCompositeExpectation()
    {
        $mock = mock('Mockery_Demeterowski');
        $mock->shouldReceive('foo->bar->baz')->andReturn('Spam!');
        $demeter = new Mockery_UseDemeter($mock);
        $this->assertSame('Spam!', $demeter->doit());
    }

    /**
     * @group issue #20 - with args in demeter chain
     */
    public function testMockingDemeterChainsPassesMockeryExpectationToCompositeExpectationWithArgs()
    {
        $mock = mock('Mockery_Demeterowski');
        $mock->shouldReceive('foo->bar->baz')->andReturn('Spam!');
        $demeter = new Mockery_UseDemeter($mock);
        $this->assertSame('Spam!', $demeter->doitWithArgs());
    }

    public function testShouldNotReceiveCanBeAddedToCompositeExpectation()
    {
        $mock = mock('Foo');
        $mock->shouldReceive('a')->once()->andReturn('Spam!')
             ->shouldNotReceive('b');
        $mock->a();
    }

    public function testPassthruEnsuresRealMethodCalledForReturnValues()
    {
        $mock = mock('MockeryTest_SubjectCall1');
        $mock->shouldReceive('foo')->once()->passthru();
        $this->assertEquals('bar', $mock->foo());
    }

    public function testPassthruCallMagic()
    {
        $mock = mock('Mockery_Magic');
        $mock->shouldReceive('theAnswer')->once()->passthru();
        $this->assertSame(42, $mock->theAnswer());
    }

    public function testShouldIgnoreMissingExpectationBasedOnArgs()
    {
        $mock = mock("MyService2")->shouldIgnoreMissing();
        $mock->shouldReceive("hasBookmarksTagged")->with("dave")->once();
        $mock->hasBookmarksTagged("dave");
        $mock->hasBookmarksTagged("padraic");
    }

    public function testMakePartialExpectationBasedOnArgs()
    {
        $mock = mock("MockeryTest_SubjectCall1")->makePartial();

        $this->assertEquals('bar', $mock->foo());
        $this->assertEquals('bar', $mock->foo("baz"));
        $this->assertEquals('bar', $mock->foo("qux"));

        $mock->shouldReceive("foo")->with("baz")->twice()->andReturn('123');
        $this->assertEquals('bar', $mock->foo());
        $this->assertEquals('123', $mock->foo("baz"));
        $this->assertEquals('bar', $mock->foo("qux"));

        $mock->shouldReceive("foo")->withNoArgs()->once()->andReturn('456');
        $this->assertEquals('456', $mock->foo());
        $this->assertEquals('123', $mock->foo("baz"));
        $this->assertEquals('bar', $mock->foo("qux"));
    }

    public function testCanReturnSelf()
    {
        $this->mock->shouldReceive("foo")->andReturnSelf();
        $this->assertSame($this->mock, $this->mock->foo());
    }

    public function testReturnsTrueIfTrueIsReturnValue()
    {
        $this->mock->shouldReceive("foo")->andReturnTrue();
        $this->assertTrue($this->mock->foo());
    }

    public function testReturnsFalseIfFalseIsReturnValue()
    {
        $this->mock->shouldReceive("foo")->andReturnFalse();
        $this->assertFalse($this->mock->foo());
    }

    public function testExpectationCanBeOverridden()
    {
        $this->mock->shouldReceive('foo')->once()->andReturn('green');
        $this->mock->shouldReceive('foo')->andReturn('blue');
        $this->assertEquals('green', $this->mock->foo());
        $this->assertEquals('blue', $this->mock->foo());
    }

    public function testTimesExpectationForbidsFloatNumbers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->mock->shouldReceive('foo')->times(1.3);
        Mockery::close();
    }

    public function testIfExceptionIndicatesAbsenceOfMethodAndExpectationsOnMock()
    {
        $mock = mock('Mockery_Duck');

        $this->expectException(
            '\BadMethodCallException',
            'Method ' . get_class($mock) .
            '::nonExistent() does not exist on this mock object'
        );

        $mock->nonExistent();
        Mockery::close();
    }

    public function testIfCallingMethodWithNoExpectationsHasSpecificExceptionMessage()
    {
        $mock = mock('Mockery_Duck');

        $this->expectException(
            '\BadMethodCallException',
            'Received ' . get_class($mock) .
            '::quack(), ' . 'but no expectations were specified'
        );

        $mock->quack();
        Mockery::close();
    }

    public function testMockShouldNotBeAnonymousWhenImplementingSpecificInterface()
    {
        $waterMock = mock('IWater');
        $this->assertFalse($waterMock->mockery_isAnonymous());
    }

    public function testWetherMockWithInterfaceOnlyCanNotImplementNonExistingMethods()
    {
        \Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
        $waterMock = \Mockery::mock('IWater');
        $this->expectException(\Mockery\Exception::class);
        $waterMock
            ->shouldReceive('nonExistentMethod')
            ->once()
            ->andReturnNull();
        \Mockery::close();
    }

    public function testCountWithBecauseExceptionMessage()
    {
        $this->expectException(InvalidCountException::class);
        $this->expectExceptionMessageRegexp(
            '/Method foo\(<Any Arguments>\) from Mockery_[\d]+ should be called' . PHP_EOL . ' ' .
            'exactly 1 times but called 0 times. Because We like foo/'
        );

        $this->mock->shouldReceive('foo')->once()->because('We like foo');
        Mockery::close();
    }

    /** @test */
    public function it_uses_a_matchers_to_string_method_in_the_exception_output()
    {
        $mock = Mockery::mock();

        $mock->expects()->foo(Mockery::hasKey('foo'));

        $this->expectException(
            InvalidCountException::class,
            "Method foo(<HasKey[foo]>)"
        );

        Mockery::close();
    }
}

interface IWater
{
    public function dry();
}

class MockeryTest_SubjectCall1
{
    public function foo()
    {
        return 'bar';
    }
}

class MockeryTest_InterMethod1
{
    public function doFirst()
    {
        return $this->doSecond();
    }

    private function doSecond()
    {
        return $this->doThird();
    }

    public function doThird()
    {
        return false;
    }
}

class MyService2
{
    public function login($user, $pass)
    {
    }
    public function hasBookmarksTagged($tag)
    {
    }
    public function addBookmark($uri, $tag)
    {
    }
}

class Mockery_Duck
{
    public function quack()
    {
    }
    public function swim()
    {
    }
}

class Mockery_Duck_Nonswimmer
{
    public function quack()
    {
    }
}

class Mockery_Demeterowski
{
    public function foo()
    {
        return $this;
    }
    public function bar()
    {
        return $this;
    }
    public function baz()
    {
        return 'Ham!';
    }
}

class Mockery_UseDemeter
{
    public function __construct($demeter)
    {
        $this->demeter = $demeter;
    }
    public function doit()
    {
        return $this->demeter->foo()->bar()->baz();
    }
    public function doitWithArgs()
    {
        return $this->demeter->foo("foo")->bar("bar")->baz("baz");
    }
}

class MockeryTest_Foo
{
    public function foo()
    {
    }
}

class Mockery_Magic
{
    public function __call($method, $args)
    {
        return 42;
    }
}
