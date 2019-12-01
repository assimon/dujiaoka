<?php

namespace Encore\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ExtendCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:extend {extension} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build a Laravel-admin extension';

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $package;

    /**
     * @var string
     */
    protected $extensionDir;

    /**
     * @var array
     */
    protected $dirs = [
        'database/migrations',
        'database/seeds',
        'resources/assets',
        'resources/views',
        'src/Http/Controllers',
        'routes',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        $this->extensionDir = config('admin.extension_dir');

        InputExtensionDir:
        if (empty($this->extensionDir)) {
            $this->extensionDir = $this->ask('Please input a directory to store your extension:');
        }

        if (!file_exists($this->extensionDir)) {
            $this->makeDir();
        }

        $this->package = $this->argument('extension');

        InputExtensionName:
        if (!$this->validateExtensionName($this->package)) {
            $this->package = $this->ask("[$this->package] is not a valid package name, please input a name like (<vendor>/<name>)");
            goto InputExtensionName;
        }

        $this->makeDirs();
        $this->makeFiles();

        $this->info("The extension scaffolding generated successfully. \r\n");
        $this->showTree();
    }

    /**
     * Show extension scaffolding with tree structure.
     */
    protected function showTree()
    {
        $tree = <<<TREE
{$this->extensionPath()}
    ├── LICENSE
    ├── README.md
    ├── composer.json
    ├── database
    │   ├── migrations
    │   └── seeds
    ├── resources
    │   ├── assets
    │   └── views
    │       └── index.blade.php
    ├── routes
    │   └── web.php
    └── src
        ├── {$this->className}.php
        ├── {$this->className}ServiceProvider.php
        └── Http
            └── Controllers
                └── {$this->className}Controller.php
TREE;

        $this->info($tree);
    }

    /**
     * Make extension files.
     */
    protected function makeFiles()
    {
        $this->namespace = $this->getRootNameSpace();

        $this->className = $this->getClassName();

        // copy files
        $this->copy([
            __DIR__.'/stubs/extension/view.stub'       => 'resources/views/index.blade.php',
            __DIR__.'/stubs/extension/.gitignore.stub' => '.gitignore',
            __DIR__.'/stubs/extension/README.md.stub'  => 'README.md',
            __DIR__.'/stubs/extension/LICENSE.stub'    => 'LICENSE',
        ]);

        // make composer.json
        $composerContents = str_replace(
            [':package', ':namespace', ':class_name'],
            [$this->package, str_replace('\\', '\\\\', $this->namespace).'\\\\', $this->className],
            file_get_contents(__DIR__.'/stubs/extension/composer.json.stub')
        );
        $this->putFile('composer.json', $composerContents);

        // make class
        $classContents = str_replace(
            [':namespace', ':class_name', ':title', ':path', ':base_package'],
            [$this->namespace, $this->className, Str::title($this->className), basename($this->package), basename($this->package)],
            file_get_contents(__DIR__.'/stubs/extension/extension.stub')
        );
        $this->putFile("src/{$this->className}.php", $classContents);

        // make service provider
        $providerContents = str_replace(
            [':namespace', ':class_name', ':base_package', ':package'],
            [$this->namespace, $this->className, basename($this->package), $this->package],
            file_get_contents(__DIR__.'/stubs/extension/service-provider.stub')
        );
        $this->putFile("src/{$this->className}ServiceProvider.php", $providerContents);

        // make controller
        $controllerContent = str_replace(
            [':namespace', ':class_name', ':base_package'],
            [$this->namespace, $this->className, basename($this->package)],
            file_get_contents(__DIR__.'/stubs/extension/controller.stub')
        );
        $this->putFile("src/Http/Controllers/{$this->className}Controller.php", $controllerContent);

        // make routes
        $routesContent = str_replace(
            [':namespace', ':class_name', ':path'],
            [$this->namespace, $this->className, basename($this->package)],
            file_get_contents(__DIR__.'/stubs/extension/routes.stub')
        );
        $this->putFile('routes/web.php', $routesContent);
    }

    /**
     * Get root namespace for this package.
     *
     * @return array|null|string
     */
    protected function getRootNameSpace()
    {
        if (!$namespace = $this->option('namespace')) {
            list($vendor, $name) = explode('/', $this->package);

            $default = str_replace(['-', '-'], '', Str::title($vendor).'\\'.Str::title($name));

            $namespace = $this->ask('Root namespace', $default);
        }

        return $namespace;
    }

    /**
     * Get extension class name.
     *
     * @return string
     */
    protected function getClassName()
    {
        return class_basename($this->namespace);
    }

    /**
     * Create package dirs.
     */
    protected function makeDirs()
    {
        $this->basePath = rtrim($this->extensionDir, '/').'/'.ltrim($this->package, '/');

        $this->makeDir($this->dirs);
    }

    /**
     * Validate extension name.
     *
     * @param string $name
     *
     * @return int
     */
    protected function validateExtensionName($name)
    {
        return preg_match('/^[\w\-_]+\/[\w\-_]+$/', $name);
    }

    /**
     * Extension path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function extensionPath($path = '')
    {
        $path = rtrim($path, '/');

        if (empty($path)) {
            return rtrim($this->basePath, '/');
        }

        return rtrim($this->basePath, '/').'/'.ltrim($path, '/');
    }

    /**
     * Put contents to file.
     *
     * @param string $to
     * @param string $content
     */
    protected function putFile($to, $content)
    {
        $to = $this->extensionPath($to);

        $this->filesystem->put($to, $content);
    }

    /**
     * Copy files to extension path.
     *
     * @param string|array $from
     * @param string|null  $to
     */
    protected function copy($from, $to = null)
    {
        if (is_array($from) && is_null($to)) {
            foreach ($from as $key => $value) {
                $this->copy($key, $value);
            }

            return;
        }

        if (!file_exists($from)) {
            return;
        }

        $to = $this->extensionPath($to);

        $this->filesystem->copy($from, $to);
    }

    /**
     * Make new directory.
     *
     * @param array|string $paths
     */
    protected function makeDir($paths = '')
    {
        foreach ((array) $paths as $path) {
            $path = $this->extensionPath($path);

            $this->filesystem->makeDirectory($path, 0755, true, true);
        }
    }
}
