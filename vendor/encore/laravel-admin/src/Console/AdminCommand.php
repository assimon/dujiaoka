<?php

namespace Encore\Admin\Console;

use Encore\Admin\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all admin commands';

    /**
     * @var string
     */
    public static $logo = <<<LOGO
    __                                __                __          _     
   / /   ____ __________ __   _____  / /     ____ _____/ /___ ___  (_)___ 
  / /   / __ `/ ___/ __ `/ | / / _ \/ /_____/ __ `/ __  / __ `__ \/ / __ \
 / /___/ /_/ / /  / /_/ /| |/ /  __/ /_____/ /_/ / /_/ / / / / / / / / / /
/_____/\__,_/_/   \__,_/ |___/\___/_/      \__,_/\__,_/_/ /_/ /_/_/_/ /_/ 
                                                                          
LOGO;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line(static::$logo);
        $this->line(Admin::getLongVersion());

        $this->comment('');
        $this->comment('Available commands:');

        $this->listAdminCommands();
    }

    /**
     * List all admin commands.
     *
     * @return void
     */
    protected function listAdminCommands()
    {
        $commands = collect(Artisan::all())->mapWithKeys(function ($command, $key) {
            if (Str::startsWith($key, 'admin:')) {
                return [$key => $command];
            }

            return [];
        })->toArray();

        $width = $this->getColumnWidth($commands);

        /** @var Command $command */
        foreach ($commands as $command) {
            $this->line(sprintf(" %-{$width}s %s", $command->getName(), $command->getDescription()));
        }
    }

    /**
     * @param (Command|string)[] $commands
     *
     * @return int
     */
    private function getColumnWidth(array $commands)
    {
        $widths = [];

        foreach ($commands as $command) {
            $widths[] = static::strlen($command->getName());
            foreach ($command->getAliases() as $alias) {
                $widths[] = static::strlen($alias);
            }
        }

        return $widths ? max($widths) + 2 : 0;
    }

    /**
     * Returns the length of a string, using mb_strwidth if it is available.
     *
     * @param string $string The string to check its length
     *
     * @return int The length of the string
     */
    public static function strlen($string)
    {
        if (false === $encoding = mb_detect_encoding($string, null, true)) {
            return strlen($string);
        }

        return mb_strwidth($string, $encoding);
    }
}
