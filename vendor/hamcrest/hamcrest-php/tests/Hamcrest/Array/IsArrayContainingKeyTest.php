<?php
namespace Hamcrest\Arrays;

use Hamcrest\AbstractMatcherTest;

class IsArrayContainingKeyTest extends AbstractMatcherTest
{

    protected function createMatcher()
    {
        return IsArrayContainingKey::hasKeyInArray('irrelevant');
    }

    public function testMatchesSingleElementArrayContainingKey()
    {
        $array = array('a'=>1);

        $this->assertMatches(hasKey('a'), $array, 'Matches single key');
    }

    public function testMatchesArrayContainingKey()
    {
        $array = array('a'=>1, 'b'=>2, 'c'=>3);

        $this->assertMatches(hasKey('a'), $array, 'Matches a');
        $this->assertMatches(hasKey('c'), $array, 'Matches c');
    }

    public function testMatchesArrayContainingKeyWithIntegerKeys()
    {
        $array = array(1=>'A', 2=>'B');

        assertThat($array, hasKey(1));
    }

    public function testMatchesArrayContainingKeyWithNumberKeys()
    {
        $array = array(1=>'A', 2=>'B');

        assertThat($array, hasKey(1));

        // very ugly version!
        assertThat($array, IsArrayContainingKey::hasKeyInArray(2));
    }

    public function testHasReadableDescription()
    {
        $this->assertDescription('array with key "a"', hasKey('a'));
    }

    public function testDoesNotMatchEmptyArray()
    {
        $this->assertMismatchDescription('array was []', hasKey('Foo'), array());
    }

    public function testDoesNotMatchArrayMissingKey()
    {
        $array = array('a'=>1, 'b'=>2, 'c'=>3);

        $this->assertMismatchDescription('array was ["a" => <1>, "b" => <2>, "c" => <3>]', hasKey('d'), $array);
    }
}
