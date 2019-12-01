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
 * Trait Enumerator class.
 *
 * @deprecated Nothing should use this anymore
 */
class TraitEnumerator extends Enumerator
{
    public function __construct(Presenter $presenter)
    {
        @\trigger_error('TraitEnumerator is no longer used', E_USER_DEPRECATED);
        parent::__construct($presenter);
    }

    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list traits when no Reflector is present.
        //
        // @todo make a NamespaceReflector and pass that in for commands like:
        //
        //     ls --traits Foo
        //
        // ... for listing traits in the Foo namespace

        if ($reflector !== null || $target !== null) {
            return;
        }

        // only list traits if we are specifically asked
        if (!$input->getOption('traits')) {
            return;
        }

        $traits = $this->prepareTraits(\get_declared_traits());

        if (empty($traits)) {
            return;
        }

        return [
            'Traits' => $traits,
        ];
    }

    /**
     * Prepare formatted trait array.
     *
     * @param array $traits
     *
     * @return array
     */
    protected function prepareTraits(array $traits)
    {
        \natcasesort($traits);

        // My kingdom for a generator.
        $ret = [];

        foreach ($traits as $name) {
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
