<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\ExecutionLoop;

use Psy\Context;
use Psy\Exception\BreakException;
use Psy\Shell;

/**
 * An execution loop listener that forks the process before executing code.
 *
 * This is awesome, as the session won't die prematurely if user input includes
 * a fatal error, such as redeclaring a class or function.
 */
class ProcessForker extends AbstractListener
{
    private $savegame;
    private $up;

    /**
     * Process forker is supported if pcntl and posix extensions are available.
     *
     * @return bool
     */
    public static function isSupported()
    {
        return \function_exists('pcntl_signal') && \function_exists('posix_getpid');
    }

    /**
     * Forks into a master and a loop process.
     *
     * The loop process will handle the evaluation of all instructions, then
     * return its state via a socket upon completion.
     *
     * @param Shell $shell
     */
    public function beforeRun(Shell $shell)
    {
        list($up, $down) = \stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);

        if (!$up) {
            throw new \RuntimeException('Unable to create socket pair');
        }

        $pid = \pcntl_fork();
        if ($pid < 0) {
            throw new \RuntimeException('Unable to start execution loop');
        } elseif ($pid > 0) {
            // This is the main thread. We'll just wait for a while.

            // We won't be needing this one.
            \fclose($up);

            // Wait for a return value from the loop process.
            $read   = [$down];
            $write  = null;
            $except = null;

            do {
                $n = @\stream_select($read, $write, $except, null);

                if ($n === 0) {
                    throw new \RuntimeException('Process timed out waiting for execution loop');
                }

                if ($n === false) {
                    $err = \error_get_last();
                    if (!isset($err['message']) || \stripos($err['message'], 'interrupted system call') === false) {
                        $msg = $err['message'] ?
                            \sprintf('Error waiting for execution loop: %s', $err['message']) :
                            'Error waiting for execution loop';
                        throw new \RuntimeException($msg);
                    }
                }
            } while ($n < 1);

            $content = \stream_get_contents($down);
            \fclose($down);

            if ($content) {
                $shell->setScopeVariables(@\unserialize($content));
            }

            throw new BreakException('Exiting main thread');
        }

        // This is the child process. It's going to do all the work.
        if (\function_exists('setproctitle')) {
            setproctitle('psysh (loop)');
        }

        // We won't be needing this one.
        \fclose($down);

        // Save this; we'll need to close it in `afterRun`
        $this->up = $up;
    }

    /**
     * Create a savegame at the start of each loop iteration.
     *
     * @param Shell $shell
     */
    public function beforeLoop(Shell $shell)
    {
        $this->createSavegame();
    }

    /**
     * Clean up old savegames at the end of each loop iteration.
     *
     * @param Shell $shell
     */
    public function afterLoop(Shell $shell)
    {
        // if there's an old savegame hanging around, let's kill it.
        if (isset($this->savegame)) {
            \posix_kill($this->savegame, SIGKILL);
            \pcntl_signal_dispatch();
        }
    }

    /**
     * After the REPL session ends, send the scope variables back up to the main
     * thread (if this is a child thread).
     *
     * @param Shell $shell
     */
    public function afterRun(Shell $shell)
    {
        // We're a child thread. Send the scope variables back up to the main thread.
        if (isset($this->up)) {
            \fwrite($this->up, $this->serializeReturn($shell->getScopeVariables(false)));
            \fclose($this->up);

            \posix_kill(\posix_getpid(), SIGKILL);
        }
    }

    /**
     * Create a savegame fork.
     *
     * The savegame contains the current execution state, and can be resumed in
     * the event that the worker dies unexpectedly (for example, by encountering
     * a PHP fatal error).
     */
    private function createSavegame()
    {
        // the current process will become the savegame
        $this->savegame = \posix_getpid();

        $pid = \pcntl_fork();
        if ($pid < 0) {
            throw new \RuntimeException('Unable to create savegame fork');
        } elseif ($pid > 0) {
            // we're the savegame now... let's wait and see what happens
            \pcntl_waitpid($pid, $status);

            // worker exited cleanly, let's bail
            if (!\pcntl_wexitstatus($status)) {
                \posix_kill(\posix_getpid(), SIGKILL);
            }

            // worker didn't exit cleanly, we'll need to have another go
            $this->createSavegame();
        }
    }

    /**
     * Serialize all serializable return values.
     *
     * A naïve serialization will run into issues if there is a Closure or
     * SimpleXMLElement (among other things) in scope when exiting the execution
     * loop. We'll just ignore these unserializable classes, and serialize what
     * we can.
     *
     * @param array $return
     *
     * @return string
     */
    private function serializeReturn(array $return)
    {
        $serializable = [];

        foreach ($return as $key => $value) {
            // No need to return magic variables
            if (Context::isSpecialVariableName($key)) {
                continue;
            }

            // Resources and Closures don't error, but they don't serialize well either.
            if (\is_resource($value) || $value instanceof \Closure) {
                continue;
            }

            try {
                @\serialize($value);
                $serializable[$key] = $value;
            } catch (\Throwable $e) {
                // we'll just ignore this one...
            } catch (\Exception $e) {
                // and this one too...
                // @todo remove this once we don't support PHP 5.x anymore :)
            }
        }

        return @\serialize($serializable);
    }
}
