<?php
namespace Hamcrest;

/* Test-specific subclass only */
class BaseMatcherTest extends \Hamcrest\BaseMatcher
{

    public function matches($item)
    {
        throw new \RuntimeException();
    }

    public function describeTo(\Hamcrest\Description $description)
    {
        $description->appendText('SOME DESCRIPTION');
    }

    public function testDescribesItselfWithToStringMethod()
    {
        $someMatcher = new \Hamcrest\SomeMatcher();
        $this->assertEquals('SOME DESCRIPTION', (string) $someMatcher);
    }
}
