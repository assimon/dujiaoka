<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Formatter;

/**
 * Formatter interface.
 */
interface Formatter
{
    /**
     * @param \Reflector $reflector
     *
     * @return string
     */
    public static function format(\Reflector $reflector);
}
