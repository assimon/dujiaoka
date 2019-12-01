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

use ArrayObject;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\GlobalState\TestFixture\BlacklistedInterface;
use SebastianBergmann\GlobalState\TestFixture\SnapshotClass;
use SebastianBergmann\GlobalState\TestFixture\SnapshotTrait;

/**
 * @covers \SebastianBergmann\GlobalState\Snapshot
 */
class SnapshotTest extends TestCase
{
    /**
     * @var Blacklist
     */
    private $blacklist;

    protected function setUp()
    {
        $this->blacklist = $this->createMock(Blacklist::class);
    }

    public function testStaticAttributes()
    {
        $this->blacklist->method('isStaticAttributeBlacklisted')->willReturnCallback(
            function ($class) {
                return $class !== SnapshotClass::class;
            }
        );

        SnapshotClass::init();

        $snapshot = new Snapshot($this->blacklist, false, true, false, false, false, false, false, false, false);

        $expected = [
            SnapshotClass::class => [
                'string'      => 'snapshot',
                'arrayObject' => new ArrayObject([1, 2, 3]),
                'stdClass'    => new \stdClass(),
            ]
        ];

        $this->assertEquals($expected, $snapshot->staticAttributes());
    }

    public function testConstants()
    {
        $snapshot = new Snapshot($this->blacklist, false, false, true, false, false, false, false, false, false);

        $this->assertArrayHasKey('GLOBALSTATE_TESTSUITE', $snapshot->constants());
    }

    public function testFunctions()
    {
        $snapshot  = new Snapshot($this->blacklist, false, false, false, true, false, false, false, false, false);
        $functions = $snapshot->functions();

        $this->assertContains('sebastianbergmann\globalstate\testfixture\snapshotfunction', $functions);
        $this->assertNotContains('assert', $functions);
    }

    public function testClasses()
    {
        $snapshot = new Snapshot($this->blacklist, false, false, false, false, true, false, false, false, false);
        $classes  = $snapshot->classes();

        $this->assertContains(TestCase::class, $classes);
        $this->assertNotContains(Exception::class, $classes);
    }

    public function testInterfaces()
    {
        $snapshot   = new Snapshot($this->blacklist, false, false, false, false, false, true, false, false, false);
        $interfaces = $snapshot->interfaces();

        $this->assertContains(BlacklistedInterface::class, $interfaces);
        $this->assertNotContains(\Countable::class, $interfaces);
    }

    public function testTraits()
    {
        \spl_autoload_call('SebastianBergmann\GlobalState\TestFixture\SnapshotTrait');

        $snapshot = new Snapshot($this->blacklist, false, false, false, false, false, false, true, false, false);

        $this->assertContains(SnapshotTrait::class, $snapshot->traits());
    }

    public function testIniSettings()
    {
        $snapshot    = new Snapshot($this->blacklist, false, false, false, false, false, false, false, true, false);
        $iniSettings = $snapshot->iniSettings();

        $this->assertArrayHasKey('date.timezone', $iniSettings);
        $this->assertEquals('Etc/UTC', $iniSettings['date.timezone']);
    }

    public function testIncludedFiles()
    {
        $snapshot = new Snapshot($this->blacklist, false, false, false, false, false, false, false, false, true);
        $this->assertContains(__FILE__, $snapshot->includedFiles());
    }
}
