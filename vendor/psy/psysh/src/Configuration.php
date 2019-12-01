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

use Psy\Exception\DeprecatedException;
use Psy\Exception\RuntimeException;
use Psy\Output\OutputPager;
use Psy\Output\ShellOutput;
use Psy\Readline\GNUReadline;
use Psy\Readline\HoaConsole;
use Psy\Readline\Libedit;
use Psy\Readline\Readline;
use Psy\TabCompletion\AutoCompleter;
use Psy\VarDumper\Presenter;
use Psy\VersionUpdater\Checker;
use Psy\VersionUpdater\GitHubChecker;
use Psy\VersionUpdater\IntervalChecker;
use Psy\VersionUpdater\NoopChecker;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The Psy Shell configuration.
 */
class Configuration
{
    const COLOR_MODE_AUTO     = 'auto';
    const COLOR_MODE_FORCED   = 'forced';
    const COLOR_MODE_DISABLED = 'disabled';

    private static $AVAILABLE_OPTIONS = [
        'codeCleaner',
        'colorMode',
        'configDir',
        'dataDir',
        'defaultIncludes',
        'eraseDuplicates',
        'errorLoggingLevel',
        'forceArrayIndexes',
        'historySize',
        'manualDbFile',
        'pager',
        'prompt',
        'requireSemicolons',
        'runtimeDir',
        'startupMessage',
        'updateCheck',
        'useBracketedPaste',
        'usePcntl',
        'useReadline',
        'useTabCompletion',
        'useUnicode',
        'warnOnMultipleConfigs',
    ];

    private $defaultIncludes;
    private $configDir;
    private $dataDir;
    private $runtimeDir;
    private $configFile;
    /** @var string|false */
    private $historyFile;
    private $historySize;
    private $eraseDuplicates;
    private $manualDbFile;
    private $hasReadline;
    private $useReadline;
    private $useBracketedPaste;
    private $hasPcntl;
    private $usePcntl;
    private $newCommands       = [];
    private $requireSemicolons = false;
    private $useUnicode;
    private $useTabCompletion;
    private $newMatchers = [];
    private $errorLoggingLevel = E_ALL;
    private $warnOnMultipleConfigs = false;
    private $colorMode;
    private $updateCheck;
    private $startupMessage;
    private $forceArrayIndexes = false;

    // services
    private $readline;
    private $output;
    private $shell;
    private $cleaner;
    private $pager;
    private $manualDb;
    private $presenter;
    private $autoCompleter;
    private $checker;
    private $prompt;

    /**
     * Construct a Configuration instance.
     *
     * Optionally, supply an array of configuration values to load.
     *
     * @param array $config Optional array of configuration values
     */
    public function __construct(array $config = [])
    {
        $this->setColorMode(self::COLOR_MODE_AUTO);

        // explicit configFile option
        if (isset($config['configFile'])) {
            $this->configFile = $config['configFile'];
        } elseif ($configFile = \getenv('PSYSH_CONFIG')) {
            $this->configFile = $configFile;
        }

        // legacy baseDir option
        if (isset($config['baseDir'])) {
            $msg = "The 'baseDir' configuration option is deprecated; " .
                "please specify 'configDir' and 'dataDir' options instead";
            throw new DeprecatedException($msg);
        }

        unset($config['configFile'], $config['baseDir']);

        // go go gadget, config!
        $this->loadConfig($config);
        $this->init();
    }

    /**
     * Initialize the configuration.
     *
     * This checks for the presence of Readline and Pcntl extensions.
     *
     * If a config file is available, it will be loaded and merged with the current config.
     *
     * If no custom config file was specified and a local project config file
     * is available, it will be loaded and merged with the current config.
     */
    public function init()
    {
        // feature detection
        $this->hasReadline = \function_exists('readline');
        $this->hasPcntl    = \function_exists('pcntl_signal') && \function_exists('posix_getpid');

        if ($configFile = $this->getConfigFile()) {
            $this->loadConfigFile($configFile);
        }

        if (!$this->configFile && $localConfig = $this->getLocalConfigFile()) {
            $this->loadConfigFile($localConfig);
        }
    }

    /**
     * Get the current PsySH config file.
     *
     * If a `configFile` option was passed to the Configuration constructor,
     * this file will be returned. If not, all possible config directories will
     * be searched, and the first `config.php` or `rc.php` file which exists
     * will be returned.
     *
     * If you're trying to decide where to put your config file, pick
     *
     *     ~/.config/psysh/config.php
     *
     * @return string
     */
    public function getConfigFile()
    {
        if (isset($this->configFile)) {
            return $this->configFile;
        }

        $files = ConfigPaths::getConfigFiles(['config.php', 'rc.php'], $this->configDir);

        if (!empty($files)) {
            if ($this->warnOnMultipleConfigs && \count($files) > 1) {
                $msg = \sprintf('Multiple configuration files found: %s. Using %s', \implode($files, ', '), $files[0]);
                \trigger_error($msg, E_USER_NOTICE);
            }

            return $files[0];
        }
    }

    /**
     * Get the local PsySH config file.
     *
     * Searches for a project specific config file `.psysh.php` in the current
     * working directory.
     *
     * @return string
     */
    public function getLocalConfigFile()
    {
        $localConfig = \getcwd() . '/.psysh.php';

        if (@\is_file($localConfig)) {
            return $localConfig;
        }
    }

    /**
     * Load configuration values from an array of options.
     *
     * @param array $options
     */
    public function loadConfig(array $options)
    {
        foreach (self::$AVAILABLE_OPTIONS as $option) {
            if (isset($options[$option])) {
                $method = 'set' . \ucfirst($option);
                $this->$method($options[$option]);
            }
        }

        // legacy `tabCompletion` option
        if (isset($options['tabCompletion'])) {
            $msg = '`tabCompletion` is deprecated; use `useTabCompletion` instead.';
            @\trigger_error($msg, E_USER_DEPRECATED);

            $this->setUseTabCompletion($options['tabCompletion']);
        }

        foreach (['commands', 'matchers', 'casters'] as $option) {
            if (isset($options[$option])) {
                $method = 'add' . \ucfirst($option);
                $this->$method($options[$option]);
            }
        }

        // legacy `tabCompletionMatchers` option
        if (isset($options['tabCompletionMatchers'])) {
            $msg = '`tabCompletionMatchers` is deprecated; use `matchers` instead.';
            @\trigger_error($msg, E_USER_DEPRECATED);

            $this->addMatchers($options['tabCompletionMatchers']);
        }
    }

    /**
     * Load a configuration file (default: `$HOME/.config/psysh/config.php`).
     *
     * This configuration instance will be available to the config file as $config.
     * The config file may directly manipulate the configuration, or may return
     * an array of options which will be merged with the current configuration.
     *
     * @throws \InvalidArgumentException if the config file returns a non-array result
     *
     * @param string $file
     */
    public function loadConfigFile($file)
    {
        $__psysh_config_file__ = $file;
        $load = function ($config) use ($__psysh_config_file__) {
            $result = require $__psysh_config_file__;
            if ($result !== 1) {
                return $result;
            }
        };
        $result = $load($this);

        if (!empty($result)) {
            if (\is_array($result)) {
                $this->loadConfig($result);
            } else {
                throw new \InvalidArgumentException('Psy Shell configuration must return an array of options');
            }
        }
    }

    /**
     * Set files to be included by default at the start of each shell session.
     *
     * @param array $includes
     */
    public function setDefaultIncludes(array $includes = [])
    {
        $this->defaultIncludes = $includes;
    }

    /**
     * Get files to be included by default at the start of each shell session.
     *
     * @return array
     */
    public function getDefaultIncludes()
    {
        return $this->defaultIncludes ?: [];
    }

    /**
     * Set the shell's config directory location.
     *
     * @param string $dir
     */
    public function setConfigDir($dir)
    {
        $this->configDir = (string) $dir;
    }

    /**
     * Get the current configuration directory, if any is explicitly set.
     *
     * @return string
     */
    public function getConfigDir()
    {
        return $this->configDir;
    }

    /**
     * Set the shell's data directory location.
     *
     * @param string $dir
     */
    public function setDataDir($dir)
    {
        $this->dataDir = (string) $dir;
    }

    /**
     * Get the current data directory, if any is explicitly set.
     *
     * @return string
     */
    public function getDataDir()
    {
        return $this->dataDir;
    }

    /**
     * Set the shell's temporary directory location.
     *
     * @param string $dir
     */
    public function setRuntimeDir($dir)
    {
        $this->runtimeDir = (string) $dir;
    }

    /**
     * Get the shell's temporary directory location.
     *
     * Defaults to  `/psysh` inside the system's temp dir unless explicitly
     * overridden.
     *
     * @return string
     */
    public function getRuntimeDir()
    {
        if (!isset($this->runtimeDir)) {
            $this->runtimeDir = ConfigPaths::getRuntimeDir();
        }

        if (!\is_dir($this->runtimeDir)) {
            \mkdir($this->runtimeDir, 0700, true);
        }

        return $this->runtimeDir;
    }

    /**
     * Set the readline history file path.
     *
     * @param string $file
     */
    public function setHistoryFile($file)
    {
        $this->historyFile = ConfigPaths::touchFileWithMkdir($file);
    }

    /**
     * Get the readline history file path.
     *
     * Defaults to `/history` inside the shell's base config dir unless
     * explicitly overridden.
     *
     * @return string
     */
    public function getHistoryFile()
    {
        if (isset($this->historyFile)) {
            return $this->historyFile;
        }

        $files = ConfigPaths::getConfigFiles(['psysh_history', 'history'], $this->configDir);

        if (!empty($files)) {
            if ($this->warnOnMultipleConfigs && \count($files) > 1) {
                $msg = \sprintf('Multiple history files found: %s. Using %s', \implode($files, ', '), $files[0]);
                \trigger_error($msg, E_USER_NOTICE);
            }

            $this->setHistoryFile($files[0]);
        } else {
            // fallback: create our own history file
            $dir = $this->configDir ?: ConfigPaths::getCurrentConfigDir();
            $this->setHistoryFile($dir . '/psysh_history');
        }

        return $this->historyFile;
    }

    /**
     * Set the readline max history size.
     *
     * @param int $value
     */
    public function setHistorySize($value)
    {
        $this->historySize = (int) $value;
    }

    /**
     * Get the readline max history size.
     *
     * @return int
     */
    public function getHistorySize()
    {
        return $this->historySize;
    }

    /**
     * Sets whether readline erases old duplicate history entries.
     *
     * @param bool $value
     */
    public function setEraseDuplicates($value)
    {
        $this->eraseDuplicates = (bool) $value;
    }

    /**
     * Get whether readline erases old duplicate history entries.
     *
     * @return bool
     */
    public function getEraseDuplicates()
    {
        return $this->eraseDuplicates;
    }

    /**
     * Get a temporary file of type $type for process $pid.
     *
     * The file will be created inside the current temporary directory.
     *
     * @see self::getRuntimeDir
     *
     * @param string $type
     * @param int    $pid
     *
     * @return string Temporary file name
     */
    public function getTempFile($type, $pid)
    {
        return \tempnam($this->getRuntimeDir(), $type . '_' . $pid . '_');
    }

    /**
     * Get a filename suitable for a FIFO pipe of $type for process $pid.
     *
     * The pipe will be created inside the current temporary directory.
     *
     * @param string $type
     * @param int    $pid
     *
     * @return string Pipe name
     */
    public function getPipe($type, $pid)
    {
        return \sprintf('%s/%s_%s', $this->getRuntimeDir(), $type, $pid);
    }

    /**
     * Check whether this PHP instance has Readline available.
     *
     * @return bool True if Readline is available
     */
    public function hasReadline()
    {
        return $this->hasReadline;
    }

    /**
     * Enable or disable Readline usage.
     *
     * @param bool $useReadline
     */
    public function setUseReadline($useReadline)
    {
        $this->useReadline = (bool) $useReadline;
    }

    /**
     * Check whether to use Readline.
     *
     * If `setUseReadline` as been set to true, but Readline is not actually
     * available, this will return false.
     *
     * @return bool True if the current Shell should use Readline
     */
    public function useReadline()
    {
        return isset($this->useReadline) ? ($this->hasReadline && $this->useReadline) : $this->hasReadline;
    }

    /**
     * Set the Psy Shell readline service.
     *
     * @param Readline $readline
     */
    public function setReadline(Readline $readline)
    {
        $this->readline = $readline;
    }

    /**
     * Get the Psy Shell readline service.
     *
     * By default, this service uses (in order of preference):
     *
     *  * GNU Readline
     *  * Libedit
     *  * A transient array-based readline emulation.
     *
     * @return Readline
     */
    public function getReadline()
    {
        if (!isset($this->readline)) {
            $className = $this->getReadlineClass();
            $this->readline = new $className(
                $this->getHistoryFile(),
                $this->getHistorySize(),
                $this->getEraseDuplicates()
            );
        }

        return $this->readline;
    }

    /**
     * Get the appropriate Readline implementation class name.
     *
     * @see self::getReadline
     *
     * @return string
     */
    private function getReadlineClass()
    {
        if ($this->useReadline()) {
            if (GNUReadline::isSupported()) {
                return 'Psy\Readline\GNUReadline';
            } elseif (Libedit::isSupported()) {
                return 'Psy\Readline\Libedit';
            } elseif (HoaConsole::isSupported()) {
                return 'Psy\Readline\HoaConsole';
            }
        }

        return 'Psy\Readline\Transient';
    }

    /**
     * Enable or disable bracketed paste.
     *
     * Note that this only works with readline (not libedit) integration for now.
     *
     * @param bool $useBracketedPaste
     */
    public function setUseBracketedPaste($useBracketedPaste)
    {
        $this->useBracketedPaste = (bool) $useBracketedPaste;
    }

    /**
     * Check whether to use bracketed paste with readline.
     *
     * When this works, it's magical. Tabs in pastes don't try to autcomplete.
     * Newlines in paste don't execute code until you get to the end. It makes
     * readline act like you'd expect when pasting.
     *
     * But it often (usually?) does not work. And when it doesn't, it just spews
     * escape codes all over the place and generally makes things ugly :(
     *
     * If `useBracketedPaste` has been set to true, but the current readline
     * implementation is anything besides GNU readline, this will return false.
     *
     * @return bool True if the shell should use bracketed paste
     */
    public function useBracketedPaste()
    {
        // For now, only the GNU readline implementation supports bracketed paste.
        $supported = ($this->getReadlineClass() === 'Psy\Readline\GNUReadline');

        return $supported && $this->useBracketedPaste;

        // @todo mebbe turn this on by default some day?
        // return isset($this->useBracketedPaste) ? ($supported && $this->useBracketedPaste) : $supported;
    }

    /**
     * Check whether this PHP instance has Pcntl available.
     *
     * @return bool True if Pcntl is available
     */
    public function hasPcntl()
    {
        return $this->hasPcntl;
    }

    /**
     * Enable or disable Pcntl usage.
     *
     * @param bool $usePcntl
     */
    public function setUsePcntl($usePcntl)
    {
        $this->usePcntl = (bool) $usePcntl;
    }

    /**
     * Check whether to use Pcntl.
     *
     * If `setUsePcntl` has been set to true, but Pcntl is not actually
     * available, this will return false.
     *
     * @return bool True if the current Shell should use Pcntl
     */
    public function usePcntl()
    {
        return isset($this->usePcntl) ? ($this->hasPcntl && $this->usePcntl) : $this->hasPcntl;
    }

    /**
     * Enable or disable strict requirement of semicolons.
     *
     * @see self::requireSemicolons()
     *
     * @param bool $requireSemicolons
     */
    public function setRequireSemicolons($requireSemicolons)
    {
        $this->requireSemicolons = (bool) $requireSemicolons;
    }

    /**
     * Check whether to require semicolons on all statements.
     *
     * By default, PsySH will automatically insert semicolons at the end of
     * statements if they're missing. To strictly require semicolons, set
     * `requireSemicolons` to true.
     *
     * @return bool
     */
    public function requireSemicolons()
    {
        return $this->requireSemicolons;
    }

    /**
     * Enable or disable Unicode in PsySH specific output.
     *
     * Note that this does not disable Unicode output in general, it just makes
     * it so PsySH won't output any itself.
     *
     * @param bool $useUnicode
     */
    public function setUseUnicode($useUnicode)
    {
        $this->useUnicode = (bool) $useUnicode;
    }

    /**
     * Check whether to use Unicode in PsySH specific output.
     *
     * Note that this does not disable Unicode output in general, it just makes
     * it so PsySH won't output any itself.
     *
     * @return bool
     */
    public function useUnicode()
    {
        if (isset($this->useUnicode)) {
            return $this->useUnicode;
        }

        // @todo detect `chsh` != 65001 on Windows and return false
        return true;
    }

    /**
     * Set the error logging level.
     *
     * @see self::errorLoggingLevel
     *
     * @param bool $errorLoggingLevel
     */
    public function setErrorLoggingLevel($errorLoggingLevel)
    {
        $this->errorLoggingLevel = (E_ALL | E_STRICT) & $errorLoggingLevel;
    }

    /**
     * Get the current error logging level.
     *
     * By default, PsySH will automatically log all errors, regardless of the
     * current `error_reporting` level. Additionally, if the `error_reporting`
     * level warrants, an ErrorException will be thrown.
     *
     * Set `errorLoggingLevel` to 0 to prevent logging non-thrown errors. Set it
     * to any valid error_reporting value to log only errors which match that
     * level.
     *
     *     http://php.net/manual/en/function.error-reporting.php
     *
     * @return int
     */
    public function errorLoggingLevel()
    {
        return $this->errorLoggingLevel;
    }

    /**
     * Set a CodeCleaner service instance.
     *
     * @param CodeCleaner $cleaner
     */
    public function setCodeCleaner(CodeCleaner $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    /**
     * Get a CodeCleaner service instance.
     *
     * If none has been explicitly defined, this will create a new instance.
     *
     * @return CodeCleaner
     */
    public function getCodeCleaner()
    {
        if (!isset($this->cleaner)) {
            $this->cleaner = new CodeCleaner();
        }

        return $this->cleaner;
    }

    /**
     * Enable or disable tab completion.
     *
     * @param bool $useTabCompletion
     */
    public function setUseTabCompletion($useTabCompletion)
    {
        $this->useTabCompletion = (bool) $useTabCompletion;
    }

    /**
     * @deprecated Call `setUseTabCompletion` instead
     *
     * @param bool $useTabCompletion
     */
    public function setTabCompletion($useTabCompletion)
    {
        $this->setUseTabCompletion($useTabCompletion);
    }

    /**
     * Check whether to use tab completion.
     *
     * If `setUseTabCompletion` has been set to true, but readline is not
     * actually available, this will return false.
     *
     * @return bool True if the current Shell should use tab completion
     */
    public function useTabCompletion()
    {
        return isset($this->useTabCompletion) ? ($this->hasReadline && $this->useTabCompletion) : $this->hasReadline;
    }

    /**
     * @deprecated Call `useTabCompletion` instead
     *
     * @return bool
     */
    public function getTabCompletion()
    {
        return $this->useTabCompletion();
    }

    /**
     * Set the Shell Output service.
     *
     * @param ShellOutput $output
     */
    public function setOutput(ShellOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Get a Shell Output service instance.
     *
     * If none has been explicitly provided, this will create a new instance
     * with VERBOSITY_NORMAL and the output page supplied by self::getPager
     *
     * @see self::getPager
     *
     * @return ShellOutput
     */
    public function getOutput()
    {
        if (!isset($this->output)) {
            $this->output = new ShellOutput(
                OutputInterface::VERBOSITY_NORMAL,
                $this->getOutputDecorated(),
                null,
                $this->getPager()
            );
        }

        return $this->output;
    }

    /**
     * Get the decoration (i.e. color) setting for the Shell Output service.
     *
     * @return null|bool 3-state boolean corresponding to the current color mode
     */
    public function getOutputDecorated()
    {
        if ($this->colorMode() === self::COLOR_MODE_AUTO) {
            return;
        } elseif ($this->colorMode() === self::COLOR_MODE_FORCED) {
            return true;
        } elseif ($this->colorMode() === self::COLOR_MODE_DISABLED) {
            return false;
        }
    }

    /**
     * Set the OutputPager service.
     *
     * If a string is supplied, a ProcOutputPager will be used which shells out
     * to the specified command.
     *
     * @throws \InvalidArgumentException if $pager is not a string or OutputPager instance
     *
     * @param string|OutputPager $pager
     */
    public function setPager($pager)
    {
        if ($pager && !\is_string($pager) && !$pager instanceof OutputPager) {
            throw new \InvalidArgumentException('Unexpected pager instance');
        }

        $this->pager = $pager;
    }

    /**
     * Get an OutputPager instance or a command for an external Proc pager.
     *
     * If no Pager has been explicitly provided, and Pcntl is available, this
     * will default to `cli.pager` ini value, falling back to `which less`.
     *
     * @return string|OutputPager
     */
    public function getPager()
    {
        if (!isset($this->pager) && $this->usePcntl()) {
            if ($pager = \ini_get('cli.pager')) {
                // use the default pager
                $this->pager = $pager;
            } elseif ($less = \exec('which less 2>/dev/null')) {
                // check for the presence of less...
                $this->pager = $less . ' -R -S -F -X';
            }
        }

        return $this->pager;
    }

    /**
     * Set the Shell AutoCompleter service.
     *
     * @param AutoCompleter $autoCompleter
     */
    public function setAutoCompleter(AutoCompleter $autoCompleter)
    {
        $this->autoCompleter = $autoCompleter;
    }

    /**
     * Get an AutoCompleter service instance.
     *
     * @return AutoCompleter
     */
    public function getAutoCompleter()
    {
        if (!isset($this->autoCompleter)) {
            $this->autoCompleter = new AutoCompleter();
        }

        return $this->autoCompleter;
    }

    /**
     * @deprecated Nothing should be using this anymore
     *
     * @return array
     */
    public function getTabCompletionMatchers()
    {
        return [];
    }

    /**
     * Add tab completion matchers to the AutoCompleter.
     *
     * This will buffer new matchers in the event that the Shell has not yet
     * been instantiated. This allows the user to specify matchers in their
     * config rc file, despite the fact that their file is needed in the Shell
     * constructor.
     *
     * @param array $matchers
     */
    public function addMatchers(array $matchers)
    {
        $this->newMatchers = \array_merge($this->newMatchers, $matchers);
        if (isset($this->shell)) {
            $this->doAddMatchers();
        }
    }

    /**
     * Internal method for adding tab completion matchers. This will set any new
     * matchers once a Shell is available.
     */
    private function doAddMatchers()
    {
        if (!empty($this->newMatchers)) {
            $this->shell->addMatchers($this->newMatchers);
            $this->newMatchers = [];
        }
    }

    /**
     * @deprecated Use `addMatchers` instead
     *
     * @param array $matchers
     */
    public function addTabCompletionMatchers(array $matchers)
    {
        $this->addMatchers($matchers);
    }

    /**
     * Add commands to the Shell.
     *
     * This will buffer new commands in the event that the Shell has not yet
     * been instantiated. This allows the user to specify commands in their
     * config rc file, despite the fact that their file is needed in the Shell
     * constructor.
     *
     * @param array $commands
     */
    public function addCommands(array $commands)
    {
        $this->newCommands = \array_merge($this->newCommands, $commands);
        if (isset($this->shell)) {
            $this->doAddCommands();
        }
    }

    /**
     * Internal method for adding commands. This will set any new commands once
     * a Shell is available.
     */
    private function doAddCommands()
    {
        if (!empty($this->newCommands)) {
            $this->shell->addCommands($this->newCommands);
            $this->newCommands = [];
        }
    }

    /**
     * Set the Shell backreference and add any new commands to the Shell.
     *
     * @param Shell $shell
     */
    public function setShell(Shell $shell)
    {
        $this->shell = $shell;
        $this->doAddCommands();
        $this->doAddMatchers();
    }

    /**
     * Set the PHP manual database file.
     *
     * This file should be an SQLite database generated from the phpdoc source
     * with the `bin/build_manual` script.
     *
     * @param string $filename
     */
    public function setManualDbFile($filename)
    {
        $this->manualDbFile = (string) $filename;
    }

    /**
     * Get the current PHP manual database file.
     *
     * @return string Default: '~/.local/share/psysh/php_manual.sqlite'
     */
    public function getManualDbFile()
    {
        if (isset($this->manualDbFile)) {
            return $this->manualDbFile;
        }

        $files = ConfigPaths::getDataFiles(['php_manual.sqlite'], $this->dataDir);
        if (!empty($files)) {
            if ($this->warnOnMultipleConfigs && \count($files) > 1) {
                $msg = \sprintf('Multiple manual database files found: %s. Using %s', \implode($files, ', '), $files[0]);
                \trigger_error($msg, E_USER_NOTICE);
            }

            return $this->manualDbFile = $files[0];
        }
    }

    /**
     * Get a PHP manual database connection.
     *
     * @return \PDO
     */
    public function getManualDb()
    {
        if (!isset($this->manualDb)) {
            $dbFile = $this->getManualDbFile();
            if (\is_file($dbFile)) {
                try {
                    $this->manualDb = new \PDO('sqlite:' . $dbFile);
                } catch (\PDOException $e) {
                    if ($e->getMessage() === 'could not find driver') {
                        throw new RuntimeException('SQLite PDO driver not found', 0, $e);
                    } else {
                        throw $e;
                    }
                }
            }
        }

        return $this->manualDb;
    }

    /**
     * Add an array of casters definitions.
     *
     * @param array $casters
     */
    public function addCasters(array $casters)
    {
        $this->getPresenter()->addCasters($casters);
    }

    /**
     * Get the Presenter service.
     *
     * @return Presenter
     */
    public function getPresenter()
    {
        if (!isset($this->presenter)) {
            $this->presenter = new Presenter($this->getOutput()->getFormatter(), $this->forceArrayIndexes());
        }

        return $this->presenter;
    }

    /**
     * Enable or disable warnings on multiple configuration or data files.
     *
     * @see self::warnOnMultipleConfigs()
     *
     * @param bool $warnOnMultipleConfigs
     */
    public function setWarnOnMultipleConfigs($warnOnMultipleConfigs)
    {
        $this->warnOnMultipleConfigs = (bool) $warnOnMultipleConfigs;
    }

    /**
     * Check whether to warn on multiple configuration or data files.
     *
     * By default, PsySH will use the file with highest precedence, and will
     * silently ignore all others. With this enabled, a warning will be emitted
     * (but not an exception thrown) if multiple configuration or data files
     * are found.
     *
     * This will default to true in a future release, but is false for now.
     *
     * @return bool
     */
    public function warnOnMultipleConfigs()
    {
        return $this->warnOnMultipleConfigs;
    }

    /**
     * Set the current color mode.
     *
     * @param string $colorMode
     */
    public function setColorMode($colorMode)
    {
        $validColorModes = [
            self::COLOR_MODE_AUTO,
            self::COLOR_MODE_FORCED,
            self::COLOR_MODE_DISABLED,
        ];

        if (\in_array($colorMode, $validColorModes)) {
            $this->colorMode = $colorMode;
        } else {
            throw new \InvalidArgumentException('invalid color mode: ' . $colorMode);
        }
    }

    /**
     * Get the current color mode.
     *
     * @return string
     */
    public function colorMode()
    {
        return $this->colorMode;
    }

    /**
     * Set an update checker service instance.
     *
     * @param Checker $checker
     */
    public function setChecker(Checker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Get an update checker service instance.
     *
     * If none has been explicitly defined, this will create a new instance.
     *
     * @return Checker
     */
    public function getChecker()
    {
        if (!isset($this->checker)) {
            $interval = $this->getUpdateCheck();
            switch ($interval) {
                case Checker::ALWAYS:
                    $this->checker = new GitHubChecker();
                    break;

                case Checker::DAILY:
                case Checker::WEEKLY:
                case Checker::MONTHLY:
                    $checkFile = $this->getUpdateCheckCacheFile();
                    if ($checkFile === false) {
                        $this->checker = new NoopChecker();
                    } else {
                        $this->checker = new IntervalChecker($checkFile, $interval);
                    }
                    break;

                case Checker::NEVER:
                    $this->checker = new NoopChecker();
                    break;
            }
        }

        return $this->checker;
    }

    /**
     * Get the current update check interval.
     *
     * One of 'always', 'daily', 'weekly', 'monthly' or 'never'. If none is
     * explicitly set, default to 'weekly'.
     *
     * @return string
     */
    public function getUpdateCheck()
    {
        return isset($this->updateCheck) ? $this->updateCheck : Checker::WEEKLY;
    }

    /**
     * Set the update check interval.
     *
     * @throws \InvalidArgumentDescription if the update check interval is unknown
     *
     * @param string $interval
     */
    public function setUpdateCheck($interval)
    {
        $validIntervals = [
            Checker::ALWAYS,
            Checker::DAILY,
            Checker::WEEKLY,
            Checker::MONTHLY,
            Checker::NEVER,
        ];

        if (!\in_array($interval, $validIntervals)) {
            throw new \InvalidArgumentException('invalid update check interval: ' . $interval);
        }

        $this->updateCheck = $interval;
    }

    /**
     * Get a cache file path for the update checker.
     *
     * @return string|false Return false if config file/directory is not writable
     */
    public function getUpdateCheckCacheFile()
    {
        $dir = $this->configDir ?: ConfigPaths::getCurrentConfigDir();

        return ConfigPaths::touchFileWithMkdir($dir . '/update_check.json');
    }

    /**
     * Set the startup message.
     *
     * @param string $message
     */
    public function setStartupMessage($message)
    {
        $this->startupMessage = $message;
    }

    /**
     * Get the startup message.
     *
     * @return string|null
     */
    public function getStartupMessage()
    {
        return $this->startupMessage;
    }

    /**
     * Set the prompt.
     *
     * @param string $prompt
     */
    public function setPrompt($prompt)
    {
        $this->prompt = $prompt;
    }

    /**
     * Get the prompt.
     *
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * Get the force array indexes.
     *
     * @return bool
     */
    public function forceArrayIndexes()
    {
        return $this->forceArrayIndexes;
    }

    /**
     * Set the force array indexes.
     *
     * @param bool $forceArrayIndexes
     */
    public function setForceArrayIndexes($forceArrayIndexes)
    {
        $this->forceArrayIndexes = $forceArrayIndexes;
    }
}
