<?php

namespace test\Mockery;

use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @requires PHP 7.2.0-dev
 */
class Php72LanguageFeaturesTest extends MockeryTestCase
{
    /** @test */
    public function it_can_mock_a_class_with_an_object_argument_type_hint()
    {
        $mock = mock(ArgumentObjectTypeHint::class);
        $object = new \stdClass;
        $mock->allows()->foo($object);

        $mock->foo($object);
    }
    
    /** @test */
    public function it_can_mock_a_class_with_an_object_return_type_hint()
    {
        $mock = spy(ReturnTypeObjectTypeHint::class);

        $object = $mock->foo();

        $this->assertTrue(is_object($object));
    }
}

class ArgumentObjectTypeHint
{
    public function foo(object $foo)
    {
    }
}

class ReturnTypeObjectTypeHint
{
    public function foo(): object
    {
    }
}
