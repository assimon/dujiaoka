<?php

namespace Encore\Admin\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ActionCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:action {name}
        {--grid-batch}
        {--grid-row}
        {--form}
        {--dialog}
        {--name=}
        {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a admin action';

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
                'DummyName',
                'DummySelector',
                'DummyInteractor',
            ],
            [
                $this->option('name'),
                Str::kebab(class_basename($this->argument('name'))),
                $this->generateInteractor(),
            ],
            $stub
        );
    }

    protected function generateInteractor()
    {
        if ($this->option('form')) {
            return <<<'CODE'

    public function form()
    {
        $this->text('name')->rules('required');
        $this->email('email')->rules('email');
        $this->datetime('created_at');
    }

CODE;
        } elseif ($this->option('dialog')) {
            return <<<'CODE'

    public function dialog()
    {
        $this->confirm('Confirm message...');
    }

CODE;
        }

        return '';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        if ($this->option('grid-batch')) {
            return __DIR__.'/stubs/grid-batch-action.stub';
        }

        if ($this->option('grid-row')) {
            return __DIR__.'/stubs/grid-row-action.stub';
        }

        return __DIR__.'/stubs/action.stub';
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

        $segments = explode('\\', config('admin.route.namespace'));

        array_pop($segments);

        array_push($segments, 'Actions');

        return implode('\\', $segments);
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
