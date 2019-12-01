<?php
namespace Hamcrest\Text;

class MatchesPatternTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return matchesPattern('/o+b/');
    }

    public function testEvaluatesToTrueIfArgumentmatchesPattern()
    {
        assertThat('foobar', matchesPattern('/o+b/'));
        assertThat('foobar', matchesPattern('/^foo/'));
        assertThat('foobar', matchesPattern('/ba*r$/'));
        assertThat('foobar', matchesPattern('/^foobar$/'));
    }

    public function testEvaluatesToFalseIfArgumentDoesntMatchRegex()
    {
        assertThat('foobar', not(matchesPattern('/^foob$/')));
        assertThat('foobar', not(matchesPattern('/oobe/')));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a string matching "pattern"', matchesPattern('pattern'));
    }
}
