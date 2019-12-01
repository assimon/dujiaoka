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

use Psy\Command\ThrowUpCommand;
use Psy\Shell;
use Symfony\Component\Console\Tester\CommandTester;

class ThrowUpCommandTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider executeThis
     */
    public function testExecute($args, $hasCode, $expect, $addSilent = true)
    {
        $shell = $this->getMockBuilder('Psy\\Shell')
            ->setMethods(['hasCode', 'addCode'])
            ->getMock();

        $shell->expects($this->once())->method('hasCode')->willReturn($hasCode);
        $shell->expects($this->once())
            ->method('addCode')
            ->with($this->equalTo($expect), $this->equalTo($addSilent));

        $command = new ThrowUpCommand();
        $command->setApplication($shell);
        $tester = new CommandTester($command);
        $tester->execute($args);
        $this->assertEquals('', $tester->getDisplay());
    }

    public function executeThis()
    {
        $throw = 'throw \Psy\Exception\ThrowUpException::fromThrowable';

        return [
            [[], false, $throw . '($_e);'],

            [['exception' => '$ex'], false, $throw . '($ex);'],
            [['exception' => 'getException()'], false, $throw . '(getException());'],
            [['exception' => 'new \\Exception("WAT")'], false, $throw . '(new \\Exception("WAT"));'],

            [['exception' => '\'some string\''], false, $throw . '(new \\Exception(\'some string\'));'],
            [['exception' => '"WHEEEEEEE!"'], false, $throw . '(new \\Exception("WHEEEEEEE!"));'],

            // Everything should work with or without semicolons.
            [['exception' => '$ex;'], false, $throw . '($ex);'],
            [['exception' => '"WHEEEEEEE!";'], false, $throw . '(new \\Exception("WHEEEEEEE!"));'],

            // Don't add as silent code if we've already got code.
            [[], true, $throw . '($_e);', false],
            [['exception' => 'getException()'], true, $throw . '(getException());', false],
            [['exception' => '\'some string\''], true, $throw . '(new \\Exception(\'some string\'));', false],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No idea how to throw this
     */
    public function testMultipleArgsThrowsException()
    {
        $command = new ThrowUpCommand();
        $command->setApplication(new Shell());
        $tester = new CommandTester($command);
        $tester->execute(['exception' => 'foo(); bar()']);
    }

    /**
     * @expectedException \PhpParser\Error
     * @expectedExceptionMessage Syntax error, unexpected ')' on line 1
     */
    public function testParseErrorThrowsException()
    {
        $command = new ThrowUpCommand();
        $command->setApplication(new Shell());
        $tester = new CommandTester($command);
        $tester->execute(['exception' => 'foo)']);
    }
}
