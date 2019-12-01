<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost:8000';

    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Admin', \Encore\Admin\Facades\Admin::class);
        });

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $app->register('Encore\Admin\AdminServiceProvider');

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $adminConfig = require __DIR__.'/config/admin.php';

        $this->app['config']->set('database.default', 'mysql');
        $this->app['config']->set('database.connections.mysql.host', env('MYSQL_HOST', 'localhost'));
        $this->app['config']->set('database.connections.mysql.database', 'laravel_admin_test');
        $this->app['config']->set('database.connections.mysql.username', 'root');
        $this->app['config']->set('database.connections.mysql.password', '');
        $this->app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $this->app['config']->set('filesystems', require __DIR__.'/config/filesystems.php');
        $this->app['config']->set('admin', $adminConfig);

        foreach (Arr::dot(Arr::get($adminConfig, 'auth'), 'auth.') as $key => $value) {
            $this->app['config']->set($key, $value);
        }

        $this->artisan('vendor:publish', ['--provider' => 'Encore\Admin\AdminServiceProvider']);

        Schema::defaultStringLength(191);

        $this->artisan('admin:install');

        $this->migrateTestTables();

        if (file_exists($routes = admin_path('routes.php'))) {
            require $routes;
        }

        require __DIR__.'/routes.php';

        require __DIR__.'/seeds/factory.php';
    }

    public function tearDown()
    {
        (new CreateAdminTables())->down();

        (new CreateTestTables())->down();

        DB::select("delete from `migrations` where `migration` = '2016_01_04_173148_create_admin_tables'");

        parent::tearDown();
    }

    /**
     * run package database migrations.
     *
     * @return void
     */
    public function migrateTestTables()
    {
        $fileSystem = new Filesystem();

        $fileSystem->requireOnce(__DIR__.'/migrations/2016_11_22_093148_create_test_tables.php');

        (new CreateTestTables())->up();
    }
}
