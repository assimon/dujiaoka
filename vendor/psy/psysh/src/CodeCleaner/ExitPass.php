<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\CodeCleaner;

use PhpParser\Node;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;

class ExitPass extends CodeCleanerPass
{
    /**
     * Converts exit calls to BreakExceptions.
     *
     * @param \PhpParser\Node $node
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Exit_) {
            return new StaticCall(new FullyQualifiedName('Psy\Exception\BreakException'), 'exitShell');
        }
    }
}
