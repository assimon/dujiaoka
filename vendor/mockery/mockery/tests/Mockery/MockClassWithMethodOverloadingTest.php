<?php

namespace test\Mockery;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Exception\BadMethodCallException;

class MockClassWithMethodOverloadingTest extends MockeryTestCase
{
    public function testCreateMockForClassWithMethodOverloading()
    {
        $mock = mock('test\Mockery\TestWithMethodOverloading')
            ->makePartial();
        $this->assertInstanceOf('test\Mockery\TestWithMethodOverloading', $mock);

        $this->assertSame(42, $mock->theAnswer());
    }

    public function testThrowsWhenMethodDoesNotExist()
    {
        $mock = mock('test\Mockery\TestWithMethodOverloadingWithoutCall')
            ->makePartial();
        $this->assertInstanceOf('test\Mockery\TestWithMethodOverloadingWithoutCall', $mock);

        $this->expectException(BadMethodCallException::class);

        $mock->randomMethod();
    }

    public function testCreateMockForClassWithMethodOverloadingWithExistingMethod()
    {
        $mock = mock('test\Mockery\TestWithMethodOverloading')
            ->makePartial();
        $this->assertInstanceOf('test\Mockery\TestWithMethodOverloading', $mock);

        $this->assertSame(1, $mock->thisIsRealMethod());
    }
}

class TestWithMethodOverloading
{
    public function __call($name, $arguments)
    {
        return 42;
    }

    public function thisIsRealMethod()
    {
        return 1;
    }
}

class TestWithMethodOverloadingWithoutCall
{
}
