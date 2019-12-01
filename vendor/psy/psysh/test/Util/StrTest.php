<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Util;

use Psy\Util\Str;

class StrTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider unvisProvider
     */
    public function testUnvis($input, $expected)
    {
        $this->assertSame($expected, Str::unvis($input));
    }

    public function unvisProvider()
    {
        //return require_once(__DIR__.'/../fixtures/unvis_fixtures.php');
        return \json_decode(\file_get_contents(__DIR__ . '/../fixtures/unvis_fixtures.json'));
    }
}
