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

use Psy\Context;
use Psy\ContextAware;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EditCommand extends Command implements ContextAware
{
    /**
     * @var string
     */
    private $runtimeDir = '';

    /**
     * @var Context
     */
    private $context;

    /**
     * Constructor.
     *
     * @param string      $runtimeDir The directory to use for temporary files
     * @param string|null $name       The name of the command; passing null means it must be set in configure()
     *
     * @throws \Symfony\Component\Console\Exception\LogicException When the command name is empty
     */
    public function __construct($runtimeDir, $name = null)
    {
        parent::__construct($name);

        $this->runtimeDir = $runtimeDir;
    }

    protected function configure()
    {
        $this
            ->setName('edit')
            ->setDefinition([
                new InputArgument('file', InputArgument::OPTIONAL, 'The file to open for editing. If this is not given, edits a temporary file.', null),
                new InputOption(
                    'exec',
                    'e',
                    InputOption::VALUE_NONE,
                    'Execute the file content after editing. This is the default when a file name argument is not given.',
                    null
                ),
                new InputOption(
                    'no-exec',
                    'E',
                    InputOption::VALUE_NONE,
                    'Do not execute the file content after editing. This is the default when a file name argument is given.',
                    null
                ),
            ])
            ->setDescription('Open an external editor. Afterwards, get produced code in input buffer.')
            ->setHelp('Set the EDITOR environment variable to something you\'d like to use.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \InvalidArgumentException when both exec and no-exec flags are given or if a given variable is not found in the current context
     * @throws \UnexpectedValueException if file_get_contents on the edited file returns false instead of a string
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('exec') &&
            $input->getOption('no-exec')) {
            throw new \InvalidArgumentException('The --exec and --no-exec flags are mutually exclusive');
        }

        $filePath = $this->extractFilePath($input->getArgument('file'));

        $execute = $this->shouldExecuteFile(
            $input->getOption('exec'),
            $input->getOption('no-exec'),
            $filePath
        );

        $shouldRemoveFile = false;

        if ($filePath === null) {
            $filePath = \tempnam($this->runtimeDir, 'psysh-edit-command');
            $shouldRemoveFile = true;
        }

        $editedContent = $this->editFile($filePath, $shouldRemoveFile);

        if ($execute) {
            $this->getApplication()->addInput($editedContent);
        }

        return 0;
    }

    /**
     * @param bool        $execOption
     * @param bool        $noExecOption
     * @param string|null $filePath
     *
     * @return bool
     */
    private function shouldExecuteFile($execOption, $noExecOption, $filePath)
    {
        if ($execOption) {
            return true;
        }

        if ($noExecOption) {
            return false;
        }

        // By default, code that is edited is executed if there was no given input file path
        return $filePath === null;
    }

    /**
     * @param string|null $fileArgument
     *
     * @return string|null The file path to edit, null if the input was null, or the value of the referenced variable
     *
     * @throws \InvalidArgumentException If the variable is not found in the current context
     */
    private function extractFilePath($fileArgument)
    {
        // If the file argument was a variable, get it from the context
        if ($fileArgument !== null &&
            \strlen($fileArgument) > 0 &&
            $fileArgument[0] === '$') {
            $fileArgument = $this->context->get(\preg_replace('/^\$/', '', $fileArgument));
        }

        return $fileArgument;
    }

    /**
     * @param string $filePath
     * @param string $shouldRemoveFile
     *
     * @return string
     *
     * @throws \UnexpectedValueException if file_get_contents on $filePath returns false instead of a string
     */
    private function editFile($filePath, $shouldRemoveFile)
    {
        $escapedFilePath = \escapeshellarg($filePath);

        $pipes = [];
        $proc = \proc_open((\getenv('EDITOR') ?: 'nano') . " {$escapedFilePath}", [STDIN, STDOUT, STDERR], $pipes);
        \proc_close($proc);

        $editedContent = @\file_get_contents($filePath);

        if ($shouldRemoveFile) {
            @\unlink($filePath);
        }

        if ($editedContent === false) {
            throw new \UnexpectedValueException("Reading {$filePath} returned false");
        }

        return $editedContent;
    }

    /**
     * Set the Context reference.
     *
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }
}
