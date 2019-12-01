<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test;

use Psy\Shell;

class FakeShell extends Shell
{
    public $matchers;

    public function __construct(Configuration $config = null)
    {
        // This space intentionally left blank
    }

    public function addMatchers(array $matchers)
    {
        $this->matchers = $matchers;
    }
}
