<?php

namespace Laravel\Tinker;

use Psy\Shell;
use Illuminate\Support\Str;

class ClassAliasAutoloader
{
    /**
     * The shell instance.
     *
     * @var \Psy\Shell
     */
    protected $shell;

    /**
     * All of the discovered classes.
     *
     * @var array
     */
    protected $classes = [];

    /**
     * Register a new alias loader instance.
     *
     * @param  \Psy\Shell  $shell
     * @param  string  $classMapPath
     * @return static
     */
    public static function register(Shell $shell, $classMapPath)
    {
        return tap(new static($shell, $classMapPath), function ($loader) {
            spl_autoload_register([$loader, 'aliasClass']);
        });
    }

    /**
     * Create a new alias loader instance.
     *
     * @param  \Psy\Shell  $shell
     * @param  string  $classMapPath
     * @return void
     */
    public function __construct(Shell $shell, $classMapPath)
    {
        $this->shell = $shell;

        $vendorPath = dirname(dirname($classMapPath));

        $classes = require $classMapPath;

        $excludedAliases = collect(config('tinker.dont_alias', []));

        foreach ($classes as $class => $path) {
            if (! Str::contains($class, '\\') || Str::startsWith($path, $vendorPath)) {
                continue;
            }

            if (! $excludedAliases->filter(function ($alias) use ($class) {
                return Str::startsWith($class, $alias);
            })->isEmpty()) {
                continue;
            }

            $name = class_basename($class);

            if (! isset($this->classes[$name])) {
                $this->classes[$name] = $class;
            }
        }
    }

    /**
     * Find the closest class by name.
     *
     * @param  string  $class
     * @return void
     */
    public function aliasClass($class)
    {
        if (Str::contains($class, '\\')) {
            return;
        }

        $fullName = isset($this->classes[$class])
            ? $this->classes[$class]
            : false;

        if ($fullName) {
            $this->shell->writeStdout("[!] Aliasing '{$class}' to '{$fullName}' for this Tinker session.\n");

            class_alias($fullName, $class);
        }
    }

    /**
     * Unregister the alias loader instance.
     *
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'aliasClass']);
    }

    /**
     * Handle the destruction of the instance.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->unregister();
    }
}
