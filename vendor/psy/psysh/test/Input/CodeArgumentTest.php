<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Input;

use Psy\Input\CodeArgument;
use Symfony\Component\Console\Input\InputArgument;

class CodeArgumentTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getInvalidModes
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidModes($mode)
    {
        new CodeArgument('wat', $mode);
    }

    public function getInvalidModes()
    {
        return [
            [InputArgument::IS_ARRAY],
            [InputArgument::IS_ARRAY | InputArgument::REQUIRED],
            [InputArgument::IS_ARRAY | InputArgument::OPTIONAL],
        ];
    }

    /**
     * @dataProvider getValidModes
     */
    public function testValidModes($mode)
    {
        $this->assertInstanceOf('Psy\Input\CodeArgument', new CodeArgument('yeah', $mode));
    }

    public function getValidModes()
    {
        return [
            [InputArgument::REQUIRED],
            [InputArgument::OPTIONAL],
        ];
    }
}
