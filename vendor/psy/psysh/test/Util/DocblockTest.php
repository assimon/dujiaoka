<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Util;

use Psy\Util\Docblock;

class DocblockTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider comments
     */
    public function testDocblockParsing($comment, $body, $tags)
    {
        $reflector = $this
            ->getMockBuilder('ReflectionClass')
            ->disableOriginalConstructor()
            ->getMock();

        $reflector->expects($this->once())
            ->method('getDocComment')
            ->will($this->returnValue($comment));

        $docblock = new Docblock($reflector);

        $this->assertSame($body, $docblock->desc);

        foreach ($tags as $tag => $value) {
            $this->assertTrue($docblock->hasTag($tag));
            $this->assertEquals($value, $docblock->tag($tag));
        }
    }

    public function comments()
    {
        if (\defined('HHVM_VERSION')) {
            $this->markTestSkipped('We have issues with PHPUnit mocks on HHVM.');
        }

        return [
            ['', '', []],
            [
                '/**
                 * This is a docblock
                 *
                 * @throws \Exception with a description
                 */',
                'This is a docblock',
                [
                    'throws' => [['type' => '\Exception', 'desc' => 'with a description']],
                ],
            ],
            [
                '/**
                 * This is a slightly longer docblock
                 *
                 * @param int         $foo Is a Foo
                 * @param string      $bar With some sort of description
                 * @param \ClassName $baz is cool too
                 *
                 * @return int At least it isn\'t a string
                 */',
                'This is a slightly longer docblock',
                [
                    'param' => [
                        ['type' => 'int', 'desc' => 'Is a Foo', 'var' => '$foo'],
                        ['type' => 'string', 'desc' => 'With some sort of description', 'var' => '$bar'],
                        ['type' => '\ClassName', 'desc' => 'is cool too', 'var' => '$baz'],
                    ],
                    'return' => [
                        ['type' => 'int', 'desc' => 'At least it isn\'t a string'],
                    ],
                ],
            ],
            [
                '/**
                 * This is a docblock!
                 *
                 * It spans lines, too!
                 *
                 * @tagname plus a description
                 *
                 * @return
                 */',
                "This is a docblock!\n\nIt spans lines, too!",
                [
                    'tagname' => ['plus a description'],
                ],
            ],
        ];
    }
}
