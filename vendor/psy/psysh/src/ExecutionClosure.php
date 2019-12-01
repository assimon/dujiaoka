<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy;

/**
 * The Psy Shell's execution scope.
 */
class ExecutionClosure
{
    const NOOP_INPUT = 'return null;';

    private $closure;

    /**
     * @param Shell $__psysh__
     */
    public function __construct(Shell $__psysh__)
    {
        $this->setClosure($__psysh__, function () use ($__psysh__) {
            try {
                // Restore execution scope variables
                \extract($__psysh__->getScopeVariables(false));

                // Buffer stdout; we'll need it later
                \ob_start([$__psysh__, 'writeStdout'], 1);

                // Convert all errors to exceptions
                \set_error_handler([$__psysh__, 'handleError']);

                // Evaluate the current code buffer
                $_ = eval($__psysh__->onExecute($__psysh__->flushCode() ?: ExecutionClosure::NOOP_INPUT));
            } catch (\Throwable $_e) {
                // Clean up on our way out.
                \restore_error_handler();
                if (\ob_get_level() > 0) {
                    \ob_end_clean();
                }

                throw $_e;
            } catch (\Exception $_e) {
                // Clean up on our way out.
                \restore_error_handler();
                if (\ob_get_level() > 0) {
                    \ob_end_clean();
                }

                throw $_e;
            }

            // Won't be needing this anymore
            \restore_error_handler();

            // Flush stdout (write to shell output, plus save to magic variable)
            \ob_end_flush();

            // Save execution scope variables for next time
            $__psysh__->setScopeVariables(\get_defined_vars());

            return $_;
        });
    }

    /**
     * Set the closure instance.
     *
     * @param Shell    $psysh
     * @param \Closure $closure
     */
    protected function setClosure(Shell $shell, \Closure $closure)
    {
        if (self::shouldBindClosure()) {
            $that = $shell->getBoundObject();
            if (\is_object($that)) {
                $closure = $closure->bindTo($that, \get_class($that));
            } else {
                $closure = $closure->bindTo(null, $shell->getBoundClass());
            }
        }

        $this->closure = $closure;
    }

    /**
     * Go go gadget closure.
     *
     * @return mixed
     */
    public function execute()
    {
        $closure = $this->closure;

        return $closure();
    }

    /**
     * Decide whether to bind the execution closure.
     *
     * @return bool
     */
    protected static function shouldBindClosure()
    {
        // skip binding on HHVM < 3.5.0
        // see https://github.com/facebook/hhvm/issues/1203
        if (\defined('HHVM_VERSION')) {
            return \version_compare(HHVM_VERSION, '3.5.0', '>=');
        }

        return true;
    }
}
