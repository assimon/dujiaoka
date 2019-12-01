<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use PhpParser\NodeTraverser;
use Psy\CodeCleaner\CodeCleanerPass;
use Psy\Test\ParserTestCase;

class CodeCleanerTestCase extends ParserTestCase
{
    protected $pass;

    public function tearDown()
    {
        $this->pass = null;
        parent::tearDown();
    }

    protected function setPass(CodeCleanerPass $pass)
    {
        $this->pass = $pass;
        if (!isset($this->traverser)) {
            $this->traverser = new NodeTraverser();
        }
        $this->traverser->addVisitor($this->pass);
    }

    protected function parseAndTraverse($code, $prefix = '<?php ')
    {
        return $this->traverse($this->parse($code, $prefix));
    }
}
