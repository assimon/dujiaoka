<?php
/*
 * This file is part of the php-code-coverage package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\CodeCoverage;

use SebastianBergmann\Version as VersionId;

class Version
{
    private static $version;

    /**
     * @return string
     */
    public static function id()
    {
        if (self::$version === null) {
            $version       = new VersionId('5.2.0', dirname(__DIR__));
            self::$version = $version->getVersion();
        }

        return self::$version;
    }
}
