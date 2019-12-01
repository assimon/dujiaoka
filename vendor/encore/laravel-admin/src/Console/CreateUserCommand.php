<?php

namespace Encore\Admin\Console;

use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userModel = config('admin.database.users_model');
        $roleModel = config('admin.database.roles_model');

        $username = $this->ask('Please enter a username to login');

        $password = bcrypt($this->secret('Please enter a password to login'));

        $name = $this->ask('Please enter a name to display');

        $roles = $roleModel::all();

        /** @var array $selected */
        $selectedOption = $roles->pluck('name')->toArray();

        if (empty($selectedOption)) {
            $selected = $this->choice('Please choose a role for the user', $selectedOption, null, null, true);

            $roles = $roles->filter(function ($role) use ($selected) {
                return in_array($role->name, $selected);
            });
        }

        $user = new $userModel(compact('username', 'password', 'name'));

        $user->save();

        if (isset($roles)) {
            $user->roles()->attach($roles);
        }

        $this->info("User [$name] created successfully.");
    }
}
