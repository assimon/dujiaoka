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
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\Variable;
use Psy\Exception\ParseErrorException;

/**
 * Validate that the user did not call the language construct `empty()` on a
 * statement in PHP < 5.5.
 *
 * @codeCoverageIgnore
 */
class LegacyEmptyPass extends CodeCleanerPass
{
    private $atLeastPhp55;

    public function __construct()
    {
        $this->atLeastPhp55 = \version_compare(PHP_VERSION, '5.5', '>=');
    }

    /**
     * Validate use of empty in PHP < 5.5.
     *
     * @throws ParseErrorException if the user used empty with anything but a variable
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        if ($this->atLeastPhp55) {
            return;
        }

        if (!$node instanceof Empty_) {
            return;
        }

        if (!$node->expr instanceof Variable) {
            $msg = \sprintf('syntax error, unexpected %s', $this->getUnexpectedThing($node->expr));

            throw new ParseErrorException($msg, $node->expr->getLine());
        }
    }

    private function getUnexpectedThing(Node $node)
    {
        switch ($node->getType()) {
            case 'Scalar_String':
            case 'Scalar_LNumber':
            case 'Scalar_DNumber':
                return \json_encode($node->value);

            case 'Expr_ConstFetch':
                return (string) $node->name;

            default:
                return $node->getType();
        }
    }
}
