<?php
/*
 * This file is part of sebastian/global-state.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SebastianBergmann\GlobalState;

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\GlobalState\CodeExporter
 */
class CodeExporterTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testCanExportGlobalVariablesToCode()
    {
        $GLOBALS = ['foo' => 'bar'];

        $snapshot = new Snapshot(null, true, false, false, false, false, false, false, false, false);

        $exporter = new CodeExporter;

        $this->assertEquals(
            '$GLOBALS = [];' . PHP_EOL . '$GLOBALS[\'foo\'] = \'bar\';' . PHP_EOL,
            $exporter->globalVariables($snapshot)
        );
    }
}
