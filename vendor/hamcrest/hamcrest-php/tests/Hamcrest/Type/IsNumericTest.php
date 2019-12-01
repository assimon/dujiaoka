<?php
namespace Hamcrest\Type;

class IsNumericTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Type\IsNumeric::numericValue();
    }

    public function testEvaluatesToTrueIfArgumentMatchesType()
    {
        assertThat(5, numericValue());
        assertThat(0, numericValue());
        assertThat(-5, numericValue());
        assertThat(5.3, numericValue());
        assertThat(0.53, numericValue());
        assertThat(-5.3, numericValue());
        assertThat('5', numericValue());
        assertThat('0', numericValue());
        assertThat('-5', numericValue());
        assertThat('5.3', numericValue());
        assertThat('5e+3', numericValue());
        assertThat('0.053e-2', numericValue());
        assertThat('-53.253e+25', numericValue());
        assertThat('+53.253e+25', numericValue());
        assertThat(0x4F2a04, numericValue());
        assertThat('0x4F2a04', numericValue());
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchType()
    {
        assertThat(false, not(numericValue()));
        assertThat('foo', not(numericValue()));
        assertThat('foo5', not(numericValue()));
        assertThat('5foo', not(numericValue()));
        assertThat('0x42A04G', not(numericValue())); // G is not in the hexadecimal range.
        assertThat('1x42A04', not(numericValue())); // 1x is not a valid hexadecimal sequence.
        assertThat('0x', not(numericValue()));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a number', numericValue());
    }

    public function testDecribesActualTypeInMismatchMessage()
    {
        $this->assertMismatchDescription('was null', numericValue(), null);
        $this->assertMismatchDescription('was a string "foo"', numericValue(), 'foo');
    }
}
