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

use Psy\VersionUpdater\GitHubChecker;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use XdgBaseDir\Xdg;

if (!\function_exists('Psy\sh')) {
    /**
     * Command to return the eval-able code to startup PsySH.
     *
     *     eval(\Psy\sh());
     *
     * @return string
     */
    function sh()
    {
        return 'extract(\Psy\debug(get_defined_vars(), isset($this) ? $this : @get_called_class()));';
    }
}

if (!\function_exists('Psy\debug')) {
    /**
     * Invoke a Psy Shell from the current context.
     *
     * For example:
     *
     *     foreach ($items as $item) {
     *         \Psy\debug(get_defined_vars());
     *     }
     *
     * If you would like your shell interaction to affect the state of the
     * current context, you can extract() the values returned from this call:
     *
     *     foreach ($items as $item) {
     *         extract(\Psy\debug(get_defined_vars()));
     *         var_dump($item); // will be whatever you set $item to in Psy Shell
     *     }
     *
     * Optionally, supply an object as the `$bindTo` parameter. This determines
     * the value `$this` will have in the shell, and sets up class scope so that
     * private and protected members are accessible:
     *
     *     class Foo {
     *         function bar() {
     *             \Psy\debug(get_defined_vars(), $this);
     *         }
     *     }
     *
     * For the static equivalent, pass a class name as the `$bindTo` parameter.
     * This makes `self` work in the shell, and sets up static scope so that
     * private and protected static members are accessible:
     *
     *     class Foo {
     *         static function bar() {
     *             \Psy\debug(get_defined_vars(), get_called_class());
     *         }
     *     }
     *
     * @param array         $vars   Scope variables from the calling context (default: array())
     * @param object|string $bindTo Bound object ($this) or class (self) value for the shell
     *
     * @return array Scope variables from the debugger session
     */
    function debug(array $vars = [], $bindTo = null)
    {
        echo PHP_EOL;

        $sh = new Shell();
        $sh->setScopeVariables($vars);

        // Show a couple of lines of call context for the debug session.
        //
        // @todo come up with a better way of doing this which doesn't involve injecting input :-P
        if ($sh->has('whereami')) {
            $sh->addInput('whereami -n2', true);
        }

        if (\is_string($bindTo)) {
            $sh->setBoundClass($bindTo);
        } elseif ($bindTo !== null) {
            $sh->setBoundObject($bindTo);
        }

        $sh->run();

        return $sh->getScopeVariables(false);
    }
}

if (!\function_exists('Psy\info')) {
    /**
     * Get a bunch of debugging info about the current PsySH environment and
     * configuration.
     *
     * If a Configuration param is passed, that configuration is stored and
     * used for the current shell session, and no debugging info is returned.
     *
     * @param Configuration|null $config
     *
     * @return array|null
     */
    function info(Configuration $config = null)
    {
        static $lastConfig;
        if ($config !== null) {
            $lastConfig = $config;

            return;
        }

        $xdg = new Xdg();
        $home = \rtrim(\str_replace('\\', '/', $xdg->getHomeDir()), '/');
        $homePattern = '#^' . \preg_quote($home, '#') . '/#';

        $prettyPath = function ($path) use ($homePattern) {
            if (\is_string($path)) {
                return \preg_replace($homePattern, '~/', $path);
            } else {
                return $path;
            }
        };

        $config = $lastConfig ?: new Configuration();

        $core = [
            'PsySH version'       => Shell::VERSION,
            'PHP version'         => PHP_VERSION,
            'OS'                  => PHP_OS,
            'default includes'    => $config->getDefaultIncludes(),
            'require semicolons'  => $config->requireSemicolons(),
            'error logging level' => $config->errorLoggingLevel(),
            'config file'         => [
                'default config file' => $prettyPath($config->getConfigFile()),
                'local config file'   => $prettyPath($config->getLocalConfigFile()),
                'PSYSH_CONFIG env'    => $prettyPath(\getenv('PSYSH_CONFIG')),
            ],
            // 'config dir'  => $config->getConfigDir(),
            // 'data dir'    => $config->getDataDir(),
            // 'runtime dir' => $config->getRuntimeDir(),
        ];

        // Use an explicit, fresh update check here, rather than relying on whatever is in $config.
        $checker = new GitHubChecker();
        $updateAvailable = null;
        $latest = null;
        try {
            $updateAvailable = !$checker->isLatest();
            $latest = $checker->getLatest();
        } catch (\Exception $e) {
        }

        $updates = [
            'update available'       => $updateAvailable,
            'latest release version' => $latest,
            'update check interval'  => $config->getUpdateCheck(),
            'update cache file'      => $prettyPath($config->getUpdateCheckCacheFile()),
        ];

        if ($config->hasReadline()) {
            $info = \readline_info();

            $readline = [
                'readline available' => true,
                'readline enabled'   => $config->useReadline(),
                'readline service'   => \get_class($config->getReadline()),
            ];

            if (isset($info['library_version'])) {
                $readline['readline library'] = $info['library_version'];
            }

            if (isset($info['readline_name']) && $info['readline_name'] !== '') {
                $readline['readline name'] = $info['readline_name'];
            }
        } else {
            $readline = [
                'readline available' => false,
            ];
        }

        $pcntl = [
            'pcntl available' => \function_exists('pcntl_signal'),
            'posix available' => \function_exists('posix_getpid'),
        ];

        $disabledFuncs = \array_map('trim', \explode(',', \ini_get('disable_functions')));
        if (\in_array('pcntl_signal', $disabledFuncs) || \in_array('pcntl_fork', $disabledFuncs)) {
            $pcntl['pcntl disabled'] = true;
        }

        $history = [
            'history file'     => $prettyPath($config->getHistoryFile()),
            'history size'     => $config->getHistorySize(),
            'erase duplicates' => $config->getEraseDuplicates(),
        ];

        $docs = [
            'manual db file'   => $prettyPath($config->getManualDbFile()),
            'sqlite available' => true,
        ];

        try {
            if ($db = $config->getManualDb()) {
                if ($q = $db->query('SELECT * FROM meta;')) {
                    $q->setFetchMode(\PDO::FETCH_KEY_PAIR);
                    $meta = $q->fetchAll();

                    foreach ($meta as $key => $val) {
                        switch ($key) {
                            case 'built_at':
                                $d = new \DateTime('@' . $val);
                                $val = $d->format(\DateTime::RFC2822);
                                break;
                        }
                        $key = 'db ' . \str_replace('_', ' ', $key);
                        $docs[$key] = $val;
                    }
                } else {
                    $docs['db schema'] = '0.1.0';
                }
            }
        } catch (Exception\RuntimeException $e) {
            if ($e->getMessage() === 'SQLite PDO driver not found') {
                $docs['sqlite available'] = false;
            } else {
                throw $e;
            }
        }

        $autocomplete = [
            'tab completion enabled' => $config->useTabCompletion(),
            'custom matchers'        => \array_map('get_class', $config->getTabCompletionMatchers()),
            'bracketed paste'        => $config->useBracketedPaste(),
        ];

        // Shenanigans, but totally justified.
        if ($shell = Sudo::fetchProperty($config, 'shell')) {
            $core['loop listeners'] = \array_map('get_class', Sudo::fetchProperty($shell, 'loopListeners'));
            $core['commands']       = \array_map('get_class', $shell->all());

            $autocomplete['custom matchers'] = \array_map('get_class', Sudo::fetchProperty($shell, 'matchers'));
        }

        // @todo Show Presenter / custom casters.

        return \array_merge($core, \compact('updates', 'pcntl', 'readline', 'history', 'docs', 'autocomplete'));
    }
}

if (!\function_exists('Psy\bin')) {
    /**
     * `psysh` command line executable.
     *
     * @return \Closure
     */
    function bin()
    {
        return function () {
            $usageException = null;

            $input = new ArgvInput();
            try {
                $input->bind(new InputDefinition([
                    new InputOption('help',     'h',  InputOption::VALUE_NONE),
                    new InputOption('config',   'c',  InputOption::VALUE_REQUIRED),
                    new InputOption('version',  'v',  InputOption::VALUE_NONE),
                    new InputOption('cwd',      null, InputOption::VALUE_REQUIRED),
                    new InputOption('color',    null, InputOption::VALUE_NONE),
                    new InputOption('no-color', null, InputOption::VALUE_NONE),

                    new InputArgument('include', InputArgument::IS_ARRAY),
                ]));
            } catch (\RuntimeException $e) {
                $usageException = $e;
            }

            $config = [];

            // Handle --config
            if ($configFile = $input->getOption('config')) {
                $config['configFile'] = $configFile;
            }

            // Handle --color and --no-color
            if ($input->getOption('color') && $input->getOption('no-color')) {
                $usageException = new \RuntimeException('Using both "--color" and "--no-color" options is invalid');
            } elseif ($input->getOption('color')) {
                $config['colorMode'] = Configuration::COLOR_MODE_FORCED;
            } elseif ($input->getOption('no-color')) {
                $config['colorMode'] = Configuration::COLOR_MODE_DISABLED;
            }

            $shell = new Shell(new Configuration($config));

            // Handle --help
            if ($usageException !== null || $input->getOption('help')) {
                if ($usageException !== null) {
                    echo $usageException->getMessage() . PHP_EOL . PHP_EOL;
                }

                $version = $shell->getVersion();
                $name    = \basename(\reset($_SERVER['argv']));
                echo <<<EOL
$version

Usage:
  $name [--version] [--help] [files...]

Options:
  --help     -h Display this help message.
  --config   -c Use an alternate PsySH config file location.
  --cwd         Use an alternate working directory.
  --version  -v Display the PsySH version.
  --color       Force colors in output.
  --no-color    Disable colors in output.

EOL;
                exit($usageException === null ? 0 : 1);
            }

            // Handle --version
            if ($input->getOption('version')) {
                echo $shell->getVersion() . PHP_EOL;
                exit(0);
            }

            // Pass additional arguments to Shell as 'includes'
            $shell->setIncludes($input->getArgument('include'));

            try {
                // And go!
                $shell->run();
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;

                // @todo this triggers the "exited unexpectedly" logic in the
                // ForkingLoop, so we can't exit(1) after starting the shell...
                // fix this :)

                // exit(1);
            }
        };
    }
}
