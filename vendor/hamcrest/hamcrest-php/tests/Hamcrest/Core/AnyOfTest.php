<?php
namespace Hamcrest\Core;

class AnyOfTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\AnyOf::anyOf('irrelevant');
    }

    public function testAnyOfEvaluatesToTheLogicalDisjunctionOfTwoOtherMatchers()
    {
        assertThat('good', anyOf('bad', 'good'));
        assertThat('good', anyOf('good', 'good'));
        assertThat('good', anyOf('good', 'bad'));

        assertThat('good', not(anyOf('bad', startsWith('b'))));
    }

    public function testAnyOfEvaluatesToTheLogicalDisjunctionOfManyOtherMatchers()
    {
        assertThat('good', anyOf('bad', 'good', 'bad', 'bad', 'bad'));
        assertThat('good', not(anyOf('bad', 'bad', 'bad', 'bad', 'bad')));
    }

    public function testAnyOfSupportsMixedTypes()
    {
        $combined = anyOf(
            equalTo(new \Hamcrest\Core\SampleBaseClass('good')),
            equalTo(new \Hamcrest\Core\SampleBaseClass('ugly')),
            equalTo(new \Hamcrest\Core\SampleSubClass('good'))
        );

        assertThat(new \Hamcrest\Core\SampleSubClass('good'), $combined);
    }

    public function testAnyOfHasAReadableDescription()
    {
        $this->assertDescription(
            '("good" or "bad" or "ugly")',
            anyOf('good', 'bad', 'ugly')
        );
    }

    public function testNoneOfEvaluatesToTheLogicalDisjunctionOfTwoOtherMatchers()
    {
        assertThat('good', not(noneOf('bad', 'good')));
        assertThat('good', not(noneOf('good', 'good')));
        assertThat('good', not(noneOf('good', 'bad')));

        assertThat('good', noneOf('bad', startsWith('b')));
    }

    public function testNoneOfEvaluatesToTheLogicalDisjunctionOfManyOtherMatchers()
    {
        assertThat('good', not(noneOf('bad', 'good', 'bad', 'bad', 'bad')));
        assertThat('good', noneOf('bad', 'bad', 'bad', 'bad', 'bad'));
    }

    public function testNoneOfSupportsMixedTypes()
    {
        $combined = noneOf(
            equalTo(new \Hamcrest\Core\SampleBaseClass('good')),
            equalTo(new \Hamcrest\Core\SampleBaseClass('ugly')),
            equalTo(new \Hamcrest\Core\SampleSubClass('good'))
        );

        assertThat(new \Hamcrest\Core\SampleSubClass('bad'), $combined);
    }

    public function testNoneOfHasAReadableDescription()
    {
        $this->assertDescription(
            'not ("good" or "bad" or "ugly")',
            noneOf('good', 'bad', 'ugly')
        );
    }
}
