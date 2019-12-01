<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VersionUpdater;

use Psy\Shell;

/**
 * A version checker stub which always thinks the current verion is up to date.
 */
class NoopChecker implements Checker
{
    /**
     * @return bool
     */
    public function isLatest()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getLatest()
    {
        return Shell::VERSION;
    }
}
