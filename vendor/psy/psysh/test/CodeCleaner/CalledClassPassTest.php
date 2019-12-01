<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use Psy\CodeCleaner\CalledClassPass;

class CalledClassPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new CalledClassPass());
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\ErrorException
     */
    public function testProcessStatementFails($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidStatements()
    {
        return [
            ['get_class()'],
            ['get_class(null)'],
            ['get_called_class()'],
            ['get_called_class(null)'],
            ['function foo() { return get_class(); }'],
            ['function foo() { return get_class(null); }'],
            ['function foo() { return get_called_class(); }'],
            ['function foo() { return get_called_class(null); }'],
        ];
    }

    /**
     * @dataProvider validStatements
     */
    public function testProcessStatementPasses($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function validStatements()
    {
        return [
            ['get_class($foo)'],
            ['get_class(bar())'],
            ['get_called_class($foo)'],
            ['get_called_class(bar())'],
            ['function foo($bar) { return get_class($bar); }'],
            ['function foo($bar) { return get_called_class($bar); }'],
            ['class Foo { function bar() { return get_class(); } }'],
            ['class Foo { function bar() { return get_class(null); } }'],
            ['class Foo { function bar() { return get_called_class(); } }'],
            ['class Foo { function bar() { return get_called_class(null); } }'],
            ['$foo = function () {}; $foo()'],
        ];
    }

    /**
     * @dataProvider validTraitStatements
     */
    public function testProcessTraitStatementPasses($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function validTraitStatements()
    {
        return [
            ['trait Foo { function bar() { return get_class(); } }'],
            ['trait Foo { function bar() { return get_class(null); } }'],
            ['trait Foo { function bar() { return get_called_class(); } }'],
            ['trait Foo { function bar() { return get_called_class(null); } }'],
        ];
    }
}
