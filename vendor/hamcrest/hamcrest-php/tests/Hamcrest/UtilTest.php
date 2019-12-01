<?php
namespace Hamcrest;

class UtilTest extends \PhpUnit_Framework_TestCase
{

    public function testWrapValueWithIsEqualLeavesMatchersUntouched()
    {
        $matcher = new \Hamcrest\Text\MatchesPattern('/fo+/');
        $newMatcher = \Hamcrest\Util::wrapValueWithIsEqual($matcher);
        $this->assertSame($matcher, $newMatcher);
    }

    public function testWrapValueWithIsEqualWrapsPrimitive()
    {
        $matcher = \Hamcrest\Util::wrapValueWithIsEqual('foo');
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matcher);
        $this->assertTrue($matcher->matches('foo'));
    }

    public function testCheckAllAreMatchersAcceptsMatchers()
    {
        \Hamcrest\Util::checkAllAreMatchers(array(
            new \Hamcrest\Text\MatchesPattern('/fo+/'),
            new \Hamcrest\Core\IsEqual('foo'),
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCheckAllAreMatchersFailsForPrimitive()
    {
        \Hamcrest\Util::checkAllAreMatchers(array(
            new \Hamcrest\Text\MatchesPattern('/fo+/'),
            'foo',
        ));
    }

    private function callAndAssertCreateMatcherArray($items)
    {
        $matchers = \Hamcrest\Util::createMatcherArray($items);
        $this->assertInternalType('array', $matchers);
        $this->assertSameSize($items, $matchers);
        foreach ($matchers as $matcher) {
            $this->assertInstanceOf('\Hamcrest\Matcher', $matcher);
        }

        return $matchers;
    }

    public function testCreateMatcherArrayLeavesMatchersUntouched()
    {
        $matcher = new \Hamcrest\Text\MatchesPattern('/fo+/');
        $items = array($matcher);
        $matchers = $this->callAndAssertCreateMatcherArray($items);
        $this->assertSame($matcher, $matchers[0]);
    }

    public function testCreateMatcherArrayWrapsPrimitiveWithIsEqualMatcher()
    {
        $matchers = $this->callAndAssertCreateMatcherArray(array('foo'));
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matchers[0]);
        $this->assertTrue($matchers[0]->matches('foo'));
    }

    public function testCreateMatcherArrayDoesntModifyOriginalArray()
    {
        $items = array('foo');
        $this->callAndAssertCreateMatcherArray($items);
        $this->assertSame('foo', $items[0]);
    }

    public function testCreateMatcherArrayUnwrapsSingleArrayElement()
    {
        $matchers = $this->callAndAssertCreateMatcherArray(array(array('foo')));
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matchers[0]);
        $this->assertTrue($matchers[0]->matches('foo'));
    }
}
