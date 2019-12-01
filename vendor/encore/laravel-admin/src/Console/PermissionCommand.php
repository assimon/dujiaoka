<?php

namespace Encore\Admin\Console;

use Encore\Admin\Auth\Database\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:permissions {--tables=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate admin permission base on table name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $all_tables = $this->getAllTables();

        $tables = $this->option('tables') ? explode(',', $this->option('tables')) : [];
        if (empty($tables)) {
            $ignore_tables = $this->getIgnoreTables();
            $tables = array_diff($all_tables, $ignore_tables);
        } else {
            $tables = array_intersect($all_tables, $tables);
        }

        if (empty($tables)) {
            $this->info('table is not existed');

            return;
        }

        $permissions = $this->getPermissions();
        foreach ($tables as $table) {
            foreach ($permissions as $permission => $permission_lang) {
                $http_method = $this->generateHttpMethod($permission);
                $http_path = $this->generateHttpPath($table, $permission);
                $slug = $this->generateSlug($table, $permission);
                $name = $this->generateName($table, $permission_lang);
                $exists = Permission::where('slug', $slug)->exists();
                if (!$exists) {
                    Permission::create([
                        'name'        => $name,
                        'slug'        => $slug,
                        'http_method' => $http_method,
                        'http_path'   => $http_path,
                    ]);
                    $this->info("$slug is generated");
                } else {
                    $this->warn("$slug is existed");
                }
            }
        }
    }

    private function getAllTables()
    {
        return array_map('current', DB::select('SHOW TABLES'));
    }

    private function getIgnoreTables()
    {
        return [
            config('admin.database.users_table'),
            config('admin.database.roles_table'),
            config('admin.database.permissions_table'),
            config('admin.database.menu_table'),
            config('admin.database.operation_log_table'),
            config('admin.database.user_permissions_table'),
            config('admin.database.role_users_table'),
            config('admin.database.role_permissions_table'),
            config('admin.database.role_menu_table'),
        ];
    }

    private function getPermissions()
    {
        return [
            'list'   => __('admin.list'),
            'view'   => __('admin.view'),
            'create' => __('admin.create'),
            'edit'   => __('admin.edit'),
            'delete' => __('admin.delete'),
            'export' => __('admin.export'),
            'filter' => __('admin.filter'),
        ];
    }

    private function generateHttpMethod($permission)
    {
        switch ($permission) {
            case 'create':
                $http_method = ['POST'];
                break;
            case 'edit':
                $http_method = ['PUT', 'PATCH'];
                break;
            case 'delete':
                $http_method = ['DELETE'];
                break;
            case 'filter':
                $http_method = [];
                break;
            default:
                $http_method = ['GET'];
        }

        return $http_method;
    }

    private function generateHttpPath($table, $permission)
    {
        $resource = Str::kebab(Str::camel($table));
        switch ($permission) {
            case 'create':
                $http_path = '/'.$resource;
                break;
            case 'edit':
                $http_path = '/'.$resource.'/*';
                break;
            case 'delete':
                $http_path = '/'.$resource.'/*';
                break;
            case 'index':
                $http_path = '/'.$resource;
                break;
            case 'view':
                $http_path = '/'.$resource.'/*';
                break;
            default:
                $http_path = '';
        }

        return $http_path;
    }

    private function generateSlug($table, $permission)
    {
        return Str::kebab(Str::camel($table)).'.'.$permission;
    }

    private function generateName($table, $permission_lang)
    {
        return Str::upper(Str::kebab(Str::camel($table))).$permission_lang;
    }
}
