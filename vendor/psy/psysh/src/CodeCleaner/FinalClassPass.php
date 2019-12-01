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
use PhpParser\Node\Stmt\Class_;
use Psy\Exception\FatalErrorException;

/**
 * The final class pass handles final classes.
 */
class FinalClassPass extends CodeCleanerPass
{
    private $finalClasses;

    /**
     * @param array $nodes
     */
    public function beforeTraverse(array $nodes)
    {
        $this->finalClasses = [];
    }

    /**
     * @throws RuntimeException if the node is a class that extends a final class
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Class_) {
            if ($node->extends) {
                $extends = (string) $node->extends;
                if ($this->isFinalClass($extends)) {
                    $msg = \sprintf('Class %s may not inherit from final class (%s)', $node->name, $extends);
                    throw new FatalErrorException($msg, 0, E_ERROR, null, $node->getLine());
                }
            }

            if ($node->isFinal()) {
                $this->finalClasses[\strtolower($node->name)] = true;
            }
        }
    }

    /**
     * @param string $name Class name
     *
     * @return bool
     */
    private function isFinalClass($name)
    {
        if (!\class_exists($name)) {
            return isset($this->finalClasses[\strtolower($name)]);
        }

        $refl = new \ReflectionClass($name);

        return $refl->isFinal();
    }
}
