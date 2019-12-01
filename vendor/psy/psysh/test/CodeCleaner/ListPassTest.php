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

use Psy\CodeCleaner\ListPass;

class ListPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new ListPass());
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\ParseErrorException
     */
    public function testProcessInvalidStatement($code, $expectedMessage)
    {
        if (\method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('Psy\Exception\ParseErrorException', $expectedMessage);
        } else {
            $this->expectExceptionMessage($expectedMessage);
        }

        $stmts = $this->parse($code);
        $this->traverser->traverse($stmts);
    }

    public function invalidStatements()
    {
        // Not typo.  It is ambiguous whether "Syntax" or "syntax".
        $errorShortListAssign = "yntax error, unexpected '='";
        $errorEmptyList = 'Cannot use empty list';
        $errorAssocListAssign = 'Syntax error, unexpected T_CONSTANT_ENCAPSED_STRING, expecting \',\' or \')\'';
        $errorNonVariableAssign = 'Assignments can only happen to writable values';
        $errorPhpParserSyntax = 'PHP Parse error: Syntax error, unexpected';

        $invalidExpr = [
            ['list() = array()', $errorEmptyList],
            ['list("a") = array(1)', $errorPhpParserSyntax],
        ];

        if (\version_compare(PHP_VERSION, '7.1', '<')) {
            return \array_merge($invalidExpr, [
                ['list("a" => _) = array("a" => 1)', $errorPhpParserSyntax],
                ['[] = []', $errorShortListAssign],
                ['[$a] = [1]', $errorShortListAssign],
                ['list("a" => $a) = array("a" => 1)', $errorAssocListAssign],
                ['[$a[0], $a[1]] = [1, 2]', $errorShortListAssign],
                ['[$a->b, $a->c] = [1, 2]', $errorShortListAssign],
            ]);
        }

        return \array_merge($invalidExpr, [
            ['list("a" => _) = array("a" => 1)', $errorPhpParserSyntax],
            ['["a"] = [1]', $errorNonVariableAssign],
            ['[] = []', $errorEmptyList],
            ['[,] = [1,2]', $errorEmptyList],
            ['[,,] = [1,2,3]', $errorEmptyList],
        ]);
    }

    /**
     * @dataProvider validStatements
     */
    public function testProcessValidStatement($code)
    {
        $stmts = $this->parse($code);
        $this->traverser->traverse($stmts);
        $this->assertTrue(true);
    }

    public function validStatements()
    {
        $validExpr = [
            ['list($a) = array(1)'],
            ['list($x, $y) = array(1, 2)'],
        ];

        if (\version_compare(PHP_VERSION, '7.1', '>=')) {
            return \array_merge($validExpr, [
                ['[$a] = array(1)'],
                ['list($b) = [2]'],
                ['[$x, $y] = array(1, 2)'],
                ['[$a] = [1]'],
                ['[$x, $y] = [1, 2]'],
                ['["_" => $v] = ["_" => 1]'],
                ['[$a,] = [1,2,3]'],
                ['[,$b] = [1,2,3]'],
                ['[$a,,$c] = [1,2,3]'],
                ['[$a,,,] = [1,2,3]'],
                ['[$a[0], $a[1]] = [1, 2]'],
                ['[$a[0][0][0], $a[0][0][1]] = [1, 2]'],
                ['[$a->b, $a->c] = [1, 2]'],
                ['[$a->b[0], $a->c[1]] = [1, 2]'],
                ['[$a[0]->b[0], $a[0]->c[1]] = [1, 2]'],
                ['[$a[$b->c + $b->d]] = [1]'],
                ['[$a->c()->d, $a->c()->e] = [1, 2]'],
                ['[x()->a, x()->b] = [1, 2]'],
            ]);
        }

        return $validExpr;
    }
}
