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

use Predis\Command\Processor\KeyPrefixProcessor;
use Predis\Command\Processor\ProcessorInterface;

/**
 * Configures a command processor that apply the specified prefix string to a
 * series of Redis commands considered prefixable.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class PrefixOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(OptionsInterface $options, $value)
    {
        if ($value instanceof ProcessorInterface) {
            return $value;
        }

        return new KeyPrefixProcessor($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        // NOOP
    }
}
