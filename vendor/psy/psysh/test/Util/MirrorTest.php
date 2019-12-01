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

use Psy\Util\Mirror;

class MirrorTest extends \PHPUnit\Framework\TestCase
{
    const FOO           = 1;
    private $bar        = 2;
    private static $baz = 3;

    public function aPublicMethod()
    {
        // nada
    }

    public function testMirror()
    {
        $refl = Mirror::get('sort');
        $this->assertInstanceOf('ReflectionFunction', $refl);

        $refl = Mirror::get('Psy\Test\Util\MirrorTest');
        $this->assertInstanceOf('ReflectionClass', $refl);

        $refl = Mirror::get($this);
        $this->assertInstanceOf('ReflectionObject', $refl);

        $refl = Mirror::get($this, 'FOO');
        if (\version_compare(PHP_VERSION, '7.1.0', '>=')) {
            $this->assertInstanceOf('ReflectionClassConstant', $refl);
        } else {
            $this->assertInstanceOf('Psy\Reflection\ReflectionClassConstant', $refl);
        }

        $refl = Mirror::get('PHP_VERSION');
        $this->assertInstanceOf('Psy\Reflection\ReflectionConstant_', $refl);

        $refl = Mirror::get($this, 'bar');
        $this->assertInstanceOf('ReflectionProperty', $refl);

        $refl = Mirror::get($this, 'baz');
        $this->assertInstanceOf('ReflectionProperty', $refl);

        $refl = Mirror::get($this, 'aPublicMethod');
        $this->assertInstanceOf('ReflectionMethod', $refl);

        $refl = Mirror::get($this, 'baz', Mirror::STATIC_PROPERTY);
        $this->assertInstanceOf('ReflectionProperty', $refl);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMirrorThrowsExceptions()
    {
        Mirror::get($this, 'notAMethod');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArguments
     */
    public function testMirrorThrowsInvalidArgumentExceptions($value)
    {
        Mirror::get($value);
    }

    public function invalidArguments()
    {
        return [
            ['not_a_function_or_class'],
            [[]],
            [1],
        ];
    }
}
