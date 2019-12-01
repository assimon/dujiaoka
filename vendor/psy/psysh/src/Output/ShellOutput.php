<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Output;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * A ConsoleOutput subclass specifically for Psy Shell output.
 */
class ShellOutput extends ConsoleOutput
{
    const NUMBER_LINES = 128;

    private $paging = 0;
    private $pager;

    /**
     * Construct a ShellOutput instance.
     *
     * @param mixed                    $verbosity (default: self::VERBOSITY_NORMAL)
     * @param bool                     $decorated (default: null)
     * @param OutputFormatterInterface $formatter (default: null)
     * @param null|string|OutputPager  $pager     (default: null)
     */
    public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = null, OutputFormatterInterface $formatter = null, $pager = null)
    {
        parent::__construct($verbosity, $decorated, $formatter);

        $this->initFormatters();

        if ($pager === null) {
            $this->pager = new PassthruPager($this);
        } elseif (\is_string($pager)) {
            $this->pager = new ProcOutputPager($this, $pager);
        } elseif ($pager instanceof OutputPager) {
            $this->pager = $pager;
        } else {
            throw new \InvalidArgumentException('Unexpected pager parameter: ' . $pager);
        }
    }

    /**
     * Page multiple lines of output.
     *
     * The output pager is started
     *
     * If $messages is callable, it will be called, passing this output instance
     * for rendering. Otherwise, all passed $messages are paged to output.
     *
     * Upon completion, the output pager is flushed.
     *
     * @param string|array|\Closure $messages A string, array of strings or a callback
     * @param int                   $type     (default: 0)
     */
    public function page($messages, $type = 0)
    {
        if (\is_string($messages)) {
            $messages = (array) $messages;
        }

        if (!\is_array($messages) && !\is_callable($messages)) {
            throw new \InvalidArgumentException('Paged output requires a string, array or callback');
        }

        $this->startPaging();

        if (\is_callable($messages)) {
            $messages($this);
        } else {
            $this->write($messages, true, $type);
        }

        $this->stopPaging();
    }

    /**
     * Start sending output to the output pager.
     */
    public function startPaging()
    {
        $this->paging++;
    }

    /**
     * Stop paging output and flush the output pager.
     */
    public function stopPaging()
    {
        $this->paging--;
        $this->closePager();
    }

    /**
     * Writes a message to the output.
     *
     * Optionally, pass `$type | self::NUMBER_LINES` as the $type parameter to
     * number the lines of output.
     *
     * @throws \InvalidArgumentException When unknown output type is given
     *
     * @param string|array $messages The message as an array of lines or a single string
     * @param bool         $newline  Whether to add a newline or not
     * @param int          $type     The type of output
     */
    public function write($messages, $newline = false, $type = 0)
    {
        if ($this->getVerbosity() === self::VERBOSITY_QUIET) {
            return;
        }

        $messages = (array) $messages;

        if ($type & self::NUMBER_LINES) {
            $pad = \strlen((string) \count($messages));
            $template = $this->isDecorated() ? "<aside>%{$pad}s</aside>: %s" : "%{$pad}s: %s";

            if ($type & self::OUTPUT_RAW) {
                $messages = \array_map(['Symfony\Component\Console\Formatter\OutputFormatter', 'escape'], $messages);
            }

            foreach ($messages as $i => $line) {
                $messages[$i] = \sprintf($template, $i, $line);
            }

            // clean this up for super.
            $type = $type & ~self::NUMBER_LINES & ~self::OUTPUT_RAW;
        }

        parent::write($messages, $newline, $type);
    }

    /**
     * Writes a message to the output.
     *
     * Handles paged output, or writes directly to the output stream.
     *
     * @param string $message A message to write to the output
     * @param bool   $newline Whether to add a newline or not
     */
    public function doWrite($message, $newline)
    {
        if ($this->paging > 0) {
            $this->pager->doWrite($message, $newline);
        } else {
            parent::doWrite($message, $newline);
        }
    }

    /**
     * Flush and close the output pager.
     */
    private function closePager()
    {
        if ($this->paging <= 0) {
            $this->pager->close();
        }
    }

    /**
     * Initialize output formatter styles.
     */
    private function initFormatters()
    {
        $formatter = $this->getFormatter();

        $formatter->setStyle('warning', new OutputFormatterStyle('black', 'yellow'));
        $formatter->setStyle('error',   new OutputFormatterStyle('black', 'red', ['bold']));
        $formatter->setStyle('aside',   new OutputFormatterStyle('blue'));
        $formatter->setStyle('strong',  new OutputFormatterStyle(null, null, ['bold']));
        $formatter->setStyle('return',  new OutputFormatterStyle('cyan'));
        $formatter->setStyle('urgent',  new OutputFormatterStyle('red'));
        $formatter->setStyle('hidden',  new OutputFormatterStyle('black'));

        // Visibility
        $formatter->setStyle('public',    new OutputFormatterStyle(null, null, ['bold']));
        $formatter->setStyle('protected', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('private',   new OutputFormatterStyle('red'));
        $formatter->setStyle('global',    new OutputFormatterStyle('cyan', null, ['bold']));
        $formatter->setStyle('const',     new OutputFormatterStyle('cyan'));
        $formatter->setStyle('class',     new OutputFormatterStyle('blue', null, ['underscore']));
        $formatter->setStyle('function',  new OutputFormatterStyle(null));
        $formatter->setStyle('default',   new OutputFormatterStyle(null));

        // Types
        $formatter->setStyle('number',   new OutputFormatterStyle('magenta'));
        $formatter->setStyle('string',   new OutputFormatterStyle('green'));
        $formatter->setStyle('bool',     new OutputFormatterStyle('cyan'));
        $formatter->setStyle('keyword',  new OutputFormatterStyle('yellow'));
        $formatter->setStyle('comment',  new OutputFormatterStyle('blue'));
        $formatter->setStyle('object',   new OutputFormatterStyle('blue'));
        $formatter->setStyle('resource', new OutputFormatterStyle('yellow'));
    }
}
