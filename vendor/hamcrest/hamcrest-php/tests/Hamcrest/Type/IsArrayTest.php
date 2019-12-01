<?php
namespace Hamcrest\Type;

class IsArrayTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsArray::arrayValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(array('5', 5), arrayValue());
        assertThat(array(), arrayValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(arrayValue()));
        assertThat(5, not(arrayValue()));
        assertThat('foo', not(arrayValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('an array', arrayValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', arrayValue(), null);
        $this->assertMismatchDescription('was a string "foo"', arrayValue(), 'foo');
    }
}
