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

use JakubOnderka\PhpConsoleHighlighter\Highlighter;
use Psy\Configuration;
use Psy\ConsoleColorFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Show the context of where you opened the debugger.
 */
class WhereamiCommand extends Command
{
    private $colorMode;
    private $backtrace;

    /**
     * @param null|string $colorMode (default: null)
     */
    public function __construct($colorMode = null)
    {
        $this->colorMode = $colorMode ?: Configuration::COLOR_MODE_AUTO;
        $this->backtrace = \debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('whereami')
            ->setDefinition([
                new InputOption('num', 'n', InputOption::VALUE_OPTIONAL, 'Number of lines before and after.', '5'),
            ])
            ->setDescription('Show where you are in the code.')
            ->setHelp(
                <<<'HELP'
Show where you are in the code.

Optionally, include how many lines before and after you want to display.

e.g.
<return>> whereami </return>
<return>> whereami -n10</return>
HELP
            );
    }

    /**
     * Obtains the correct stack frame in the full backtrace.
     *
     * @return array
     */
    protected function trace()
    {
        foreach (\array_reverse($this->backtrace) as $stackFrame) {
            if ($this->isDebugCall($stackFrame)) {
                return $stackFrame;
            }
        }

        return \end($this->backtrace);
    }

    private static function isDebugCall(array $stackFrame)
    {
        $class    = isset($stackFrame['class']) ? $stackFrame['class'] : null;
        $function = isset($stackFrame['function']) ? $stackFrame['function'] : null;

        return ($class === null && $function === 'Psy\debug') ||
            ($class === 'Psy\Shell' && \in_array($function, ['__construct', 'debug']));
    }

    /**
     * Determine the file and line based on the specific backtrace.
     *
     * @return array
     */
    protected function fileInfo()
    {
        $stackFrame = $this->trace();
        if (\preg_match('/eval\(/', $stackFrame['file'])) {
            \preg_match_all('/([^\(]+)\((\d+)/', $stackFrame['file'], $matches);
            $file = $matches[1][0];
            $line = (int) $matches[2][0];
        } else {
            $file = $stackFrame['file'];
            $line = $stackFrame['line'];
        }

        return \compact('file', 'line');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $info        = $this->fileInfo();
        $num         = $input->getOption('num');
        $factory     = new ConsoleColorFactory($this->colorMode);
        $colors      = $factory->getConsoleColor();
        $highlighter = new Highlighter($colors);
        $contents    = \file_get_contents($info['file']);

        $output->startPaging();
        $output->writeln('');
        $output->writeln(\sprintf('From <info>%s:%s</info>:', $this->replaceCwd($info['file']), $info['line']));
        $output->writeln('');
        $output->write($highlighter->getCodeSnippet($contents, $info['line'], $num, $num), false, OutputInterface::OUTPUT_RAW);
        $output->stopPaging();

        return 0;
    }

    /**
     * Replace the given directory from the start of a filepath.
     *
     * @param string $file
     *
     * @return string
     */
    private function replaceCwd($file)
    {
        $cwd = \getcwd();
        if ($cwd === false) {
            return $file;
        }

        $cwd = \rtrim($cwd, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return \preg_replace('/^' . \preg_quote($cwd, '/') . '/', '', $file);
    }
}
