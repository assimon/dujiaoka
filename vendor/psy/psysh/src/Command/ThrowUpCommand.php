<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Throw_;
use PhpParser\PrettyPrinter\Standard as Printer;
use Psy\Context;
use Psy\ContextAware;
use Psy\Input\CodeArgument;
use Psy\ParserFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Throw an exception or error out of the Psy Shell.
 */
class ThrowUpCommand extends Command implements ContextAware
{
    const THROW_CLASS = 'Psy\Exception\ThrowUpException';

    private $parser;
    private $printer;

    /**
     * Context instance (for ContextAware interface).
     *
     * @var Context
     */
    protected $context;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        $parserFactory = new ParserFactory();

        $this->parser  = $parserFactory->createParser();
        $this->printer = new Printer();

        parent::__construct($name);
    }

    /**
     * ContextAware interface.
     *
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('throw-up')
            ->setDefinition([
                new CodeArgument('exception', CodeArgument::OPTIONAL, 'Exception or Error to throw.'),
            ])
            ->setDescription('Throw an exception or error out of the Psy Shell.')
            ->setHelp(
                <<<'HELP'
Throws an exception or error out of the current the Psy Shell instance.

By default it throws the most recent exception.

e.g.
<return>>>> throw-up</return>
<return>>>> throw-up $e</return>
<return>>>> throw-up new Exception('WHEEEEEE!')</return>
<return>>>> throw-up "bye!"</return>
HELP
            );
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException if there is no exception to throw
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $this->prepareArgs($input->getArgument('exception'));
        $throwStmt = new Throw_(new StaticCall(new FullyQualifiedName(self::THROW_CLASS), 'fromThrowable', $args));
        $throwCode = $this->printer->prettyPrint([$throwStmt]);

        $shell = $this->getApplication();
        $shell->addCode($throwCode, !$shell->hasCode());

        return 0;
    }

    /**
     * Parse the supplied command argument.
     *
     * If no argument was given, this falls back to `$_e`
     *
     * @throws InvalidArgumentException if there is no exception to throw
     *
     * @param string $code
     *
     * @return Arg[]
     */
    private function prepareArgs($code = null)
    {
        if (!$code) {
            // Default to last exception if nothing else was supplied
            return [new Arg(new Variable('_e'))];
        }

        if (\strpos('<?', $code) === false) {
            $code = '<?php ' . $code;
        }

        $nodes = $this->parse($code);
        if (\count($nodes) !== 1) {
            throw new \InvalidArgumentException('No idea how to throw this');
        }

        $node = $nodes[0];

        // Make this work for PHP Parser v3.x
        $expr = isset($node->expr) ? $node->expr : $node;

        $args = [new Arg($expr, false, false, $node->getAttributes())];

        // Allow throwing via a string, e.g. `throw-up "SUP"`
        if ($expr instanceof String_) {
            return [new New_(new FullyQualifiedName('Exception'), $args)];
        }

        return $args;
    }

    /**
     * Lex and parse a string of code into statements.
     *
     * @param string $code
     *
     * @return array Statements
     */
    private function parse($code)
    {
        try {
            return $this->parser->parse($code);
        } catch (\PhpParser\Error $e) {
            if (\strpos($e->getMessage(), 'unexpected EOF') === false) {
                throw $e;
            }

            // If we got an unexpected EOF, let's try it again with a semicolon.
            return $this->parser->parse($code . ';');
        }
    }
}
