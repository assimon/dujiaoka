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
 * Class Enumerator class.
 */
class ClassEnumerator extends Enumerator
{
    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list classes when no Reflector is present.
        //
        // @todo make a NamespaceReflector and pass that in for commands like:
        //
        //     ls --classes Foo
        //
        // ... for listing classes in the Foo namespace

        if ($reflector !== null || $target !== null) {
            return;
        }

        $user     = $input->getOption('user');
        $internal = $input->getOption('internal');

        $ret = [];

        // only list classes, interfaces and traits if we are specifically asked

        if ($input->getOption('classes')) {
            $ret = \array_merge($ret, $this->filterClasses('Classes', \get_declared_classes(), $internal, $user));
        }

        if ($input->getOption('interfaces')) {
            $ret = \array_merge($ret, $this->filterClasses('Interfaces', \get_declared_interfaces(), $internal, $user));
        }

        if ($input->getOption('traits')) {
            $ret = \array_merge($ret, $this->filterClasses('Traits', \get_declared_traits(), $internal, $user));
        }

        return \array_map([$this, 'prepareClasses'], \array_filter($ret));
    }

    /**
     * Filter a list of classes, interfaces or traits.
     *
     * If $internal or $user is defined, results will be limited to internal or
     * user-defined classes as appropriate.
     *
     * @param string $key
     * @param array  $classes
     * @param bool   $internal
     * @param bool   $user
     *
     * @return array
     */
    protected function filterClasses($key, $classes, $internal, $user)
    {
        $ret = [];

        if ($internal) {
            $ret['Internal ' . $key] = \array_filter($classes, function ($class) {
                $refl = new \ReflectionClass($class);

                return $refl->isInternal();
            });
        }

        if ($user) {
            $ret['User ' . $key] = \array_filter($classes, function ($class) {
                $refl = new \ReflectionClass($class);

                return !$refl->isInternal();
            });
        }

        if (!$user && !$internal) {
            $ret[$key] = $classes;
        }

        return $ret;
    }

    /**
     * Prepare formatted class array.
     *
     * @param array $classes
     *
     * @return array
     */
    protected function prepareClasses(array $classes)
    {
        \natcasesort($classes);

        // My kingdom for a generator.
        $ret = [];

        foreach ($classes as $name) {
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
