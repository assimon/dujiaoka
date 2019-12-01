<?php
namespace Hamcrest\Type;

class IsIntegerTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsInteger::integerValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(5, integerValue());
        assertThat(0, integerValue());
        assertThat(-5, integerValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(integerValue()));
        assertThat(5.2, not(integerValue()));
        assertThat('foo', not(integerValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('an integer', integerValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', integerValue(), null);
        $this->assertMismatchDescription('was a string "foo"', integerValue(), 'foo');
    }
}
