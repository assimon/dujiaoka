<?php

namespace Encore\Admin\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:make {name} 
        {--model=} 
        {--title=} 
        {--stub= : Path to the custom stub file. } 
        {--namespace=} 
        {--O|output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make admin controller';

    /**
     * @var ResourceGenerator
     */
    protected $generator;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->modelExists()) {
            $this->error('Model does not exists !');

            return false;
        }

        $stub = $this->option('stub');

        if ($stub and !is_file($stub)) {
            $this->error('The stub file dose not exist.');

            return false;
        }

        $modelName = $this->option('model');

        $this->generator = new ResourceGenerator($modelName);

        if ($this->option('output')) {
            return $this->output($modelName);
        }

        if (parent::handle() !== false) {
            $name = $this->argument('name');
            $path = Str::plural(Str::kebab(class_basename($this->option('model'))));

            $this->line('');
            $this->comment('Add the following route to app/Admin/routes.php:');
            $this->line('');
            $this->info("    \$router->resource('{$path}', {$name}::class);");
            $this->line('');
        }
    }

    /**
     * @param string $modelName
     */
    protected function output($modelName)
    {
        $this->alert("laravel-admin controller code for model [{$modelName}]");

        $this->info($this->generator->generateGrid());
        $this->info($this->generator->generateShow());
        $this->info($this->generator->generateForm());
    }

    /**
     * Determine if the model is exists.
     *
     * @return bool
     */
    protected function modelExists()
    {
        $model = $this->option('model');

        if (empty($model)) {
            return true;
        }

        return class_exists($model) && is_subclass_of($model, Model::class);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace(
            [
                'DummyModelNamespace',
                'DummyTitle',
                'DummyModel',
                'DummyGrid',
                'DummyShow',
                'DummyForm',
            ],
            [
                $this->option('model'),
                $this->option('title') ?: $this->option('model'),
                class_basename($this->option('model')),
                $this->indentCodes($this->generator->generateGrid()),
                $this->indentCodes($this->generator->generateShow()),
                $this->indentCodes($this->generator->generateForm()),
            ],
            $stub
        );
    }

    /**
     * @param string $code
     *
     * @return string
     */
    protected function indentCodes($code)
    {
        $indent = str_repeat(' ', 8);

        return rtrim($indent.preg_replace("/\r\n/", "\r\n{$indent}", $code));
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($stub = $this->option('stub')) {
            return $stub;
        }

        if ($this->option('model')) {
            return __DIR__.'/stubs/controller.stub';
        }

        return __DIR__.'/stubs/blank.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($namespace = $this->option('namespace')) {
            return $namespace;
        }

        return config('admin.route.namespace');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        $this->type = $this->qualifyClass($name);

        return $name;
    }
}
