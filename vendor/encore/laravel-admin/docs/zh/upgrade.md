# 升级注意事项

因为laravel-admin 1.5的内置表结构有修改，所以建议大家重新安装laravel 5.5和laravel-admin 1.5，然后再将代码迁移过来

代码迁移需要注意的事项：

- 表结构有修改 请参考 [tables.php](https://github.com/z-song/laravel-admin/blob/master/database/migrations/2016_01_04_173148_create_admin_tables.php)
- 路由文件结构有修改 请参考 [routes.stub](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/routes.stub)
- 配置文件结构有修改 请参考 [admin.php](https://github.com/z-song/laravel-admin/blob/master/config/admin.php)
- 图表组件已经移除，不能再使用,参考 [自定义图表](/zh/custom-chart.md)