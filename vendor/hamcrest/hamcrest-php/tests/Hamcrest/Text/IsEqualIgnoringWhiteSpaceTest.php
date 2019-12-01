<?php
namespace Hamcrest\Text;

class IsEqualIgnoringWhiteSpaceTest extends \Hamcrest\AbstractMatcherTest
{

    private $_matcher;

    public function setUp()
    {
        $this->_matcher = \Hamcrest\Text\IsEqualIgnoringWhiteSpace::equalToIgnoringWhiteSpace(
            "Hello World   how\n are we? "
        );
    }

    protected function createMatcher()
    {
        return $this->_matcher;
    }

    public function testPassesIfWordsAreSameButWhitespaceDiffers()
    {
        assertThat('Hello World how are we?', $this->_matcher);
        assertThat("   Hello \rWorld \t  how are\nwe?", $this->_matcher);
    }

    public function testFailsIfTextOtherThanWhitespaceDiffers()
    {
        assertThat('Hello PLANET how are we?', not($this->_matcher));
        assertThat('Hello World how are we', not($this->_matcher));
    }

    public function testFailsIfWhitespaceIsAddedOrRemovedInMidWord()
    {
        assertThat('HelloWorld how are we?', not($this->_matcher));
        assertThat('Hello Wo rld how are we?', not($this->_matcher));
    }

    public function testFailsIfMatchingAgainstNull()
    {
        assertThat(null, not($this->_matcher));
    }

    public function testHasAReadableDescription()
    {
        $this->assertDescription(
            "equalToIgnoringWhiteSpace(\"Hello World   how\\n are we? \")",
            $this->_matcher
        );
    }
}
