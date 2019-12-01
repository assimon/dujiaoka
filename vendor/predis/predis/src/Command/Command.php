<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command;

/**
 * Base class for Redis commands.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class Command implements CommandInterface
{
    private $slot;
    private $arguments = array();

    /**
     * Returns a filtered array of the arguments.
     *
     * @param array $arguments List of arguments.
     *
     * @return array
     */
    protected function filterArguments(array $arguments)
    {
        return $arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $this->filterArguments($arguments);
        unset($this->slot);
    }

    /**
     * {@inheritdoc}
     */
    public function setRawArguments(array $arguments)
    {
        $this->arguments = $arguments;
        unset($this->slot);
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument($index)
    {
        if (isset($this->arguments[$index])) {
            return $this->arguments[$index];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlot()
    {
        if (isset($this->slot)) {
            return $this->slot;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        return $data;
    }

    /**
     * Normalizes the arguments array passed to a Redis command.
     *
     * @param array $arguments Arguments for a command.
     *
     * @return array
     */
    public static function normalizeArguments(array $arguments)
    {
        if (count($arguments) === 1 && is_array($arguments[0])) {
            return $arguments[0];
        }

        return $arguments;
    }

    /**
     * Normalizes the arguments array passed to a variadic Redis command.
     *
     * @param array $arguments Arguments for a command.
     *
     * @return array
     */
    public static function normalizeVariadic(array $arguments)
    {
        if (count($arguments) === 2 && is_array($arguments[1])) {
            return array_merge(array($arguments[0]), $arguments[1]);
        }

        return $arguments;
    }
}
