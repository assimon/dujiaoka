<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Formatter;

use Psy\Formatter\DocblockFormatter;

class DocblockFormatterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * This is a docblock!
     *
     * @author Justin Hileman <justin@justinhileman.info>
     *
     * @throws InvalidArgumentException if $foo is empty
     *
     * @param mixed $foo It's a foo thing
     * @param int   $bar This is definitely bar
     *
     * @return string A string of no consequence
     */
    private function methodWithDocblock($foo, $bar = 1)
    {
        if (empty($foo)) {
            throw new \InvalidArgumentException();
        }

        return 'method called';
    }

    public function testFormat()
    {
        $expected = <<<EOS
<comment>Description:</comment>
  This is a docblock!

<comment>Throws:</comment>
  <info>InvalidArgumentException </info> if \$foo is empty

<comment>Param:</comment>
  <info>mixed </info> <strong>\$foo </strong> It's a foo thing
  <info>int   </info> <strong>\$bar </strong> This is definitely bar

<comment>Return:</comment>
  <info>string </info> A string of no consequence

<comment>Author:</comment> Justin Hileman \<justin@justinhileman.info>
EOS;

        $this->assertSame(
            $expected,
            DocblockFormatter::format(new \ReflectionMethod($this, 'methodWithDocblock'))
        );
    }
}
