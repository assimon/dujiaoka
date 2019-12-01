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

interface Checker
{
    const ALWAYS  = 'always';
    const DAILY   = 'daily';
    const WEEKLY  = 'weekly';
    const MONTHLY = 'monthly';
    const NEVER   = 'never';

    /**
     * @return bool
     */
    public function isLatest();

    /**
     * @return string
     */
    public function getLatest();
}
