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

use Psy\VarDumper\Presenter;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Interface Enumerator class.
 *
 * @deprecated Nothing should use this anymore
 */
class InterfaceEnumerator extends Enumerator
{
    public function __construct(Presenter $presenter)
    {
        @\trigger_error('InterfaceEnumerator is no longer used', E_USER_DEPRECATED);
        parent::__construct($presenter);
    }

    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list interfaces when no Reflector is present.
        //
        // @todo make a NamespaceReflector and pass that in for commands like:
        //
        //     ls --interfaces Foo
        //
        // ... for listing interfaces in the Foo namespace

        if ($reflector !== null || $target !== null) {
            return;
        }

        // only list interfaces if we are specifically asked
        if (!$input->getOption('interfaces')) {
            return;
        }

        $interfaces = $this->prepareInterfaces(\get_declared_interfaces());

        if (empty($interfaces)) {
            return;
        }

        return [
            'Interfaces' => $interfaces,
        ];
    }

    /**
     * Prepare formatted interface array.
     *
     * @param array $interfaces
     *
     * @return array
     */
    protected function prepareInterfaces(array $interfaces)
    {
        \natcasesort($interfaces);

        // My kingdom for a generator.
        $ret = [];

        foreach ($interfaces as $name) {
            if ($this->showItem($name)) {
                $ret[$name] = [
                    'name'  => $name,
                    'style' => self::IS_CLASS,
                    'value' => $this->presentSignature($name),
                ];
            }
        }

        return $ret;
    }
}
