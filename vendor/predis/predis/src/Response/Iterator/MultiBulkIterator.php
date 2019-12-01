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

use Predis\Response\ResponseInterface;

/**
 * Iterator that abstracts the access to multibulk responses allowing them to be
 * consumed in a streamable fashion without keeping the whole payload in memory.
 *
 * This iterator does not support rewinding which means that the iteration, once
 * consumed, cannot be restarted.
 *
 * Always make sure that the whole iteration is consumed (or dropped) to prevent
 * protocol desynchronization issues.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class MultiBulkIterator implements \Iterator, \Countable, ResponseInterface
{
    protected $current;
    protected $position;
    protected $size;

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        // NOOP
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if (++$this->position < $this->size) {
            $this->current = $this->getValue();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->position < $this->size;
    }

    /**
     * Returns the number of items comprising the whole multibulk response.
     *
     * This method should be used instead of iterator_count() to get the size of
     * the current multibulk response since the former consumes the iteration to
     * count the number of elements, but our iterators do not support rewinding.
     *
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * Returns the current position of the iterator.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    abstract protected function getValue();
}
