# Upgrade precautions

Because `laravel-admin 1.5` built-in table structure has been modified, it is recommended that you re-install `laravel 5.5` and `laravel-admin 1.5`, and then migrate the code over

Code migration needs attention：

- Please refer to the table structure changes [tables.php](https://github.com/z-song/laravel-admin/blob/master/database/migrations/2016_01_04_173148_create_admin_tables.php)
- Routing file structure is modified please refer to [routes.stub](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/routes.stub)
- Please refer to the configuration file structure changes [admin.php](https://github.com/z-song/laravel-admin/blob/master/config/admin.php)
- The chart component has been removed and can no longer be used, please refer to [Custom chart](/en/custom-chart.md)