<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Reflection;

use Psy\Reflection\ReflectionConstant_;

\define('Psy\\Test\\Reflection\\SOME_CONSTANT', 'yep');

class ReflectionConstantTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruction()
    {
        $refl = new ReflectionConstant_('Psy\\Test\\Reflection\\SOME_CONSTANT');

        $this->assertFalse($refl->getDocComment());
        $this->assertEquals('Psy\\Test\\Reflection\\SOME_CONSTANT', $refl->getName());
        $this->assertEquals('Psy\\Test\\Reflection', $refl->getNamespaceName());
        $this->assertEquals('yep', $refl->getValue());
        $this->assertTrue($refl->inNamespace());
        $this->assertEquals('Psy\\Test\\Reflection\\SOME_CONSTANT', (string) $refl);
        $this->assertNull($refl->getFileName());
    }

    public function testBuiltInConstant()
    {
        $refl = new ReflectionConstant_('PHP_VERSION');

        $this->assertEquals('PHP_VERSION', $refl->getName());
        $this->assertEquals('PHP_VERSION', (string) $refl);
        $this->assertEquals(PHP_VERSION, $refl->getValue());
        $this->assertFalse($refl->inNamespace());
        $this->assertSame('', $refl->getNamespaceName());
    }

    /**
     * @dataProvider magicConstants
     */
    public function testIsMagicConstant($name, $is)
    {
        $this->assertEquals($is, ReflectionConstant_::isMagicConstant($name));
    }

    public function magicConstants()
    {
        return [
            ['__LINE__', true],
            ['__FILE__', true],
            ['__DIR__', true],
            ['__FUNCTION__', true],
            ['__CLASS__', true],
            ['__TRAIT__', true],
            ['__METHOD__', true],
            ['__NAMESPACE__', true],
            ['__COMPILER_HALT_OFFSET__', true],
            ['PHP_VERSION', false],
            ['PHP_EOL', false],
            ['Psy\\Test\\Reflection\\SOME_CONSTANT', false],
            ['What if it isn\'t even a valid constant name?', false],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnknownConstantThrowsException()
    {
        new ReflectionConstant_('UNKNOWN_CONSTANT');
    }

    public function testExport()
    {
        $ret = ReflectionConstant_::export('Psy\\Test\\Reflection\\SOME_CONSTANT', true);
        $this->assertEquals($ret, 'Constant [ string Psy\\Test\\Reflection\\SOME_CONSTANT ] { yep }');
    }

    public function testExportOutput()
    {
        $this->expectOutputString("Constant [ string Psy\\Test\\Reflection\\SOME_CONSTANT ] { yep }\n");
        ReflectionConstant_::export('Psy\\Test\\Reflection\\SOME_CONSTANT', false);
    }

    public function testGetFileName()
    {
        $refl = new ReflectionConstant_('Psy\\Test\\Reflection\\SOME_CONSTANT');
        $this->assertNull($refl->getFileName());
    }

    /**
     * @expectedException \RuntimeException
     * @dataProvider notYetImplemented
     */
    public function testNotYetImplemented($method)
    {
        $refl = new ReflectionConstant_('Psy\\Test\\Reflection\\SOME_CONSTANT');
        $refl->$method();
    }

    public function notYetImplemented()
    {
        return [
            ['getStartLine'],
            ['getEndLine'],
        ];
    }
}
