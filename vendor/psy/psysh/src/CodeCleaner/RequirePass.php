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
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Scalar\LNumber;
use Psy\Exception\ErrorException;
use Psy\Exception\FatalErrorException;
use Psy\Shell;

/**
 * Add runtime validation for `require` and `require_once` calls.
 */
class RequirePass extends CodeCleanerPass
{
    private static $requireTypes = [Include_::TYPE_REQUIRE, Include_::TYPE_REQUIRE_ONCE];

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $origNode)
    {
        if (!$this->isRequireNode($origNode)) {
            return;
        }

        $node = clone $origNode;

        /*
         * rewrite
         *
         *   $foo = require $bar
         *
         * to
         *
         *   $foo = require \Psy\CodeCleaner\RequirePass::resolve($bar)
         */
        $node->expr = new StaticCall(
            new FullyQualifiedName('Psy\CodeCleaner\RequirePass'),
            'resolve',
            [new Arg($origNode->expr), new Arg(new LNumber($origNode->getLine()))],
            $origNode->getAttributes()
        );

        return $node;
    }

    /**
     * Runtime validation that $file can be resolved as an include path.
     *
     * If $file can be resolved, return $file. Otherwise throw a fatal error exception.
     *
     * @throws FatalErrorException when unable to resolve include path for $file
     * @throws ErrorException      if $file is empty and E_WARNING is included in error_reporting level
     *
     * @param string $file
     * @param int    $lineNumber Line number of the original require expression
     *
     * @return string Exactly the same as $file
     */
    public static function resolve($file, $lineNumber = null)
    {
        $file = (string) $file;

        if ($file === '') {
            // @todo Shell::handleError would be better here, because we could
            // fake the file and line number, but we can't call it statically.
            // So we're duplicating some of the logics here.
            if (E_WARNING & \error_reporting()) {
                ErrorException::throwException(E_WARNING, 'Filename cannot be empty', null, $lineNumber);
            }
            // @todo trigger an error as fallback? this is pretty ugly…
            // trigger_error('Filename cannot be empty', E_USER_WARNING);
        }

        if ($file === '' || !\stream_resolve_include_path($file)) {
            $msg = \sprintf("Failed opening required '%s'", $file);
            throw new FatalErrorException($msg, 0, E_ERROR, null, $lineNumber);
        }

        return $file;
    }

    private function isRequireNode(Node $node)
    {
        return $node instanceof Include_ && \in_array($node->type, self::$requireTypes);
    }
}
