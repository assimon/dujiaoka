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

use Psy\Reflection\ReflectionLanguageConstruct;

class ReflectionLanguageConstructTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider languageConstructs
     */
    public function testConstruction($keyword)
    {
        $refl = new ReflectionLanguageConstruct($keyword);
        $this->assertEquals($keyword, $refl->getName());
        $this->assertEquals($keyword, (string) $refl);
    }

    /**
     * @dataProvider languageConstructs
     */
    public function testKnownLanguageConstructs($keyword)
    {
        $this->assertTrue(ReflectionLanguageConstruct::isLanguageConstruct($keyword));
    }

    /**
     * @dataProvider languageConstructs
     */
    public function testFileName($keyword)
    {
        $refl = new ReflectionLanguageConstruct($keyword);
        $this->assertFalse($refl->getFileName());
    }

    /**
     * @dataProvider languageConstructs
     */
    public function testReturnsReference($keyword)
    {
        $refl = new ReflectionLanguageConstruct($keyword);
        $this->assertFalse($refl->returnsReference());
    }

    /**
     * @dataProvider languageConstructs
     */
    public function testGetParameters($keyword)
    {
        $refl = new ReflectionLanguageConstruct($keyword);
        $this->assertNotEmpty($refl->getParameters());
    }

    /**
     * @dataProvider languageConstructs
     * @expectedException \RuntimeException
     */
    public function testExportThrows($keyword)
    {
        ReflectionLanguageConstruct::export($keyword);
    }

    public function languageConstructs()
    {
        return [
            ['isset'],
            ['unset'],
            ['empty'],
            ['echo'],
            ['print'],
            ['die'],
            ['exit'],
        ];
    }

    /**
     * @dataProvider unknownLanguageConstructs
     * @expectedException \InvalidArgumentException
     */
    public function testUnknownLanguageConstructsThrowExceptions($keyword)
    {
        new ReflectionLanguageConstruct($keyword);
    }

    public function unknownLanguageConstructs()
    {
        return [
            ['async'],
            ['await'],
            ['comefrom'],
        ];
    }
}
