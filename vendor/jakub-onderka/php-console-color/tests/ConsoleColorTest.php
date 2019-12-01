<?php
use JakubOnderka\PhpConsoleColor\ConsoleColor;

class ConsoleColorWithForceSupport extends ConsoleColor
{
    private $isSupportedForce = true;

    private $are256ColorsSupportedForce = true;

    public function setIsSupported($isSupported)
    {
        $this->isSupportedForce = $isSupported;
    }

    public function isSupported()
    {
        return $this->isSupportedForce;
    }

    public function setAre256ColorsSupported($are256ColorsSupported)
    {
        $this->are256ColorsSupportedForce = $are256ColorsSupported;
    }

    public function are256ColorsSupported()
    {
        return $this->are256ColorsSupportedForce;
    }
}

class ConsoleColorTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConsoleColorWithForceSupport */
    private $uut;

    protected function setUp()
    {
        $this->uut = new ConsoleColorWithForceSupport();
    }

    public function testNone()
    {
        $output = $this->uut->apply('none', 'text');
        $this->assertEquals("text", $output);
    }

    public function testBold()
    {
        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    public function testBoldColorsAreNotSupported()
    {
        $this->uut->setIsSupported(false);

        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals("text", $output);
    }

    public function testBoldColorsAreNotSupportedButAreForced()
    {
        $this->uut->setIsSupported(false);
        $this->uut->setForceStyle(true);

        $output = $this->uut->apply('bold', 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    public function testDark()
    {
        $output = $this->uut->apply('dark', 'text');
        $this->assertEquals("\033[2mtext\033[0m", $output);
    }

    public function testBoldAndDark()
    {
        $output = $this->uut->apply(array('bold', 'dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    public function test256ColorForeground()
    {
        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals("\033[38;5;255mtext\033[0m", $output);
    }

    public function test256ColorWithoutSupport()
    {
        $this->uut->setAre256ColorsSupported(false);

        $output = $this->uut->apply('color_255', 'text');
        $this->assertEquals("text", $output);
    }

    public function test256ColorBackground()
    {
        $output = $this->uut->apply('bg_color_255', 'text');
        $this->assertEquals("\033[48;5;255mtext\033[0m", $output);
    }

    public function test256ColorForegroundAndBackground()
    {
        $output = $this->uut->apply(array('color_200', 'bg_color_255'), 'text');
        $this->assertEquals("\033[38;5;200;48;5;255mtext\033[0m", $output);
    }

    public function testSetOwnTheme()
    {
        $this->uut->setThemes(array('bold_dark' => array('bold', 'dark')));
        $output = $this->uut->apply(array('bold_dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    public function testAddOwnTheme()
    {
        $this->uut->addTheme('bold_own', 'bold');
        $output = $this->uut->apply(array('bold_own'), 'text');
        $this->assertEquals("\033[1mtext\033[0m", $output);
    }

    public function testAddOwnThemeArray()
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark'), 'text');
        $this->assertEquals("\033[1;2mtext\033[0m", $output);
    }

    public function testOwnWithStyle()
    {
        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $output = $this->uut->apply(array('bold_dark', 'italic'), 'text');
        $this->assertEquals("\033[1;2;3mtext\033[0m", $output);
    }

    public function testHasAndRemoveTheme()
    {
        $this->assertFalse($this->uut->hasTheme('bold_dark'));

        $this->uut->addTheme('bold_dark', array('bold', 'dark'));
        $this->assertTrue($this->uut->hasTheme('bold_dark'));

        $this->uut->removeTheme('bold_dark');
        $this->assertFalse($this->uut->hasTheme('bold_dark'));
    }

    public function testApplyInvalidArgument()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->uut->apply(new stdClass(), 'text');
    }

    public function testApplyInvalidStyleName()
    {
        $this->setExpectedException('\JakubOnderka\PhpConsoleColor\InvalidStyleException');
        $this->uut->apply('invalid', 'text');
    }

    public function testApplyInvalid256Color()
    {
        $this->setExpectedException('\JakubOnderka\PhpConsoleColor\InvalidStyleException');
        $this->uut->apply('color_2134', 'text');
    }

    public function testThemeInvalidStyle()
    {
        $this->setExpectedException('\JakubOnderka\PhpConsoleColor\InvalidStyleException');
        $this->uut->addTheme('invalid', array('invalid'));
    }

    public function testForceStyle()
    {
        $this->assertFalse($this->uut->isStyleForced());
        $this->uut->setForceStyle(true);
        $this->assertTrue($this->uut->isStyleForced());
    }

    public function testGetPossibleStyles()
    {
        $this->assertInternalType('array', $this->uut->getPossibleStyles());
        $this->assertNotEmpty($this->uut->getPossibleStyles());
    }
}

