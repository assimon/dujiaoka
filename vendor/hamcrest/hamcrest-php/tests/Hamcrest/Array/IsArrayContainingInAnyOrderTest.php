<?php
namespace Hamcrest\Arrays;

use Hamcrest\AbstractMatcherTest;

class IsArrayContainingInAnyOrderTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsArrayContainingInAnyOrder::arrayContainingInAnyOrder(array(1, 2));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('[<1>, <2>] in any order', containsInAnyOrder(array(1, 2)));
    }

    public function testMatchesItemsInAnyOrder()
    {
        $this->assertMatches(containsInAnyOrder(array(1, 2, 3)), array(1, 2, 3), 'in order');
        $this->assertMatches(containsInAnyOrder(array(1, 2, 3)), array(3, 2, 1), 'out of order');
        $this->assertMatches(containsInAnyOrder(array(1)), array(1), 'single');
    }

    public function testAppliesMatchersInAnyOrder()
    {
        $this->assertMatches(
            containsInAnyOrder(array(1, 2, 3)),
            array(1, 2, 3),
            'in order'
        );
        $this->assertMatches(
            containsInAnyOrder(array(1, 2, 3)),
            array(3, 2, 1),
            'out of order'
        );
        $this->assertMatches(
            containsInAnyOrder(array(1)),
            array(1),
            'single'
        );
    }

    public function testMismatchesItemsInAnyOrder()
    {
        $matcher = containsInAnyOrder(array(1, 2, 3));

        $this->assertMismatchDescription('was null', $matcher, null);
        $this->assertMismatchDescription('No item matches: <1>, <2>, <3> in []', $matcher, array());
        $this->assertMismatchDescription('No item matches: <2>, <3> in [<1>]', $matcher, array(1));
        $this->assertMismatchDescription('Not matched: <4>', $matcher, array(4, 3, 2, 1));
    }
}
