<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Configuration;

/**
 * Manages Predis options with filtering, conversion and lazy initialization of
 * values using a mini-DI container approach.
 *
 * {@inheritdoc}
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class Options implements OptionsInterface
{
    protected $input;
    protected $options;
    protected $handlers;

    /**
     * @param array $options Array of options with their values
     */
    public function __construct(array $options = array())
    {
        $this->input = $options;
        $this->options = array();
        $this->handlers = $this->getHandlers();
    }

    /**
     * Ensures that the default options are initialized.
     *
     * @return array
     */
    protected function getHandlers()
    {
        return array(
            'cluster' => 'Predis\Configuration\ClusterOption',
            'connections' => 'Predis\Configuration\ConnectionFactoryOption',
            'exceptions' => 'Predis\Configuration\ExceptionsOption',
            'prefix' => 'Predis\Configuration\PrefixOption',
            'profile' => 'Predis\Configuration\ProfileOption',
            'replication' => 'Predis\Configuration\ReplicationOption',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault($option)
    {
        if (isset($this->handlers[$option])) {
            $handler = $this->handlers[$option];
            $handler = new $handler();

            return $handler->getDefault($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function defined($option)
    {
        return
            array_key_exists($option, $this->options) ||
            array_key_exists($option, $this->input)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($option)
    {
        return (
            array_key_exists($option, $this->options) ||
            array_key_exists($option, $this->input)
        ) && $this->__get($option) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function __get($option)
    {
        if (isset($this->options[$option]) || array_key_exists($option, $this->options)) {
            return $this->options[$option];
        }

        if (isset($this->input[$option]) || array_key_exists($option, $this->input)) {
            $value = $this->input[$option];
            unset($this->input[$option]);

            if (is_object($value) && method_exists($value, '__invoke')) {
                $value = $value($this, $option);
            }

            if (isset($this->handlers[$option])) {
                $handler = $this->handlers[$option];
                $handler = new $handler();
                $value = $handler->filter($this, $value);
            }

            return $this->options[$option] = $value;
        }

        if (isset($this->handlers[$option])) {
            return $this->options[$option] = $this->getDefault($option);
        }

        return;
    }
}
