<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Response\Iterator;

/**
 * Outer iterator consuming streamable multibulk responses by yielding tuples of
 * keys and values.
 *
 * This wrapper is useful for responses to commands such as `HGETALL` that can
 * be iterater as $key => $value pairs.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class MultiBulkTuple extends MultiBulk implements \OuterIterator
{
    private $iterator;

    /**
     * @param MultiBulk $iterator Inner multibulk response iterator.
     */
    public function __construct(MultiBulk $iterator)
    {
        $this->checkPreconditions($iterator);

        $this->size = count($iterator) / 2;
        $this->iterator = $iterator;
        $this->position = $iterator->getPosition();
        $this->current = $this->size > 0 ? $this->getValue() : null;
    }

    /**
     * Checks for valid preconditions.
     *
     * @param MultiBulk $iterator Inner multibulk response iterator.
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    protected function checkPreconditions(MultiBulk $iterator)
    {
        if ($iterator->getPosition() !== 0) {
            throw new \InvalidArgumentException(
                'Cannot initialize a tuple iterator using an already initiated iterator.'
            );
        }

        if (($size = count($iterator)) % 2 !== 0) {
            throw new \UnexpectedValueException('Invalid response size for a tuple iterator.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getInnerIterator()
    {
        return $this->iterator;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        $this->iterator->drop(true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getValue()
    {
        $k = $this->iterator->current();
        $this->iterator->next();

        $v = $this->iterator->current();
        $this->iterator->next();

        return array($k, $v);
    }
}
