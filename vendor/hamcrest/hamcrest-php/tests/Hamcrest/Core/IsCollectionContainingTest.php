<?php
namespace Hamcrest\Core;

class IsCollectionContainingTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\IsCollectionContaining::hasItem(equalTo('irrelevant'));
    }

    public function testMatchesACollectionThatContainsAnElementMatchingTheGivenMatcher()
    {
        $itemMatcher = hasItem(equalTo('a'));

        $this->assertMatches(
            $itemMatcher,
            array('a', 'b', 'c'),
            "should match list that contains 'a'"
        );
    }

    public function testDoesNotMatchCollectionThatDoesntContainAnElementMatchingTheGivenMatcher()
    {
        $matcher1 = hasItem(equalTo('a'));
        $this->assertDoesNotMatch(
            $matcher1,
            array('b', 'c'),
            "should not match list that doesn't contain 'a'"
        );

        $matcher2 = hasItem(equalTo('a'));
        $this->assertDoesNotMatch(
            $matcher2,
            array(),
            'should not match the empty list'
        );
    }

    public function testDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            hasItem(equalTo('a')),
            null,
            'should not match null'
        );
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription('a collection containing "a"', hasItem(equalTo('a')));
    }

    public function testMatchesAllItemsInCollection()
    {
        $matcher1 = hasItems(equalTo('a'), equalTo('b'), equalTo('c'));
        $this->assertMatches(
            $matcher1,
            array('a', 'b', 'c'),
            'should match list containing all items'
        );

        $matcher2 = hasItems('a', 'b', 'c');
        $this->assertMatches(
            $matcher2,
            array('a', 'b', 'c'),
            'should match list containing all items (without matchers)'
        );

        $matcher3 = hasItems(equalTo('a'), equalTo('b'), equalTo('c'));
        $this->assertMatches(
            $matcher3,
            array('c', 'b', 'a'),
            'should match list containing all items in any order'
        );

        $matcher4 = hasItems(equalTo('a'), equalTo('b'), equalTo('c'));
        $this->assertMatches(
            $matcher4,
            array('e', 'c', 'b', 'a', 'd'),
            'should match list containing all items plus others'
        );

        $matcher5 = hasItems(equalTo('a'), equalTo('b'), equalTo('c'));
        $this->assertDoesNotMatch(
            $matcher5,
            array('e', 'c', 'b', 'd'), // 'a' missing
            'should not match list unless it contains all items'
        );
    }
}
