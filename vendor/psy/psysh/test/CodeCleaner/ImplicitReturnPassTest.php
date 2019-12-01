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

use Psy\CodeCleaner\ImplicitReturnPass;

class ImplicitReturnPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new ImplicitReturnPass());
    }

    /**
     * @dataProvider implicitReturns
     */
    public function testProcess($from, $to)
    {
        $this->assertProcessesAs($from, $to);
    }

    public function implicitReturns()
    {
        $data = [
            ['4',        'return 4;'],
            ['foo()',    'return foo();'],
            ['return 1', 'return 1;'],
            ['',         'return new \Psy\CodeCleaner\NoReturnValue();'],
        ];

        $from = 'echo "foo";';
        $to   = <<<'EOS'
echo "foo";
return new \Psy\CodeCleaner\NoReturnValue();
EOS;
        $data[] = [$from, $to];

        $from = 'if (true) { 1; } elseif (true) { 2; } else { 3; }';
        $to   = <<<'EOS'
if (true) {
    return 1;
} elseif (true) {
    return 2;
} else {
    return 3;
}
return new \Psy\CodeCleaner\NoReturnValue();
EOS;
        $data[] = [$from, $to];

        $from = 'class A {}';
        $to   = <<<'EOS'
class A
{
}
return new \Psy\CodeCleaner\NoReturnValue();
EOS;
        $data[] = [$from, $to];

        $from = <<<'EOS'
switch (false) {
    case 0:
        0;
    case 1:
        1;
        break;
    case 2:
        2;
        return;
}
EOS;
        $to = <<<'EOS'
switch (false) {
    case 0:
        0;
    case 1:
        return 1;
        break;
    case 2:
        2;
        return;
}
return new \Psy\CodeCleaner\NoReturnValue();
EOS;
        $data[] = [$from, $to];

        $from = <<<'EOS'
namespace Foo {
    1 + 1;
}
EOS;
        $to = <<<'EOS'
namespace Foo;

return 1 + 1;
EOS;
        $data[] = [$from, $to];

        $data[] = ['exit()', 'exit;'];

        return $data;
    }
}
