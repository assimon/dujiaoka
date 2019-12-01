<?php

namespace Encore\Admin\Console;

use Illuminate\Console\GeneratorCommand;

class FormCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:form {name} 
        {--title=}
        {--step}
        {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make admin form widget';

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

        return str_replace('DummyTitle', $this->option('title'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('step')) {
            return __DIR__.'/stubs/step-form.stub';
        }

        return __DIR__.'/stubs/form.stub';
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

        return str_replace('Controllers', 'Forms', config('admin.route.namespace'));
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
