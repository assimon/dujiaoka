<?php
namespace Hamcrest;

class MatcherAssertTest extends \PhpUnit_Framework_TestCase
{

    protected function setUp()
    {
        \Hamcrest\MatcherAssert::resetCount();
    }

    public function testResetCount()
    {
        \Hamcrest\MatcherAssert::assertThat(true);
        self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        \Hamcrest\MatcherAssert::resetCount();
        self::assertEquals(0, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithTrueArgPasses()
    {
        \Hamcrest\MatcherAssert::assertThat(true);
        \Hamcrest\MatcherAssert::assertThat('non-empty');
        \Hamcrest\MatcherAssert::assertThat(1);
        \Hamcrest\MatcherAssert::assertThat(3.14159);
        \Hamcrest\MatcherAssert::assertThat(array(true));
        self::assertEquals(5, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithFalseArgFails()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat(false);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat(null);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('');
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat(0);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat(0.0);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat(array());
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('', $ex->getMessage());
        }
        self::assertEquals(6, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithIdentifierAndTrueArgPasses()
    {
        \Hamcrest\MatcherAssert::assertThat('identifier', true);
        \Hamcrest\MatcherAssert::assertThat('identifier', 'non-empty');
        \Hamcrest\MatcherAssert::assertThat('identifier', 1);
        \Hamcrest\MatcherAssert::assertThat('identifier', 3.14159);
        \Hamcrest\MatcherAssert::assertThat('identifier', array(true));
        self::assertEquals(5, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithIdentifierAndFalseArgFails()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', false);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', null);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', '');
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', 0);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', 0.0);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', array());
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        self::assertEquals(6, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithActualValueAndMatcherArgsThatMatchPasses()
    {
        \Hamcrest\MatcherAssert::assertThat(true, is(true));
        self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithActualValueAndMatcherArgsThatDontMatchFails()
    {
        $expected = 'expected';
        $actual = 'actual';

        $expectedMessage =
            'Expected: "expected"' . PHP_EOL .
            '     but: was "actual"';

        try {
            \Hamcrest\MatcherAssert::assertThat($actual, equalTo($expected));
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals($expectedMessage, $ex->getMessage());
            self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithIdentifierAndActualValueAndMatcherArgsThatMatchPasses()
    {
        \Hamcrest\MatcherAssert::assertThat('identifier', true, is(true));
        self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithIdentifierAndActualValueAndMatcherArgsThatDontMatchFails()
    {
        $expected = 'expected';
        $actual = 'actual';

        $expectedMessage =
            'identifier' . PHP_EOL .
            'Expected: "expected"' . PHP_EOL .
            '     but: was "actual"';

        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', $actual, equalTo($expected));
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals($expectedMessage, $ex->getMessage());
            self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithNoArgsThrowsErrorAndDoesntIncrementCount()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat();
            self::fail('expected invalid argument exception');
        } catch (\InvalidArgumentException $ex) {
            self::assertEquals(0, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithFourArgsThrowsErrorAndDoesntIncrementCount()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat(1, 2, 3, 4);
            self::fail('expected invalid argument exception');
        } catch (\InvalidArgumentException $ex) {
            self::assertEquals(0, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }
}
