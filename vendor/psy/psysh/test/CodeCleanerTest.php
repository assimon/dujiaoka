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

use Psy\CodeCleaner;

class CodeCleanerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider semicolonCodeProvider
     */
    public function testAutomaticSemicolons(array $lines, $requireSemicolons, $expected)
    {
        $cc = new CodeCleaner();
        $this->assertSame($expected, $cc->clean($lines, $requireSemicolons));
    }

    public function semicolonCodeProvider()
    {
        return [
            [['true'],  false, 'return true;'],
            [['true;'], false, 'return true;'],
            [['true;'], true,  'return true;'],
            [['true'],  true,  false],

            [['echo "foo";', 'true'], true,  false],

            [['echo "foo";', 'true'], false, "echo \"foo\";\nreturn true;"],
        ];
    }

    /**
     * @dataProvider unclosedStatementsProvider
     */
    public function testUnclosedStatements(array $lines, $isUnclosed)
    {
        $cc  = new CodeCleaner();
        $res = $cc->clean($lines);

        if ($isUnclosed) {
            $this->assertFalse($res);
        } else {
            $this->assertNotFalse($res);
        }
    }

    public function unclosedStatementsProvider()
    {
        return [
            [['echo "'],   true],
            [['echo \''],  true],
            [['if (1) {'], true],

            [['echo "foo",'], true],

            [['echo ""'],   false],
            [["echo ''"],   false],
            [['if (1) {}'], false],

            [['// closed comment'],    false],
            [['function foo() { /**'], true],

            [['var_dump(1, 2,'], true],
            [['var_dump(1, 2,', '3)'], false],
        ];
    }

    /**
     * @dataProvider moreUnclosedStatementsProvider
     */
    public function testMoreUnclosedStatements(array $lines)
    {
        if (\defined('HHVM_VERSION')) {
            $this->markTestSkipped('HHVM not supported.');
        }

        $cc  = new CodeCleaner();
        $res = $cc->clean($lines);

        $this->assertFalse($res);
    }

    public function moreUnclosedStatementsProvider()
    {
        return [
            [["\$content = <<<EOS\n"]],
            [["\$content = <<<'EOS'\n"]],

            [['/* unclosed comment']],
            [['/** unclosed comment']],
        ];
    }

    /**
     * @dataProvider invalidStatementsProvider
     * @expectedException \Psy\Exception\ParseErrorException
     */
    public function testInvalidStatementsThrowParseErrors($code)
    {
        $cc = new CodeCleaner();
        $cc->clean([$code]);
    }

    public function invalidStatementsProvider()
    {
        // n.b. We used to check that `var_dump(1,2,)` failed, but PHP Parser
        // 4.x backported trailing comma function calls from PHP 7.3 for free!
        // so we're not going to spend too much time worrying about it :)

        return [
            ['function "what'],
            ["function 'what"],
            ['echo }'],
            ['echo {'],
            ['if (1) }'],
            ['echo """'],
            ["echo '''"],
            ['$foo "bar'],
            ['$foo \'bar'],
        ];
    }
}
