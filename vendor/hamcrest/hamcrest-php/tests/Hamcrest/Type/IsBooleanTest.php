<?php
namespace Hamcrest\Type;

class IsBooleanTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsBoolean::booleanValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(false, booleanValue());
        assertThat(true, booleanValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(array(), not(booleanValue()));
        assertThat(5, not(booleanValue()));
        assertThat('foo', not(booleanValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a boolean', booleanValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', booleanValue(), null);
        $this->assertMismatchDescription('was a string "foo"', booleanValue(), 'foo');
    }
}
