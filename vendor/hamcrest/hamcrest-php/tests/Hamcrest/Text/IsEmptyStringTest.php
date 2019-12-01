<?php
namespace Hamcrest\Text;

class IsEmptyStringTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Text\IsEmptyString::isEmptyOrNullString();
    }

    public function testEmptyDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(emptyString(), null, 'null');
    }

    public function testEmptyDoesNotMatchZero()
    {
        $this->assertDoesNotMatch(emptyString(), 0, 'zero');
    }

    public function testEmptyDoesNotMatchFalse()
    {
        $this->assertDoesNotMatch(emptyString(), false, 'false');
    }

    public function testEmptyDoesNotMatchEmptyArray()
    {
        $this->assertDoesNotMatch(emptyString(), array(), 'empty array');
    }

    public function testEmptyMatchesEmptyString()
    {
        $this->assertMatches(emptyString(), '', 'empty string');
    }

    public function testEmptyDoesNotMatchNonEmptyString()
    {
        $this->assertDoesNotMatch(emptyString(), 'foo', 'non-empty string');
    }

    public function testEmptyHasAReadableDescription()
    {
        $this->assertDescription('an empty string', emptyString());
    }

    public function testEmptyOrNullMatchesNull()
    {
        $this->assertMatches(nullOrEmptyString(), null, 'null');
    }

    public function testEmptyOrNullMatchesEmptyString()
    {
        $this->assertMatches(nullOrEmptyString(), '', 'empty string');
    }

    public function testEmptyOrNullDoesNotMatchNonEmptyString()
    {
        $this->assertDoesNotMatch(nullOrEmptyString(), 'foo', 'non-empty string');
    }

    public function testEmptyOrNullHasAReadableDescription()
    {
        $this->assertDescription('(null or an empty string)', nullOrEmptyString());
    }

    public function testNonEmptyDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(nonEmptyString(), null, 'null');
    }

    public function testNonEmptyDoesNotMatchEmptyString()
    {
        $this->assertDoesNotMatch(nonEmptyString(), '', 'empty string');
    }

    public function testNonEmptyMatchesNonEmptyString()
    {
        $this->assertMatches(nonEmptyString(), 'foo', 'non-empty string');
    }

    public function testNonEmptyHasAReadableDescription()
    {
        $this->assertDescription('a non-empty string', nonEmptyString());
    }
}
