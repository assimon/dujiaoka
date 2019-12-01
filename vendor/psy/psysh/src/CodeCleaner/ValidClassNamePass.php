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
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\Stmt\While_;
use Psy\Exception\FatalErrorException;

/**
 * Validate that classes exist.
 *
 * This pass throws a FatalErrorException rather than letting PHP run
 * headfirst into a real fatal error and die.
 */
class ValidClassNamePass extends NamespaceAwarePass
{
    const CLASS_TYPE     = 'class';
    const INTERFACE_TYPE = 'interface';
    const TRAIT_TYPE     = 'trait';

    private $conditionalScopes = 0;
    private $atLeastPhp55;

    public function __construct()
    {
        $this->atLeastPhp55 = \version_compare(PHP_VERSION, '5.5', '>=');
    }

    /**
     * Validate class, interface and trait definitions.
     *
     * Validate them upon entering the node, so that we know about their
     * presence and can validate constant fetches and static calls in class or
     * trait methods.
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        parent::enterNode($node);

        if (self::isConditional($node)) {
            $this->conditionalScopes++;
        } else {
            // @todo add an "else" here which adds a runtime check for instances where we can't tell
            // whether a class is being redefined by static analysis alone.
            if ($this->conditionalScopes === 0) {
                if ($node instanceof Class_) {
                    $this->validateClassStatement($node);
                } elseif ($node instanceof Interface_) {
                    $this->validateInterfaceStatement($node);
                } elseif ($node instanceof Trait_) {
                    $this->validateTraitStatement($node);
                }
            }
        }
    }

    /**
     * Validate `new` expressions, class constant fetches, and static calls.
     *
     * @throws FatalErrorException if a class, interface or trait is referenced which does not exist
     * @throws FatalErrorException if a class extends something that is not a class
     * @throws FatalErrorException if a class implements something that is not an interface
     * @throws FatalErrorException if an interface extends something that is not an interface
     * @throws FatalErrorException if a class, interface or trait redefines an existing class, interface or trait name
     *
     * @param Node $node
     */
    public function leaveNode(Node $node)
    {
        if (self::isConditional($node)) {
            $this->conditionalScopes--;
        } elseif ($node instanceof New_) {
            $this->validateNewExpression($node);
        } elseif ($node instanceof ClassConstFetch) {
            $this->validateClassConstFetchExpression($node);
        } elseif ($node instanceof StaticCall) {
            $this->validateStaticCallExpression($node);
        }
    }

    private static function isConditional(Node $node)
    {
        return $node instanceof If_ ||
            $node instanceof While_ ||
            $node instanceof Do_ ||
            $node instanceof Switch_;
    }

    /**
     * Validate a class definition statement.
     *
     * @param Class_ $stmt
     */
    protected function validateClassStatement(Class_ $stmt)
    {
        $this->ensureCanDefine($stmt, self::CLASS_TYPE);
        if (isset($stmt->extends)) {
            $this->ensureClassExists($this->getFullyQualifiedName($stmt->extends), $stmt);
        }
        $this->ensureInterfacesExist($stmt->implements, $stmt);
    }

    /**
     * Validate an interface definition statement.
     *
     * @param Interface_ $stmt
     */
    protected function validateInterfaceStatement(Interface_ $stmt)
    {
        $this->ensureCanDefine($stmt, self::INTERFACE_TYPE);
        $this->ensureInterfacesExist($stmt->extends, $stmt);
    }

    /**
     * Validate a trait definition statement.
     *
     * @param Trait_ $stmt
     */
    protected function validateTraitStatement(Trait_ $stmt)
    {
        $this->ensureCanDefine($stmt, self::TRAIT_TYPE);
    }

    /**
     * Validate a `new` expression.
     *
     * @param New_ $stmt
     */
    protected function validateNewExpression(New_ $stmt)
    {
        // if class name is an expression or an anonymous class, give it a pass for now
        if (!$stmt->class instanceof Expr && !$stmt->class instanceof Class_) {
            $this->ensureClassExists($this->getFullyQualifiedName($stmt->class), $stmt);
        }
    }

    /**
     * Validate a class constant fetch expression's class.
     *
     * @param ClassConstFetch $stmt
     */
    protected function validateClassConstFetchExpression(ClassConstFetch $stmt)
    {
        // there is no need to check exists for ::class const for php 5.5 or newer
        if (\strtolower($stmt->name) === 'class' && $this->atLeastPhp55) {
            return;
        }

        // if class name is an expression, give it a pass for now
        if (!$stmt->class instanceof Expr) {
            $this->ensureClassOrInterfaceExists($this->getFullyQualifiedName($stmt->class), $stmt);
        }
    }

    /**
     * Validate a class constant fetch expression's class.
     *
     * @param StaticCall $stmt
     */
    protected function validateStaticCallExpression(StaticCall $stmt)
    {
        // if class name is an expression, give it a pass for now
        if (!$stmt->class instanceof Expr) {
            $this->ensureMethodExists($this->getFullyQualifiedName($stmt->class), $stmt->name, $stmt);
        }
    }

    /**
     * Ensure that no class, interface or trait name collides with a new definition.
     *
     * @throws FatalErrorException
     *
     * @param Stmt   $stmt
     * @param string $scopeType
     */
    protected function ensureCanDefine(Stmt $stmt, $scopeType = self::CLASS_TYPE)
    {
        $name = $this->getFullyQualifiedName($stmt->name);

        // check for name collisions
        $errorType = null;
        if ($this->classExists($name)) {
            $errorType = self::CLASS_TYPE;
        } elseif ($this->interfaceExists($name)) {
            $errorType = self::INTERFACE_TYPE;
        } elseif ($this->traitExists($name)) {
            $errorType = self::TRAIT_TYPE;
        }

        if ($errorType !== null) {
            throw $this->createError(\sprintf('%s named %s already exists', \ucfirst($errorType), $name), $stmt);
        }

        // Store creation for the rest of this code snippet so we can find local
        // issue too
        $this->currentScope[\strtolower($name)] = $scopeType;
    }

    /**
     * Ensure that a referenced class exists.
     *
     * @throws FatalErrorException
     *
     * @param string $name
     * @param Stmt   $stmt
     */
    protected function ensureClassExists($name, $stmt)
    {
        if (!$this->classExists($name)) {
            throw $this->createError(\sprintf('Class \'%s\' not found', $name), $stmt);
        }
    }

    /**
     * Ensure that a referenced class _or interface_ exists.
     *
     * @throws FatalErrorException
     *
     * @param string $name
     * @param Stmt   $stmt
     */
    protected function ensureClassOrInterfaceExists($name, $stmt)
    {
        if (!$this->classExists($name) && !$this->interfaceExists($name)) {
            throw $this->createError(\sprintf('Class \'%s\' not found', $name), $stmt);
        }
    }

    /**
     * Ensure that a referenced class _or trait_ exists.
     *
     * @throws FatalErrorException
     *
     * @param string $name
     * @param Stmt   $stmt
     */
    protected function ensureClassOrTraitExists($name, $stmt)
    {
        if (!$this->classExists($name) && !$this->traitExists($name)) {
            throw $this->createError(\sprintf('Class \'%s\' not found', $name), $stmt);
        }
    }

    /**
     * Ensure that a statically called method exists.
     *
     * @throws FatalErrorException
     *
     * @param string $class
     * @param string $name
     * @param Stmt   $stmt
     */
    protected function ensureMethodExists($class, $name, $stmt)
    {
        $this->ensureClassOrTraitExists($class, $stmt);

        // let's pretend all calls to self, parent and static are valid
        if (\in_array(\strtolower($class), ['self', 'parent', 'static'])) {
            return;
        }

        // ... and all calls to classes defined right now
        if ($this->findInScope($class) === self::CLASS_TYPE) {
            return;
        }

        // if method name is an expression, give it a pass for now
        if ($name instanceof Expr) {
            return;
        }

        if (!\method_exists($class, $name) && !\method_exists($class, '__callStatic')) {
            throw $this->createError(\sprintf('Call to undefined method %s::%s()', $class, $name), $stmt);
        }
    }

    /**
     * Ensure that a referenced interface exists.
     *
     * @throws FatalErrorException
     *
     * @param Interface_[] $interfaces
     * @param Stmt         $stmt
     */
    protected function ensureInterfacesExist($interfaces, $stmt)
    {
        foreach ($interfaces as $interface) {
            /** @var string $name */
            $name = $this->getFullyQualifiedName($interface);
            if (!$this->interfaceExists($name)) {
                throw $this->createError(\sprintf('Interface \'%s\' not found', $name), $stmt);
            }
        }
    }

    /**
     * Get a symbol type key for storing in the scope name cache.
     *
     * @deprecated No longer used. Scope type should be passed into ensureCanDefine directly.
     * @codeCoverageIgnore
     *
     * @param Stmt $stmt
     *
     * @return string
     */
    protected function getScopeType(Stmt $stmt)
    {
        if ($stmt instanceof Class_) {
            return self::CLASS_TYPE;
        } elseif ($stmt instanceof Interface_) {
            return self::INTERFACE_TYPE;
        } elseif ($stmt instanceof Trait_) {
            return self::TRAIT_TYPE;
        }
    }

    /**
     * Check whether a class exists, or has been defined in the current code snippet.
     *
     * Gives `self`, `static` and `parent` a free pass.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function classExists($name)
    {
        // Give `self`, `static` and `parent` a pass. This will actually let
        // some errors through, since we're not checking whether the keyword is
        // being used in a class scope.
        if (\in_array(\strtolower($name), ['self', 'static', 'parent'])) {
            return true;
        }

        return \class_exists($name) || $this->findInScope($name) === self::CLASS_TYPE;
    }

    /**
     * Check whether an interface exists, or has been defined in the current code snippet.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function interfaceExists($name)
    {
        return \interface_exists($name) || $this->findInScope($name) === self::INTERFACE_TYPE;
    }

    /**
     * Check whether a trait exists, or has been defined in the current code snippet.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function traitExists($name)
    {
        return \trait_exists($name) || $this->findInScope($name) === self::TRAIT_TYPE;
    }

    /**
     * Find a symbol in the current code snippet scope.
     *
     * @param string $name
     *
     * @return string|null
     */
    protected function findInScope($name)
    {
        $name = \strtolower($name);
        if (isset($this->currentScope[$name])) {
            return $this->currentScope[$name];
        }
    }

    /**
     * Error creation factory.
     *
     * @param string $msg
     * @param Stmt   $stmt
     *
     * @return FatalErrorException
     */
    protected function createError($msg, $stmt)
    {
        return new FatalErrorException($msg, 0, E_ERROR, null, $stmt->getLine());
    }
}
