<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use Psy\Exception\BreakException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Exit the Psy Shell.
 *
 * Just what it says on the tin.
 */
class ExitCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('exit')
            ->setAliases(['quit', 'q'])
            ->setDefinition([])
            ->setDescription('End the current session and return to caller.')
            ->setHelp(
                <<<'HELP'
End the current session and return to caller.

e.g.
<return>>>> exit</return>
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        throw new BreakException('Goodbye');
    }
}
