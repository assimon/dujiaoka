<?php
namespace Hamcrest\Number;

class OrderingComparisonTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Number\OrderingComparison::greaterThan(1);
    }

    public function testComparesValuesForGreaterThan()
    {
        assertThat(2, greaterThan(1));
        assertThat(0, not(greaterThan(1)));
    }

    public function testComparesValuesForLessThan()
    {
        assertThat(2, lessThan(3));
        assertThat(0, lessThan(1));
    }

    public function testComparesValuesForEquality()
    {
        assertThat(3, comparesEqualTo(3));
        assertThat('aa', comparesEqualTo('aa'));
    }

    public function testAllowsForInclusiveComparisons()
    {
        assertThat(1, lessThanOrEqualTo(1));
        assertThat(1, greaterThanOrEqualTo(1));
    }

    public function testSupportsDifferentTypesOfComparableValues()
    {
        assertThat(1.1, greaterThan(1.0));
        assertThat("cc", greaterThan("bb"));
    }
}
