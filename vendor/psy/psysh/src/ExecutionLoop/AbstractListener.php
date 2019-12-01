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

use Psy\Shell;

/**
 * Abstract Execution Loop Listener class.
 */
abstract class AbstractListener implements Listener
{
    /**
     * {@inheritdoc}
     */
    public function beforeRun(Shell $shell)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function beforeLoop(Shell $shell)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function onInput(Shell $shell, $input)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function onExecute(Shell $shell, $code)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoop(Shell $shell)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function afterRun(Shell $shell)
    {
    }
}
