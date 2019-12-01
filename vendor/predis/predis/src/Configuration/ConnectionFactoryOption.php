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

use Predis\Connection\Factory;
use Predis\Connection\FactoryInterface;

/**
 * Configures a connection factory used by the client to create new connection
 * instances for single Redis nodes.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ConnectionFactoryOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(OptionsInterface $options, $value)
    {
        if ($value instanceof FactoryInterface) {
            return $value;
        } elseif (is_array($value)) {
            $factory = $this->getDefault($options);

            foreach ($value as $scheme => $initializer) {
                $factory->define($scheme, $initializer);
            }

            return $factory;
        } else {
            throw new \InvalidArgumentException(
                'Invalid value provided for the connections option.'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        $factory = new Factory();

        if ($options->defined('parameters')) {
            $factory->setDefaultParameters($options->parameters);
        }

        return $factory;
    }
}
