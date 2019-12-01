<?php
namespace Hamcrest\Core;

class CombinableMatcherTest extends \Hamcrest\AbstractMatcherTest
{

    private $_either_3_or_4;
    private $_not_3_and_not_4;

    public function setUp()
    {
        $this->_either_3_or_4 = \Hamcrest\Core\CombinableMatcher::either(equalTo(3))->orElse(equalTo(4));
        $this->_not_3_and_not_4 = \Hamcrest\Core\CombinableMatcher::both(not(equalTo(3)))->andAlso(not(equalTo(4)));
    }

    protected function createMatcher()
    {
        return \Hamcrest\Core\CombinableMatcher::either(equalTo('irrelevant'))->orElse(equalTo('ignored'));
    }

    public function testBothAcceptsAndRejects()
    {
        assertThat(2, $this->_not_3_and_not_4);
        assertThat(3, not($this->_not_3_and_not_4));
    }

    public function testAcceptsAndRejectsThreeAnds()
    {
        $tripleAnd = $this->_not_3_and_not_4->andAlso(equalTo(2));
        assertThat(2, $tripleAnd);
        assertThat(3, not($tripleAnd));
    }

    public function testBothDescribesItself()
    {
        $this->assertEquals('(not <3> and not <4>)', (string) $this->_not_3_and_not_4);
        $this->assertMismatchDescription('was <3>', $this->_not_3_and_not_4, 3);
    }

    public function testEitherAcceptsAndRejects()
    {
        assertThat(3, $this->_either_3_or_4);
        assertThat(6, not($this->_either_3_or_4));
    }

    public function testAcceptsAndRejectsThreeOrs()
    {
        $orTriple = $this->_either_3_or_4->orElse(greaterThan(10));

        assertThat(11, $orTriple);
        assertThat(9, not($orTriple));
    }

    public function testEitherDescribesItself()
    {
        $this->assertEquals('(<3> or <4>)', (string) $this->_either_3_or_4);
        $this->assertMismatchDescription('was <6>', $this->_either_3_or_4, 6);
    }
}
