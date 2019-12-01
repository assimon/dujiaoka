<?php
namespace Hamcrest\Core;

class EveryTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\Every::everyItem(anything());
    }

    public function testIsTrueWhenEveryValueMatches()
    {
        assertThat(array('AaA', 'BaB', 'CaC'), everyItem(containsString('a')));
        assertThat(array('AbA', 'BbB', 'CbC'), not(everyItem(containsString('a'))));
    }

    public function testIsAlwaysTrueForEmptyLists()
    {
        assertThat(array(), everyItem(containsString('a')));
    }

    public function testDescribesItself()
    {
        $each = everyItem(containsString('a'));
        $this->assertEquals('every item is a string containing "a"', (string) $each);

        $this->assertMismatchDescription('an item was "BbB"', $each, array('BbB'));
    }
}
