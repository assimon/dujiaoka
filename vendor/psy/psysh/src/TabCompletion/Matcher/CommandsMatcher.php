<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\TabCompletion\Matcher;

use Psy\Command\Command;

/**
 * A Psy Command tab completion Matcher.
 *
 * This matcher provides completion for all registered Psy Command names and
 * aliases.
 *
 * @author Marc Garcia <markcial@gmail.com>
 */
class CommandsMatcher extends AbstractMatcher
{
    /** @var string[] */
    protected $commands = [];

    /**
     * CommandsMatcher constructor.
     *
     * @param Command[] $commands
     */
    public function __construct(array $commands)
    {
        $this->setCommands($commands);
    }

    /**
     * Set Commands for completion.
     *
     * @param Command[] $commands
     */
    public function setCommands(array $commands)
    {
        $names = [];
        foreach ($commands as $command) {
            $names = \array_merge([$command->getName()], $names);
            $names = \array_merge($command->getAliases(), $names);
        }
        $this->commands = $names;
    }

    /**
     * Check whether a command $name is defined.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function isCommand($name)
    {
        return \in_array($name, $this->commands);
    }

    /**
     * Check whether input matches a defined command.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function matchCommand($name)
    {
        foreach ($this->commands as $cmd) {
            if ($this->startsWith($name, $cmd)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getMatches(array $tokens, array $info = [])
    {
        $input = $this->getInput($tokens);

        return \array_filter($this->commands, function ($command) use ($input) {
            return AbstractMatcher::startsWith($input, $command);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function hasMatched(array $tokens)
    {
        /* $openTag */ \array_shift($tokens);
        $command = \array_shift($tokens);

        switch (true) {
            case self::tokenIs($command, self::T_STRING) &&
                !$this->isCommand($command[1]) &&
                $this->matchCommand($command[1]) &&
                empty($tokens):
                return true;
        }

        return false;
    }
}
