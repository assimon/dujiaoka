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
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Continue_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\While_;
use Psy\Exception\FatalErrorException;

/**
 * The loop context pass handles invalid `break` and `continue` statements.
 */
class LoopContextPass extends CodeCleanerPass
{
    private $loopDepth;

    /**
     * {@inheritdoc}
     */
    public function beforeTraverse(array $nodes)
    {
        $this->loopDepth = 0;
    }

    /**
     * @throws FatalErrorException if the node is a break or continue in a non-loop or switch context
     * @throws FatalErrorException if the node is trying to break out of more nested structures than exist
     * @throws FatalErrorException if the node is a break or continue and has a non-numeric argument
     * @throws FatalErrorException if the node is a break or continue and has an argument less than 1
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        switch (true) {
            case $node instanceof Do_:
            case $node instanceof For_:
            case $node instanceof Foreach_:
            case $node instanceof Switch_:
            case $node instanceof While_:
                $this->loopDepth++;
                break;

            case $node instanceof Break_:
            case $node instanceof Continue_:
                $operator = $node instanceof Break_ ? 'break' : 'continue';

                if ($this->loopDepth === 0) {
                    $msg = \sprintf("'%s' not in the 'loop' or 'switch' context", $operator);
                    throw new FatalErrorException($msg, 0, E_ERROR, null, $node->getLine());
                }

                if ($node->num instanceof LNumber || $node->num instanceof DNumber) {
                    $num = $node->num->value;
                    if ($node->num instanceof DNumber || $num < 1) {
                        $msg = \sprintf("'%s' operator accepts only positive numbers", $operator);
                        throw new FatalErrorException($msg, 0, E_ERROR, null, $node->getLine());
                    }

                    if ($num > $this->loopDepth) {
                        $msg = \sprintf("Cannot '%s' %d levels", $operator, $num);
                        throw new FatalErrorException($msg, 0, E_ERROR, null, $node->getLine());
                    }
                } elseif ($node->num) {
                    $msg = \sprintf("'%s' operator with non-constant operand is no longer supported", $operator);
                    throw new FatalErrorException($msg, 0, E_ERROR, null, $node->getLine());
                }
                break;
        }
    }

    /**
     * @param Node $node
     */
    public function leaveNode(Node $node)
    {
        switch (true) {
            case $node instanceof Do_:
            case $node instanceof For_:
            case $node instanceof Foreach_:
            case $node instanceof Switch_:
            case $node instanceof While_:
                $this->loopDepth--;
                break;
        }
    }
}
