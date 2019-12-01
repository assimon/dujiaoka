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

use PhpParser\PrettyPrinter\Standard as Printer;
use Psy\Exception\ParseErrorException;
use Psy\ParserFactory;

class ParserTestCase extends \PHPUnit\Framework\TestCase
{
    protected $traverser;
    private $parser;
    private $printer;

    public function tearDown()
    {
        $this->traverser = null;
        $this->parser = null;
        $this->printer = null;
    }

    protected function parse($code, $prefix = '<?php ')
    {
        $code = $prefix . $code;
        try {
            return $this->getParser()->parse($code);
        } catch (\PhpParser\Error $e) {
            if (!$this->parseErrorIsEOF($e)) {
                throw ParseErrorException::fromParseError($e);
            }

            try {
                // Unexpected EOF, try again with an implicit semicolon
                return $this->getParser()->parse($code . ';');
            } catch (\PhpParser\Error $e) {
                return false;
            }
        }
    }

    protected function traverse(array $stmts)
    {
        if (!isset($this->traverser)) {
            throw new \RuntimeException('Test cases must provide a traverser');
        }

        return $this->traverser->traverse($stmts);
    }

    protected function prettyPrint(array $stmts)
    {
        return $this->getPrinter()->prettyPrint($stmts);
    }

    protected function assertProcessesAs($from, $to)
    {
        $stmts = $this->parse($from);
        $stmts = $this->traverse($stmts);
        $toStmts = $this->parse($to);
        $this->assertSame($this->prettyPrint($toStmts), $this->prettyPrint($stmts));
    }

    private function getParser()
    {
        if (!isset($this->parser)) {
            $parserFactory = new ParserFactory();
            $this->parser  = $parserFactory->createParser();
        }

        return $this->parser;
    }

    private function getPrinter()
    {
        if (!isset($this->printer)) {
            $this->printer = new Printer();
        }

        return $this->printer;
    }

    private function parseErrorIsEOF(\PhpParser\Error $e)
    {
        $msg = $e->getRawMessage();

        return ($msg === 'Unexpected token EOF') || (\strpos($msg, 'Syntax error, unexpected EOF') !== false);
    }
}
