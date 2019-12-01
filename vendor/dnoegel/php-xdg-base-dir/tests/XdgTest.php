<?php

class XdgTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \XdgBaseDir\Xdg
     */
    public function getXdg()
    {
        return new \XdgBaseDir\Xdg();
    }

    public function testGetHomeDir()
    {
         putenv('HOME=/fake-dir');
         $this->assertEquals('/fake-dir', $this->getXdg()->getHomeDir());
    }

    public function testGetFallbackHomeDir()
    {
        putenv('HOME=');
        putenv('HOMEDRIVE=C:');
        putenv('HOMEPATH=fake-dir');
        $this->assertEquals('C:/fake-dir', $this->getXdg()->getHomeDir());
    }

    public function testXdgPutCache()
    {
        putenv('XDG_DATA_HOME=tmp/');
        putenv('XDG_CONFIG_HOME=tmp/');
        putenv('XDG_CACHE_HOME=tmp/');
        $this->assertEquals('tmp/', $this->getXdg()->getHomeCacheDir());
    }

    public function testXdgPutData()
    {
        putenv('XDG_DATA_HOME=tmp/');
        $this->assertEquals('tmp/', $this->getXdg()->getHomeDataDir());
    }

    public function testXdgPutConfig()
    {
        putenv('XDG_CONFIG_HOME=tmp/');
        $this->assertEquals('tmp/', $this->getXdg()->getHomeConfigDir());
    }

    public function testXdgDataDirsShouldIncludeHomeDataDir()
    {
        putenv('XDG_DATA_HOME=tmp/');
        putenv('XDG_CONFIG_HOME=tmp/');

        $this->assertArrayHasKey('tmp/', array_flip($this->getXdg()->getDataDirs()));
    }

    public function testXdgConfigDirsShouldIncludeHomeConfigDir()
    {
        putenv('XDG_CONFIG_HOME=tmp/');

        $this->assertArrayHasKey('tmp/', array_flip($this->getXdg()->getConfigDirs()));
    }

    /**
     * If XDG_RUNTIME_DIR is set, it should be returned
     */
    public function testGetRuntimeDir()
    {
        putenv('XDG_RUNTIME_DIR=/tmp/');
        $runtimeDir = $this->getXdg()->getRuntimeDir();

        $this->assertEquals(is_dir($runtimeDir), true);
    }

    /**
     * In strict mode, an exception should be shown if XDG_RUNTIME_DIR does not exist
     *
     * @expectedException \RuntimeException
     */
    public function testGetRuntimeDirShouldThrowException()
    {
        putenv('XDG_RUNTIME_DIR=');
        $this->getXdg()->getRuntimeDir(true);
    }

    /**
     * In fallback mode a directory should be created
     */
    public function testGetRuntimeDirShouldCreateDirectory()
    {
        putenv('XDG_RUNTIME_DIR=');
        $dir = $this->getXdg()->getRuntimeDir(false);
        $permission = decoct(fileperms($dir) & 0777);
        $this->assertEquals(700, $permission);
    }

    /**
     * Ensure, that the fallback directories are created with correct permission
     */
    public function testGetRuntimeShouldDeleteDirsWithWrongPermission()
    {
        $runtimeDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . XdgBaseDir\Xdg::RUNTIME_DIR_FALLBACK . getenv('USER');

        rmdir($runtimeDir);
        mkdir($runtimeDir, 0764, true);

        // Permission should be wrong now
        $permission = decoct(fileperms($runtimeDir) & 0777);
        $this->assertEquals(764, $permission);

        putenv('XDG_RUNTIME_DIR=');
        $dir = $this->getXdg()->getRuntimeDir(false);

        // Permission should be fixed
        $permission = decoct(fileperms($dir) & 0777);
        $this->assertEquals(700, $permission);
    }
}
