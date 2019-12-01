<?php
namespace Hamcrest\Arrays;

use Hamcrest\AbstractMatcherTest;

class IsArrayTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsArray::anArray(array(equalTo('irrelevant')));
    }

    public function testMatchesAnArrayThatMatchesAllTheElementMatchers()
    {
        $this->assertMatches(
            anArray(array(equalTo('a'), equalTo('b'), equalTo('c'))),
            array('a', 'b', 'c'),
            'should match array with matching elements'
        );
    }

    public function testDoesNotMatchAnArrayWhenElementsDoNotMatch()
    {
        $this->assertDoesNotMatch(
            anArray(array(equalTo('a'), equalTo('b'))),
            array('b', 'c'),
            'should not match array with different elements'
        );
    }

    public function testDoesNotMatchAnArrayOfDifferentSize()
    {
        $this->assertDoesNotMatch(
            anArray(array(equalTo('a'), equalTo('b'))),
            array('a', 'b', 'c'),
            'should not match larger array'
        );
        $this->assertDoesNotMatch(
            anArray(array(equalTo('a'), equalTo('b'))),
            array('a'),
            'should not match smaller array'
        );
    }

    public function testDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            anArray(array(equalTo('a'))),
            null,
            'should not match null'
        );
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            '["a", "b"]',
            anArray(array(equalTo('a'), equalTo('b')))
        );
    }

    public function testHasAReadableMismatchDescriptionWhenKeysDontMatch()
    {
        $this->assertMismatchDescription(
            'array keys were [<1>, <2>]',
            anArray(array(equalTo('a'), equalTo('b'))),
            array(1 => 'a', 2 => 'b')
        );
    }

    public function testSupportsMatchesAssociativeArrays()
    {
        $this->assertMatches(
            anArray(array('x'=>equalTo('a'), 'y'=>equalTo('b'), 'z'=>equalTo('c'))),
            array('x'=>'a', 'y'=>'b', 'z'=>'c'),
            'should match associative array with matching elements'
        );
    }

    public function testDoesNotMatchAnAssociativeArrayWhenKeysDoNotMatch()
    {
        $this->assertDoesNotMatch(
            anArray(array('x'=>equalTo('a'), 'y'=>equalTo('b'))),
            array('x'=>'b', 'z'=>'c'),
            'should not match array with different keys'
        );
    }
}
