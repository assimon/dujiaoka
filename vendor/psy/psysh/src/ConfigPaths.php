<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy;

use XdgBaseDir\Xdg;

/**
 * A Psy Shell configuration path helper.
 */
class ConfigPaths
{
    /**
     * Get potential config directory paths.
     *
     * Returns `~/.psysh`, `%APPDATA%/PsySH` (when on Windows), and all
     * XDG Base Directory config directories:
     *
     *     http://standards.freedesktop.org/basedir-spec/basedir-spec-latest.html
     *
     * @return string[]
     */
    public static function getConfigDirs()
    {
        $xdg = new Xdg();

        return self::getDirNames($xdg->getConfigDirs());
    }

    /**
     * Get potential home config directory paths.
     *
     * Returns `~/.psysh`, `%APPDATA%/PsySH` (when on Windows), and the
     * XDG Base Directory home config directory:
     *
     *     http://standards.freedesktop.org/basedir-spec/basedir-spec-latest.html
     *
     * @return string[]
     */
    public static function getHomeConfigDirs()
    {
        $xdg = new Xdg();

        return self::getDirNames([$xdg->getHomeConfigDir()]);
    }

    /**
     * Get the current home config directory.
     *
     * Returns the highest precedence home config directory which actually
     * exists. If none of them exists, returns the highest precedence home
     * config directory (`%APPDATA%/PsySH` on Windows, `~/.config/psysh`
     * everywhere else).
     *
     * @see self::getHomeConfigDirs
     *
     * @return string
     */
    public static function getCurrentConfigDir()
    {
        $configDirs = self::getHomeConfigDirs();
        foreach ($configDirs as $configDir) {
            if (@\is_dir($configDir)) {
                return $configDir;
            }
        }

        return $configDirs[0];
    }

    /**
     * Find real config files in config directories.
     *
     * @param string[] $names     Config file names
     * @param string   $configDir Optionally use a specific config directory
     *
     * @return string[]
     */
    public static function getConfigFiles(array $names, $configDir = null)
    {
        $dirs = ($configDir === null) ? self::getConfigDirs() : [$configDir];

        return self::getRealFiles($dirs, $names);
    }

    /**
     * Get potential data directory paths.
     *
     * If a `dataDir` option was explicitly set, returns an array containing
     * just that directory.
     *
     * Otherwise, it returns `~/.psysh` and all XDG Base Directory data directories:
     *
     *     http://standards.freedesktop.org/basedir-spec/basedir-spec-latest.html
     *
     * @return string[]
     */
    public static function getDataDirs()
    {
        $xdg = new Xdg();

        return self::getDirNames($xdg->getDataDirs());
    }

    /**
     * Find real data files in config directories.
     *
     * @param string[] $names   Config file names
     * @param string   $dataDir Optionally use a specific config directory
     *
     * @return string[]
     */
    public static function getDataFiles(array $names, $dataDir = null)
    {
        $dirs = ($dataDir === null) ? self::getDataDirs() : [$dataDir];

        return self::getRealFiles($dirs, $names);
    }

    /**
     * Get a runtime directory.
     *
     * Defaults to  `/psysh` inside the system's temp dir.
     *
     * @return string
     */
    public static function getRuntimeDir()
    {
        $xdg = new Xdg();

        \set_error_handler(['Psy\Exception\ErrorException', 'throwException']);

        try {
            // XDG doesn't really work on Windows, sometimes complains about
            // permissions, sometimes tries to remove non-empty directories.
            // It's a bit flaky. So we'll give this a shot first...
            $runtimeDir = $xdg->getRuntimeDir(false);
        } catch (\Exception $e) {
            // Well. That didn't work. Fall back to a boring old folder in the
            // system temp dir.
            $runtimeDir = \sys_get_temp_dir();
        }

        \restore_error_handler();

        return \strtr($runtimeDir, '\\', '/') . '/psysh';
    }

    private static function getDirNames(array $baseDirs)
    {
        $dirs = \array_map(function ($dir) {
            return \strtr($dir, '\\', '/') . '/psysh';
        }, $baseDirs);

        // Add ~/.psysh
        if ($home = \getenv('HOME')) {
            $dirs[] = \strtr($home, '\\', '/') . '/.psysh';
        }

        // Add some Windows specific ones :)
        if (\defined('PHP_WINDOWS_VERSION_MAJOR')) {
            if ($appData = \getenv('APPDATA')) {
                // AppData gets preference
                \array_unshift($dirs, \strtr($appData, '\\', '/') . '/PsySH');
            }

            $dir = \strtr(\getenv('HOMEDRIVE') . '/' . \getenv('HOMEPATH'), '\\', '/') . '/.psysh';
            if (!\in_array($dir, $dirs)) {
                $dirs[] = $dir;
            }
        }

        return $dirs;
    }

    private static function getRealFiles(array $dirNames, array $fileNames)
    {
        $files = [];
        foreach ($dirNames as $dir) {
            foreach ($fileNames as $name) {
                $file = $dir . '/' . $name;
                if (@\is_file($file)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    /**
     * Ensure that $file exists and is writable, make the parent directory if necessary.
     *
     * Generates E_USER_NOTICE error if either $file or its directory is not writable.
     *
     * @param string $file
     *
     * @return string|false Full path to $file, or false if file is not writable
     */
    public static function touchFileWithMkdir($file)
    {
        if (\file_exists($file)) {
            if (\is_writable($file)) {
                return $file;
            }

            \trigger_error(\sprintf('Writing to %s is not allowed.', $file), E_USER_NOTICE);

            return false;
        }

        $dir = \dirname($file);

        if (!\is_dir($dir)) {
            // Just try making it and see if it works
            @\mkdir($dir, 0700, true);
        }

        if (!\is_dir($dir) || !\is_writable($dir)) {
            \trigger_error(\sprintf('Writing to %s is not allowed.', $dir), E_USER_NOTICE);

            return false;
        }

        \touch($file);

        return $file;
    }
}
