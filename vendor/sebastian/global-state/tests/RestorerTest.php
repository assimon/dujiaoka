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
 * Class Restorer.
 */
class RestorerTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        $GLOBALS['varBool'] = false;
        $GLOBALS['varNull'] = null;
        $_GET['varGet']     = 0;
    }

    /**
     * Check global variables are correctly backuped and restored (unit test).
     *
     * @covers \SebastianBergmann\GlobalState\Restorer::restoreGlobalVariables
     * @covers \SebastianBergmann\GlobalState\Restorer::restoreSuperGlobalArray
     *
     * @uses \SebastianBergmann\GlobalState\Blacklist::isGlobalVariableBlacklisted
     * @uses \SebastianBergmann\GlobalState\Snapshot::__construct
     * @uses \SebastianBergmann\GlobalState\Snapshot::blacklist
     * @uses \SebastianBergmann\GlobalState\Snapshot::canBeSerialized
     * @uses \SebastianBergmann\GlobalState\Snapshot::globalVariables
     * @uses \SebastianBergmann\GlobalState\Snapshot::setupSuperGlobalArrays
     * @uses \SebastianBergmann\GlobalState\Snapshot::snapshotGlobals
     * @uses \SebastianBergmann\GlobalState\Snapshot::snapshotSuperGlobalArray
     * @uses \SebastianBergmann\GlobalState\Snapshot::superGlobalArrays
     * @uses \SebastianBergmann\GlobalState\Snapshot::superGlobalVariables
     */
    public function testRestorerGlobalVariable()
    {
        $snapshot = new Snapshot(null, true, false, false, false, false, false, false, false, false);
        $restorer = new Restorer;
        $restorer->restoreGlobalVariables($snapshot);

        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }

    /**
     * Check global variables are correctly backuped and restored.
     *
     * The real test is the second, but the first has to be executed to backup the globals.
     *
     * @backupGlobals enabled
     * @covers \SebastianBergmann\GlobalState\Restorer::restoreGlobalVariables
     * @covers \SebastianBergmann\GlobalState\Restorer::restoreSuperGlobalArray
     *
     * @uses \SebastianBergmann\GlobalState\Blacklist::addClassNamePrefix
     * @uses \SebastianBergmann\GlobalState\Blacklist::isGlobalVariableBlacklisted
     * @uses \SebastianBergmann\GlobalState\Snapshot::__construct
     * @uses \SebastianBergmann\GlobalState\Snapshot::blacklist
     * @uses \SebastianBergmann\GlobalState\Snapshot::canBeSerialized
     * @uses \SebastianBergmann\GlobalState\Snapshot::globalVariables
     * @uses \SebastianBergmann\GlobalState\Snapshot::setupSuperGlobalArrays
     * @uses \SebastianBergmann\GlobalState\Snapshot::snapshotGlobals
     * @uses \SebastianBergmann\GlobalState\Snapshot::snapshotSuperGlobalArray
     * @uses \SebastianBergmann\GlobalState\Snapshot::superGlobalArrays
     * @uses \SebastianBergmann\GlobalState\Snapshot::superGlobalVariables
     */
    public function testIntegrationRestorerGlobalVariables()
    {
        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }

    /**
     * Check global variables are correctly backuped and restored.
     *
     * @depends testIntegrationRestorerGlobalVariables
     */
    public function testIntegrationRestorerGlobalVariables2()
    {
        $this->assertArrayHasKey('varBool', $GLOBALS);
        $this->assertEquals(false, $GLOBALS['varBool']);
        $this->assertArrayHasKey('varNull', $GLOBALS);
        $this->assertEquals(null, $GLOBALS['varNull']);
        $this->assertArrayHasKey('varGet', $_GET);
        $this->assertEquals(0, $_GET['varGet']);
    }
}
