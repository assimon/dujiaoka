<?php
namespace Hamcrest\Arrays;

use Hamcrest\AbstractMatcherTest;

class IsArrayContainingTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsArrayContaining::hasItemInArray('irrelevant');
    }

    public function testMatchesAnArrayThatContainsAnElementMatchingTheGivenMatcher()
    {
        $this->assertMatches(
            hasItemInArray('a'),
            array('a', 'b', 'c'),
            "should matches array that contains 'a'"
        );
    }

    public function testDoesNotMatchAnArrayThatDoesntContainAnElementMatchingTheGivenMatcher()
    {
        $this->assertDoesNotMatch(
            hasItemInArray('a'),
            array('b', 'c'),
            "should not matches array that doesn't contain 'a'"
        );
        $this->assertDoesNotMatch(
            hasItemInArray('a'),
            array(),
            'should not match empty array'
        );
    }

    public function testDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            hasItemInArray('a'),
            null,
            'should not match null'
        );
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('an array containing "a"', hasItemInArray('a'));
    }
}
