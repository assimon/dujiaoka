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
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Stmt\Namespace_;

/**
 * Abstract namespace-aware code cleaner pass.
 */
abstract class NamespaceAwarePass extends CodeCleanerPass
{
    protected $namespace;
    protected $currentScope;

    /**
     * @todo should this be final? Extending classes should be sure to either
     * use afterTraverse or call parent::beforeTraverse() when overloading.
     *
     * Reset the namespace and the current scope before beginning analysis
     */
    public function beforeTraverse(array $nodes)
    {
        $this->namespace    = [];
        $this->currentScope = [];
    }

    /**
     * @todo should this be final? Extending classes should be sure to either use
     * leaveNode or call parent::enterNode() when overloading
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Namespace_) {
            $this->namespace = isset($node->name) ? $node->name->parts : [];
        }
    }

    /**
     * Get a fully-qualified name (class, function, interface, etc).
     *
     * @param mixed $name
     *
     * @return string
     */
    protected function getFullyQualifiedName($name)
    {
        if ($name instanceof FullyQualifiedName) {
            return \implode('\\', $name->parts);
        } elseif ($name instanceof Name) {
            $name = $name->parts;
        } elseif (!\is_array($name)) {
            $name = [$name];
        }

        return \implode('\\', \array_merge($this->namespace, $name));
    }
}
