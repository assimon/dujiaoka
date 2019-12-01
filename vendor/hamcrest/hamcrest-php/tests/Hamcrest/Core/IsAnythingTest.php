<?php
namespace Hamcrest\Core;

class IsAnythingTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\IsAnything::anything();
    }

    public function testAlwaysEvaluatesToTrue()
    {
        assertThat(null, anything());
        assertThat(new \stdClass(), anything());
        assertThat('hi', anything());
    }

    public function testHasUsefulDefaultDescription()
    {
        $this->assertDescription('ANYTHING', anything());
    }

    public function testCanOverrideDescription()
    {
        $description = 'description';
        $this->assertDescription($description, anything($description));
    }
}
