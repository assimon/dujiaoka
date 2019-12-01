<?php
namespace Hamcrest\Type;

class IsStringTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsString::stringValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat('', stringValue());
        assertThat("foo", stringValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(stringValue()));
        assertThat(5, not(stringValue()));
        assertThat(array(1, 2, 3), not(stringValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a string', stringValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', stringValue(), null);
        $this->assertMismatchDescription('was a double <5.2F>', stringValue(), 5.2);
    }
}
