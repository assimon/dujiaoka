<?php
namespace Hamcrest\Type;

class IsResourceTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsResource::resourceValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(tmpfile(), resourceValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(resourceValue()));
        assertThat(5, not(resourceValue()));
        assertThat('foo', not(resourceValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a resource', resourceValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', resourceValue(), null);
        $this->assertMismatchDescription('was a string "foo"', resourceValue(), 'foo');
    }
}
