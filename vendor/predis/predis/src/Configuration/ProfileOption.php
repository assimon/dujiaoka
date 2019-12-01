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

use Predis\Profile\Factory;
use Predis\Profile\ProfileInterface;
use Predis\Profile\RedisProfile;

/**
 * Configures the server profile to be used by the client to create command
 * instances depending on the specified version of the Redis server.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ProfileOption implements OptionInterface
{
    /**
     * Sets the commands processors that need to be applied to the profile.
     *
     * @param OptionsInterface $options Client options.
     * @param ProfileInterface $profile Server profile.
     */
    protected function setProcessors(OptionsInterface $options, ProfileInterface $profile)
    {
        if (isset($options->prefix) && $profile instanceof RedisProfile) {
            // NOTE: directly using __get('prefix') is actually a workaround for
            // HHVM 2.3.0. It's correct and respects the options interface, it's
            // just ugly. We will remove this hack when HHVM will fix re-entrant
            // calls to __get() once and for all.

            $profile->setProcessor($options->__get('prefix'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filter(OptionsInterface $options, $value)
    {
        if (is_string($value)) {
            $value = Factory::get($value);
            $this->setProcessors($options, $value);
        } elseif (!$value instanceof ProfileInterface) {
            throw new \InvalidArgumentException('Invalid value for the profile option.');
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefault(OptionsInterface $options)
    {
        $profile = Factory::getDefault();
        $this->setProcessors($options, $profile);

        return $profile;
    }
}
