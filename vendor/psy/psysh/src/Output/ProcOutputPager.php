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

use Symfony\Component\Console\Output\StreamOutput;

/**
 * ProcOutputPager class.
 *
 * A ProcOutputPager instance wraps a regular StreamOutput's stream. Rather
 * than writing directly to the stream, it shells out to a pager process and
 * gives that process the stream as stdout. This means regular *nix commands
 * like `less` and `more` can be used to page large amounts of output.
 */
class ProcOutputPager extends StreamOutput implements OutputPager
{
    private $proc;
    private $pipe;
    private $stream;
    private $cmd;

    /**
     * Constructor.
     *
     * @param StreamOutput $output
     * @param string       $cmd    Pager process command (default: 'less -R -S -F -X')
     */
    public function __construct(StreamOutput $output, $cmd = 'less -R -S -F -X')
    {
        $this->stream = $output->getStream();
        $this->cmd    = $cmd;
    }

    /**
     * Writes a message to the output.
     *
     * @param string $message A message to write to the output
     * @param bool   $newline Whether to add a newline or not
     *
     * @throws \RuntimeException When unable to write output (should never happen)
     */
    public function doWrite($message, $newline)
    {
        $pipe = $this->getPipe();
        if (false === @\fwrite($pipe, $message . ($newline ? PHP_EOL : ''))) {
            // @codeCoverageIgnoreStart
            // should never happen
            throw new \RuntimeException('Unable to write output');
            // @codeCoverageIgnoreEnd
        }

        \fflush($pipe);
    }

    /**
     * Close the current pager process.
     */
    public function close()
    {
        if (isset($this->pipe)) {
            \fclose($this->pipe);
        }

        if (isset($this->proc)) {
            $exit = \proc_close($this->proc);
            if ($exit !== 0) {
                throw new \RuntimeException('Error closing output stream');
            }
        }

        unset($this->pipe, $this->proc);
    }

    /**
     * Get a pipe for paging output.
     *
     * If no active pager process exists, fork one and return its input pipe.
     */
    private function getPipe()
    {
        if (!isset($this->pipe) || !isset($this->proc)) {
            $desc = [['pipe', 'r'], $this->stream, \fopen('php://stderr', 'w')];
            $this->proc = \proc_open($this->cmd, $desc, $pipes);

            if (!\is_resource($this->proc)) {
                throw new \RuntimeException('Error opening output stream');
            }

            $this->pipe = $pipes[0];
        }

        return $this->pipe;
    }
}
