<?php
namespace Hamcrest\Type;

class IsObjectTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsObject::objectValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(new \stdClass, objectValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(objectValue()));
        assertThat(5, not(objectValue()));
        assertThat('foo', not(objectValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('an object', objectValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', objectValue(), null);
        $this->assertMismatchDescription('was a string "foo"', objectValue(), 'foo');
    }
}
