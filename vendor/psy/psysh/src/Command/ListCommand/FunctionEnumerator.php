<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command\ListCommand;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Function Enumerator class.
 */
class FunctionEnumerator extends Enumerator
{
    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list functions when no Reflector is present.
        //
        // @todo make a NamespaceReflector and pass that in for commands like:
        //
        //     ls --functions Foo
        //
        // ... for listing functions in the Foo namespace

        if ($reflector !== null || $target !== null) {
            return;
        }

        // only list functions if we are specifically asked
        if (!$input->getOption('functions')) {
            return;
        }

        if ($input->getOption('user')) {
            $label     = 'User Functions';
            $functions = $this->getFunctions('user');
        } elseif ($input->getOption('internal')) {
            $label     = 'Internal Functions';
            $functions = $this->getFunctions('internal');
        } else {
            $label     = 'Functions';
            $functions = $this->getFunctions();
        }

        $functions = $this->prepareFunctions($functions);

        if (empty($functions)) {
            return;
        }

        $ret = [];
        $ret[$label] = $functions;

        return $ret;
    }

    /**
     * Get defined functions.
     *
     * Optionally limit functions to "user" or "internal" functions.
     *
     * @param null|string $type "user" or "internal" (default: both)
     *
     * @return array
     */
    protected function getFunctions($type = null)
    {
        $funcs = \get_defined_functions();

        if ($type) {
            return $funcs[$type];
        } else {
            return \array_merge($funcs['internal'], $funcs['user']);
        }
    }

    /**
     * Prepare formatted function array.
     *
     * @param array $functions
     *
     * @return array
     */
    protected function prepareFunctions(array $functions)
    {
        \natcasesort($functions);

        // My kingdom for a generator.
        $ret = [];

        foreach ($functions as $name) {
            if ($this->showItem($name)) {
                $ret[$name] = [
                    'name'  => $name,
                    'style' => self::IS_FUNCTION,
                    'value' => $this->presentSignature($name),
                ];
            }
        }

        return $ret;
    }
}
