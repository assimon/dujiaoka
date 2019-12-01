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
 * Configures whether consumers (such as the client) should throw exceptions on
 * Redis errors (-ERR responses) or just return instances of error responses.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ExceptionsOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(OptionsInterface $options, $value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        return true;
    }
}
