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

use Psy\Reflection\ReflectionConstant;

class ReflectionConstantBCTest extends \PHPUnit\Framework\TestCase
{
    const CONSTANT_ONE = 'one';

    public function testConstruction()
    {
        $refl = new ReflectionConstant($this, 'CONSTANT_ONE');
        $this->assertInstanceOf('Psy\Reflection\ReflectionConstant', $refl);
        $this->assertInstanceOf('Psy\Reflection\ReflectionClassConstant', $refl);
    }
}
