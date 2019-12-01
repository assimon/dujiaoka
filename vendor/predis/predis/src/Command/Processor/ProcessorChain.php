<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Processor;

use Predis\Command\CommandInterface;

/**
 * Default implementation of a command processors chain.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ProcessorChain implements \ArrayAccess, ProcessorInterface
{
    private $processors = array();

    /**
     * @param array $processors List of instances of ProcessorInterface.
     */
    public function __construct($processors = array())
    {
        foreach ($processors as $processor) {
            $this->add($processor);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(ProcessorInterface $processor)
    {
        if (false !== $index = array_search($processor, $this->processors, true)) {
            unset($this[$index]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(CommandInterface $command)
    {
        for ($i = 0; $i < $count = count($this->processors); ++$i) {
            $this->processors[$i]->process($command);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessors()
    {
        return $this->processors;
    }

    /**
     * Returns an iterator over the list of command processor in the chain.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->processors);
    }

    /**
     * Returns the number of command processors in the chain.
     *
     * @return int
     */
    public function count()
    {
        return count($this->processors);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($index)
    {
        return isset($this->processors[$index]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($index)
    {
        return $this->processors[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($index, $processor)
    {
        if (!$processor instanceof ProcessorInterface) {
            throw new \InvalidArgumentException(
                'A processor chain accepts only instances of '.
                "'Predis\Command\Processor\ProcessorInterface'."
            );
        }

        $this->processors[$index] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($index)
    {
        unset($this->processors[$index]);
        $this->processors = array_values($this->processors);
    }
}
