<?php

namespace Laravel\Tinker\Console;

use Psy\Shell;
use Psy\Configuration;
use Illuminate\Console\Command;
use Laravel\Tinker\ClassAliasAutoloader;
use Symfony\Component\Console\Input\InputArgument;

class TinkerCommand extends Command
{
    /**
     * Artisan commands to include in the tinker shell.
     *
     * @var array
     */
    protected $commandWhitelist = [
        'clear-compiled', 'down', 'env', 'inspire', 'migrate', 'optimize', 'up',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tinker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interact with your application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->getApplication()->setCatchExceptions(false);

        $config = new Configuration([
            'updateCheck' => 'never',
        ]);

        $config->getPresenter()->addCasters(
            $this->getCasters()
        );

        $shell = new Shell($config);
        $shell->addCommands($this->getCommands());
        $shell->setIncludes($this->argument('include'));

        if (isset($_ENV['COMPOSER_VENDOR_DIR'])) {
            $path = $_ENV['COMPOSER_VENDOR_DIR'];
        } else {
            $path = $this->getLaravel()->basePath().DIRECTORY_SEPARATOR.'vendor';
        }

        $path .= '/composer/autoload_classmap.php';

        $loader = ClassAliasAutoloader::register($shell, $path);

        try {
            $shell->run();
        } finally {
            $loader->unregister();
        }
    }

    /**
     * Get artisan commands to pass through to PsySH.
     *
     * @return array
     */
    protected function getCommands()
    {
        $commands = [];

        foreach ($this->getApplication()->all() as $name => $command) {
            if (in_array($name, $this->commandWhitelist)) {
                $commands[] = $command;
            }
        }

        foreach (config('tinker.commands', []) as $command) {
            $commands[] = $this->getApplication()->resolve($command);
        }

        return $commands;
    }

    /**
     * Get an array of Laravel tailored casters.
     *
     * @return array
     */
    protected function getCasters()
    {
        $casters = [
            'Illuminate\Support\Collection' => 'Laravel\Tinker\TinkerCaster::castCollection',
        ];

        if (class_exists('Illuminate\Database\Eloquent\Model')) {
            $casters['Illuminate\Database\Eloquent\Model'] = 'Laravel\Tinker\TinkerCaster::castModel';
        }

        if (class_exists('Illuminate\Foundation\Application')) {
            $casters['Illuminate\Foundation\Application'] = 'Laravel\Tinker\TinkerCaster::castApplication';
        }

        return $casters;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['include', InputArgument::IS_ARRAY, 'Include file(s) before starting tinker'],
        ];
    }
}
