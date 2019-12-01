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
use Psy\Exception\RuntimeException;
use Psy\Formatter\CodeFormatter;
use Psy\Formatter\SignatureFormatter;
use Psy\Input\CodeArgument;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Show the code for an object, class, constant, method or property.
 */
class ShowCommand extends ReflectingCommand
{
    private $colorMode;
    private $highlighter;
    private $lastException;
    private $lastExceptionIndex;

    /**
     * @param null|string $colorMode (default: null)
     */
    public function __construct($colorMode = null)
    {
        $this->colorMode = $colorMode ?: Configuration::COLOR_MODE_AUTO;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('show')
            ->setDefinition([
                new CodeArgument('target', CodeArgument::OPTIONAL, 'Function, class, instance, constant, method or property to show.'),
                new InputOption('ex', null,  InputOption::VALUE_OPTIONAL, 'Show last exception context. Optionally specify a stack index.', 1),
            ])
            ->setDescription('Show the code for an object, class, constant, method or property.')
            ->setHelp(
                <<<HELP
Show the code for an object, class, constant, method or property, or the context
of the last exception.

<return>cat --ex</return> defaults to showing the lines surrounding the location of the last
exception. Invoking it more than once travels up the exception's stack trace,
and providing a number shows the context of the given index of the trace.

e.g.
<return>>>> show \$myObject</return>
<return>>>> show Psy\Shell::debug</return>
<return>>>> show --ex</return>
<return>>>> show --ex 3</return>
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // n.b. As far as I can tell, InputInterface doesn't want to tell me
        // whether an option with an optional value was actually passed. If you
        // call `$input->getOption('ex')`, it will return the default, both when
        // `--ex` is specified with no value, and when `--ex` isn't specified at
        // all.
        //
        // So we're doing something sneaky here. If we call `getOptions`, it'll
        // return the default value when `--ex` is not present, and `null` if
        // `--ex` is passed with no value. /shrug
        $opts = $input->getOptions();

        // Strict comparison to `1` (the default value) here, because `--ex 1`
        // will come in as `"1"`. Now we can tell the difference between
        // "no --ex present", because it's the integer 1, "--ex with no value",
        // because it's `null`, and "--ex 1", because it's the string "1".
        if ($opts['ex'] !== 1) {
            if ($input->getArgument('target')) {
                throw new \InvalidArgumentException('Too many arguments (supply either "target" or "--ex")');
            }

            $this->writeExceptionContext($input, $output);

            return 0;
        }

        if ($input->getArgument('target')) {
            $this->writeCodeContext($input, $output);

            return 0;
        }

        throw new RuntimeException('Not enough arguments (missing: "target")');
    }

    private function writeCodeContext(InputInterface $input, OutputInterface $output)
    {
        list($target, $reflector) = $this->getTargetAndReflector($input->getArgument('target'));

        // Set some magic local variables
        $this->setCommandScopeVariables($reflector);

        try {
            $output->page(CodeFormatter::format($reflector, $this->colorMode), OutputInterface::OUTPUT_RAW);
        } catch (RuntimeException $e) {
            $output->writeln(SignatureFormatter::format($reflector));
            throw $e;
        }
    }

    private function writeExceptionContext(InputInterface $input, OutputInterface $output)
    {
        $exception = $this->context->getLastException();
        if ($exception !== $this->lastException) {
            $this->lastException = null;
            $this->lastExceptionIndex = null;
        }

        $opts = $input->getOptions();
        if ($opts['ex'] === null) {
            if ($this->lastException && $this->lastExceptionIndex !== null) {
                $index = $this->lastExceptionIndex + 1;
            } else {
                $index = 0;
            }
        } else {
            $index = \max(0, \intval($input->getOption('ex')) - 1);
        }

        $trace = $exception->getTrace();
        \array_unshift($trace, [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        if ($index >= \count($trace)) {
            $index = 0;
        }

        $this->lastException = $exception;
        $this->lastExceptionIndex = $index;

        $output->writeln($this->getApplication()->formatException($exception));
        $output->writeln('--');
        $this->writeTraceLine($output, $trace, $index);
        $this->writeTraceCodeSnippet($output, $trace, $index);

        $this->setCommandScopeVariablesFromContext($trace[$index]);
    }

    private function writeTraceLine(OutputInterface $output, array $trace, $index)
    {
        $file = isset($trace[$index]['file']) ? $this->replaceCwd($trace[$index]['file']) : 'n/a';
        $line = isset($trace[$index]['line']) ? $trace[$index]['line'] : 'n/a';

        $output->writeln(\sprintf(
            'From <info>%s:%d</info> at <strong>level %d</strong> of backtrace (of %d).',
            OutputFormatter::escape($file),
            OutputFormatter::escape($line),
            $index + 1,
            \count($trace)
        ));
    }

    private function replaceCwd($file)
    {
        if ($cwd = \getcwd()) {
            $cwd = \rtrim($cwd, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        if ($cwd === false) {
            return $file;
        } else {
            return \preg_replace('/^' . \preg_quote($cwd, '/') . '/', '', $file);
        }
    }

    private function writeTraceCodeSnippet(OutputInterface $output, array $trace, $index)
    {
        if (!isset($trace[$index]['file'])) {
            return;
        }

        $file = $trace[$index]['file'];
        if ($fileAndLine = $this->extractEvalFileAndLine($file)) {
            list($file, $line) = $fileAndLine;
        } else {
            if (!isset($trace[$index]['line'])) {
                return;
            }

            $line = $trace[$index]['line'];
        }

        if (\is_file($file)) {
            $code = @\file_get_contents($file);
        }

        if (empty($code)) {
            return;
        }

        $output->write($this->getHighlighter()->getCodeSnippet($code, $line, 5, 5), false, OutputInterface::OUTPUT_RAW);
    }

    private function getHighlighter()
    {
        if (!$this->highlighter) {
            $factory = new ConsoleColorFactory($this->colorMode);
            $this->highlighter = new Highlighter($factory->getConsoleColor());
        }

        return $this->highlighter;
    }

    private function setCommandScopeVariablesFromContext(array $context)
    {
        $vars = [];

        if (isset($context['class'])) {
            $vars['__class'] = $context['class'];
            if (isset($context['function'])) {
                $vars['__method'] = $context['function'];
            }

            try {
                $refl = new \ReflectionClass($context['class']);
                if ($namespace = $refl->getNamespaceName()) {
                    $vars['__namespace'] = $namespace;
                }
            } catch (\Exception $e) {
                // oh well
            }
        } elseif (isset($context['function'])) {
            $vars['__function'] = $context['function'];

            try {
                $refl = new \ReflectionFunction($context['function']);
                if ($namespace = $refl->getNamespaceName()) {
                    $vars['__namespace'] = $namespace;
                }
            } catch (\Exception $e) {
                // oh well
            }
        }

        if (isset($context['file'])) {
            $file = $context['file'];
            if ($fileAndLine = $this->extractEvalFileAndLine($file)) {
                list($file, $line) = $fileAndLine;
            } elseif (isset($context['line'])) {
                $line = $context['line'];
            }

            if (\is_file($file)) {
                $vars['__file'] = $file;
                if (isset($line)) {
                    $vars['__line'] = $line;
                }
                $vars['__dir'] = \dirname($file);
            }
        }

        $this->context->setCommandScopeVariables($vars);
    }

    private function extractEvalFileAndLine($file)
    {
        if (\preg_match('/(.*)\\((\\d+)\\) : eval\\(\\)\'d code$/', $file, $matches)) {
            return [$matches[1], $matches[2]];
        }
    }
}
