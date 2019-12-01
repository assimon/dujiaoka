<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test;

use Psy\Context;

class ContextTest extends \PHPUnit\Framework\TestCase
{
    public function testGet()
    {
        $this->assertTrue(true);
    }

    public function testGetAll()
    {
        $this->assertTrue(true);
    }

    public function testGetSpecialVariables()
    {
        $context = new Context();

        $this->assertNull($context->get('_'));
        $this->assertNull($context->getReturnValue());

        $this->assertEquals(['_' => null], $context->getAll());

        $e = new \Exception('eeeeeee');
        $obj = new \StdClass();
        $context->setLastException($e);
        $context->setLastStdout('out');
        $context->setBoundObject($obj);

        $context->setCommandScopeVariables([
            '__function'  => 'function',
            '__method'    => 'method',
            '__class'     => 'class',
            '__namespace' => 'namespace',
            '__file'      => 'file',
            '__line'      => 'line',
            '__dir'       => 'dir',
        ]);

        $expected = [
            '_'           => null,
            '_e'          => $e,
            '__out'       => 'out',
            'this'        => $obj,
            '__function'  => 'function',
            '__method'    => 'method',
            '__class'     => 'class',
            '__namespace' => 'namespace',
            '__file'      => 'file',
            '__line'      => 'line',
            '__dir'       => 'dir',
        ];

        $this->assertEquals($expected, $context->getAll());
    }

    public function testSetAll()
    {
        $context = new Context();

        $baz = new \StdClass();
        $vars = [
            'foo' => 'Foo',
            'bar' => 123,
            'baz' => $baz,

            '_'         => 'fail',
            '_e'        => 'fail',
            '__out'     => 'fail',
            'this'      => 'fail',
            '__psysh__' => 'fail',

            '__function'  => 'fail',
            '__method'    => 'fail',
            '__class'     => 'fail',
            '__namespace' => 'fail',
            '__file'      => 'fail',
            '__line'      => 'fail',
            '__dir'       => 'fail',
        ];

        $context->setAll($vars);

        $this->assertEquals('Foo', $context->get('foo'));
        $this->assertEquals(123, $context->get('bar'));
        $this->assertSame($baz, $context->get('baz'));

        $this->assertEquals(['foo' => 'Foo', 'bar' => 123, 'baz' => $baz, '_' => null], $context->getAll());
    }

    /**
     * @dataProvider specialNames
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegEx /Unknown variable: \$\w+/
     */
    public function testSetAllDoesNotSetSpecial($name)
    {
        $context = new Context();
        $context->setAll([$name => 'fail']);
        $context->get($name);
    }

    public function specialNames()
    {
        return [
            ['_e'],
            ['__out'],
            ['this'],
            ['__psysh__'],
            ['__function'],
            ['__method'],
            ['__class'],
            ['__namespace'],
            ['__file'],
            ['__line'],
            ['__dir'],
        ];
    }

    public function testReturnValue()
    {
        $context = new Context();
        $this->assertNull($context->getReturnValue());

        $val = 'some string';
        $context->setReturnValue($val);
        $this->assertEquals($val, $context->getReturnValue());
        $this->assertEquals($val, $context->get('_'));

        $obj = new \StdClass();
        $context->setReturnValue($obj);
        $this->assertSame($obj, $context->getReturnValue());
        $this->assertSame($obj, $context->get('_'));

        $context->setReturnValue(null);
        $this->assertNull($context->getReturnValue());
    }

    public function testLastException()
    {
        $context = new Context();
        $e = new \Exception('wat');
        $context->setLastException($e);
        $this->assertSame($e, $context->getLastException());
        $this->assertSame($e, $context->get('_e'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No most-recent exception
     */
    public function testLastExceptionThrowsSometimes()
    {
        $context = new Context();
        $context->getLastException();
    }

    public function testLastStdout()
    {
        $context = new Context();
        $context->setLastStdout('ouuuuut');
        $this->assertEquals('ouuuuut', $context->getLastStdout());
        $this->assertEquals('ouuuuut', $context->get('__out'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No most-recent output
     */
    public function testLastStdoutThrowsSometimes()
    {
        $context = new Context();
        $context->getLastStdout();
    }

    public function testBoundObject()
    {
        $context = new Context();
        $this->assertNull($context->getBoundObject());

        $obj = new \StdClass();
        $context->setBoundObject($obj);
        $this->assertSame($obj, $context->getBoundObject());
        $this->assertSame($obj, $context->get('this'));

        $context->setBoundObject(null);
        $this->assertNull($context->getBoundObject());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown variable: $this
     */
    public function testBoundObjectThrowsSometimes()
    {
        $context = new Context();
        $context->get('this');
    }

    public function testBoundClass()
    {
        $context = new Context();
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('');
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('Psy\Shell');
        $this->assertEquals('Psy\Shell', $context->getBoundClass());

        $context->setBoundObject(new \StdClass());
        $this->assertNotNull($context->getBoundObject());
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('Psy\Shell');
        $this->assertEquals('Psy\Shell', $context->getBoundClass());
        $this->assertNull($context->getBoundObject());

        $context->setBoundClass(null);
        $this->assertNull($context->getBoundClass());
        $this->assertNull($context->getBoundObject());
    }

    public function testCommandScopeVariables()
    {
        $__function  = 'donkey';
        $__method    = 'diddy';
        $__class     = 'cranky';
        $__namespace = 'funky';
        $__file      = 'candy';
        $__line      = 'dixie';
        $__dir       = 'wrinkly';

        $vars = \compact('__function', '__method', '__class', '__namespace', '__file', '__line', '__dir');

        $context = new Context();
        $context->setCommandScopeVariables($vars);

        $this->assertEquals($vars, $context->getCommandScopeVariables());

        $this->assertEquals($__function, $context->get('__function'));
        $this->assertEquals($__method, $context->get('__method'));
        $this->assertEquals($__class, $context->get('__class'));
        $this->assertEquals($__namespace, $context->get('__namespace'));
        $this->assertEquals($__file, $context->get('__file'));
        $this->assertEquals($__line, $context->get('__line'));
        $this->assertEquals($__dir, $context->get('__dir'));

        $someVars = \compact('__function', '__namespace', '__file', '__line', '__dir');
        $context->setCommandScopeVariables($someVars);
    }

    public function testGetUnusedCommandScopeVariableNames()
    {
        $context = new Context();

        $this->assertEquals(
            ['__function', '__method', '__class', '__namespace', '__file', '__line', '__dir'],
            $context->getUnusedCommandScopeVariableNames()
        );

        $context->setCommandScopeVariables([
            '__function'  => 'foo',
            '__namespace' => 'bar',
            '__file'      => 'baz',
            '__line'      => 123,
            '__dir'       => 'qux',
        ]);

        $this->assertEquals(
            ['__method', '__class'],
            \array_values($context->getUnusedCommandScopeVariableNames())
        );
    }

    /**
     * @dataProvider specialAndNotSpecialVariableNames
     */
    public function testIsSpecialVariableName($name, $isSpecial)
    {
        $context = new Context();

        if ($isSpecial) {
            $this->assertTrue($context->isSpecialVariableName($name));
        } else {
            $this->assertFalse($context->isSpecialVariableName($name));
        }
    }

    public function specialAndNotSpecialVariableNames()
    {
        return [
            ['foo', false],
            ['psysh', false],
            ['__psysh', false],

            ['_', true],
            ['_e', true],
            ['__out', true],
            ['this', true],
            ['__psysh__', true],

            ['__function', true],
            ['__method', true],
            ['__class', true],
            ['__namespace', true],
            ['__file', true],
            ['__line', true],
            ['__dir', true],
        ];
    }
}
