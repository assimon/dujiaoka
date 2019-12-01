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
 * Constant Enumerator class.
 */
class ConstantEnumerator extends Enumerator
{
    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list constants when no Reflector is present.
        //
        // @todo make a NamespaceReflector and pass that in for commands like:
        //
        //     ls --constants Foo
        //
        // ... for listing constants in the Foo namespace
        if ($reflector !== null || $target !== null) {
            return;
        }

        // only list constants if we are specifically asked
        if (!$input->getOption('constants')) {
            return;
        }

        $user     = $input->getOption('user');
        $internal = $input->getOption('internal');
        $category = $input->getOption('category');

        $ret = [];

        if ($user) {
            $ret['User Constants'] = $this->getConstants('user');
        }

        if ($internal) {
            $ret['Interal Constants'] = $this->getConstants('internal');
        }

        if ($category) {
            $label = \ucfirst($category) . ' Constants';
            $ret[$label] = $this->getConstants($category);
        }

        if (!$user && !$internal && !$category) {
            $ret['Constants'] = $this->getConstants();
        }

        return \array_map([$this, 'prepareConstants'], \array_filter($ret));
    }

    /**
     * Get defined constants.
     *
     * Optionally restrict constants to a given category, e.g. "date". If the
     * category is "internal", include all non-user-defined constants.
     *
     * @param string $category
     *
     * @return array
     */
    protected function getConstants($category = null)
    {
        if (!$category) {
            return \get_defined_constants();
        }

        $consts = \get_defined_constants(true);

        if ($category === 'internal') {
            unset($consts['user']);

            return \call_user_func_array('array_merge', $consts);
        }

        return isset($consts[$category]) ? $consts[$category] : [];
    }

    /**
     * Prepare formatted constant array.
     *
     * @param array $constants
     *
     * @return array
     */
    protected function prepareConstants(array $constants)
    {
        // My kingdom for a generator.
        $ret = [];

        $names = \array_keys($constants);
        \natcasesort($names);

        foreach ($names as $name) {
            if ($this->showItem($name)) {
                $ret[$name] = [
                    'name'  => $name,
                    'style' => self::IS_CONSTANT,
                    'value' => $this->presentRef($constants[$name]),
                ];
            }
        }

        return $ret;
    }
}
