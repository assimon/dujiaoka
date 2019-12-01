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

use Psy\CodeCleaner\InstanceOfPass;

class InstanceOfPassTest extends CodeCleanerTestCase
{
    protected function setUp()
    {
        $this->setPass(new InstanceOfPass());
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\FatalErrorException
     */
    public function testProcessInvalidStatement($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidStatements()
    {
        return [
            ['null instanceof stdClass'],
            ['true instanceof stdClass'],
            ['9 instanceof stdClass'],
            ['1.0 instanceof stdClass'],
            ['"foo" instanceof stdClass'],
            ['__DIR__ instanceof stdClass'],
            ['PHP_SAPI instanceof stdClass'],
            ['1+1 instanceof stdClass'],
            ['true && false instanceof stdClass'],
            ['"a"."b" instanceof stdClass'],
            ['!5 instanceof stdClass'],
        ];
    }

    /**
     * @dataProvider validStatements
     */
    public function testProcessValidStatement($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function validStatements()
    {
        $data = [
            ['$a instanceof stdClass'],
            ['strtolower("foo") instanceof stdClass'],
            ['array(1) instanceof stdClass'],
            ['(string) "foo" instanceof stdClass'],
            ['(1+1) instanceof stdClass'],
            ['"foo ${foo} $bar" instanceof stdClass'],
            ['DateTime::ISO8601 instanceof stdClass'],
        ];

        return $data;
    }
}
