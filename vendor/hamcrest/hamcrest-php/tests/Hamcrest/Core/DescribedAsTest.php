<?php
namespace Hamcrest\Core;

class DescribedAsTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\DescribedAs::describedAs('irrelevant', anything());
    }

    public function testOverridesDescriptionOfOtherMatcherWithThatPassedToConstructor()
    {
        $m1 = describedAs('m1 description', anything());
        $m2 = describedAs('m2 description', not(anything()));

        $this->assertDescription('m1 description', $m1);
        $this->assertDescription('m2 description', $m2);
    }

    public function testAppendsValuesToDescription()
    {
        $m = describedAs('value 1 = %0, value 2 = %1', anything(), 33, 97);

        $this->assertDescription('value 1 = <33>, value 2 = <97>', $m);
    }

    public function testDelegatesMatchingToAnotherMatcher()
    {
        $m1 = describedAs('irrelevant', anything());
        $m2 = describedAs('irrelevant', not(anything()));

        $this->assertTrue($m1->matches(new \stdClass()));
        $this->assertFalse($m2->matches('hi'));
    }
}
