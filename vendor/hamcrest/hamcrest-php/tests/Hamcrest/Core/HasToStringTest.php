<?php
namespace Hamcrest\Core;

class PhpForm
{
    public function __toString()
    {
        return 'php';
    }
}

class JavaForm
{
    public function toString()
    {
        return 'java';
    }
}

class BothForms
{
    public function __toString()
    {
        return 'php';
    }

    public function toString()
    {
        return 'java';
    }
}

class HasToStringTest extends \Hamcrest\AbstractMatcherTest
{

    protected function createMatcher()
    {
        return \Hamcrest\Core\HasToString::hasToString('foo');
    }

    public function testMatchesWhenToStringMatches()
    {
        $this->assertMatches(
            hasToString(equalTo('php')),
            new \Hamcrest\Core\PhpForm(),
            'correct __toString'
        );
        $this->assertMatches(
            hasToString(equalTo('java')),
            new \Hamcrest\Core\JavaForm(),
            'correct toString'
        );
    }

    public function testPicksJavaOverPhpToString()
    {
        $this->assertMatches(
            hasToString(equalTo('java')),
            new \Hamcrest\Core\BothForms(),
            'correct toString'
        );
    }

    public function testDoesNotMatchWhenToStringDoesNotMatch()
    {
        $this->assertDoesNotMatch(
            hasToString(equalTo('mismatch')),
            new \Hamcrest\Core\PhpForm(),
            'incorrect __toString'
        );
        $this->assertDoesNotMatch(
            hasToString(equalTo('mismatch')),
            new \Hamcrest\Core\JavaForm(),
            'incorrect toString'
        );
        $this->assertDoesNotMatch(
            hasToString(equalTo('mismatch')),
            new \Hamcrest\Core\BothForms(),
            'incorrect __toString'
        );
    }

    public function testDoesNotMatchNull()
    {
        $this->assertDoesNotMatch(
            hasToString(equalTo('a')),
            null,
            'should not match null'
        );
    }

    public function testProvidesConvenientShortcutForTraversableWithSizeEqualTo()
    {
        $this->assertMatches(
            hasToString(equalTo('php')),
            new \Hamcrest\Core\PhpForm(),
            'correct __toString'
        );
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            'an object with toString() "php"',
            hasToString(equalTo('php'))
        );
    }
}
