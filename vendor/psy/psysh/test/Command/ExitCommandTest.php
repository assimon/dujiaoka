<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Command;

use Psy\Command\ExitCommand;
use Symfony\Component\Console\Tester\CommandTester;

class ExitCommandTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \Psy\Exception\BreakException
     * @expectedExceptionMessage Goodbye
     */
    public function testExecute()
    {
        $command = new ExitCommand();
        $tester = new CommandTester($command);
        $tester->execute([]);
    }
}
