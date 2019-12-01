<?php
namespace Hamcrest\Text;

class StringContainsTest extends \Hamcrest\AbstractMatcherTest
{

    const EXCERPT = 'EXCERPT';

    private $_stringContains;

    public function setUp()
    {
        $this->_stringContains = \Hamcrest\Text\StringContains::containsString(self::EXCERPT);
    }

    protected function createMatcher()
    {
        return $this->_stringContains;
    }

    public function testEvaluatesToTrueIfArgumentContainsSubstring()
    {
        $this->assertTrue(
            $this->_stringContains->matches(self::EXCERPT . 'END'),
            'should be true if excerpt at beginning'
        );
        $this->assertTrue(
            $this->_stringContains->matches('START' . self::EXCERPT),
            'should be true if excerpt at end'
        );
        $this->assertTrue(
            $this->_stringContains->matches('START' . self::EXCERPT . 'END'),
            'should be true if excerpt in middle'
        );
        $this->assertTrue(
            $this->_stringContains->matches(self::EXCERPT . self::EXCERPT),
            'should be true if excerpt is repeated'
        );

        $this->assertFalse(
            $this->_stringContains->matches('Something else'),
            'should not be true if excerpt is not in string'
        );
        $this->assertFalse(
            $this->_stringContains->matches(substr(self::EXCERPT, 1)),
            'should not be true if part of excerpt is in string'
        );
    }

    public function testEvaluatesToTrueIfArgumentIsEqualToSubstring()
    {
        $this->assertTrue(
            $this->_stringContains->matches(self::EXCERPT),
            'should be true if excerpt is entire string'
        );
    }

    public function testEvaluatesToFalseIfArgumentContainsSubstringIgnoringCase()
    {
        $this->assertFalse(
            $this->_stringContains->matches(strtolower(self::EXCERPT)),
            'should be false if excerpt is entire string ignoring case'
        );
        $this->assertFalse(
            $this->_stringContains->matches('START' . strtolower(self::EXCERPT) . 'END'),
            'should be false if excerpt is contained in string ignoring case'
        );
    }

    public function testIgnoringCaseReturnsCorrectMatcher()
    {
        $this->assertTrue(
            $this->_stringContains->ignoringCase()->matches('EXceRpT'),
            'should be true if excerpt is entire string ignoring case'
        );
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            'a string containing "'
            . self::EXCERPT . '"',
            $this->_stringContains
        );
    }
}
