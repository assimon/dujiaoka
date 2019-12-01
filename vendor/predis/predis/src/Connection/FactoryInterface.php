<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Connection;

/**
 * Interface for classes providing a factory of connections to Redis nodes.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
interface FactoryInterface
{
    /**
     * Defines or overrides the connection class identified by a scheme prefix.
     *
     * @param string $scheme      Target connection scheme.
     * @param mixed  $initializer Fully-qualified name of a class or a callable for lazy initialization.
     */
    public function define($scheme, $initializer);

    /**
     * Undefines the connection identified by a scheme prefix.
     *
     * @param string $scheme Target connection scheme.
     */
    public function undefine($scheme);

    /**
     * Creates a new connection object.
     *
     * @param mixed $parameters Initialization parameters for the connection.
     *
     * @return NodeConnectionInterface
     */
    public function create($parameters);

    /**
     * Aggregates single connections into an aggregate connection instance.
     *
     * @param AggregateConnectionInterface $aggregate  Aggregate connection instance.
     * @param array                        $parameters List of parameters for each connection.
     */
    public function aggregate(AggregateConnectionInterface $aggregate, array $parameters);
}
