# 帮助工具

在最新的版本中新增了面向开发人员的帮助工具，能在开发中提供帮助提高效率，目前提供`脚手架`，`数据库命令行`和`artisan命令行`三个工具，如果有更好的其它实用工具的想法，欢迎提供建议。

安装：
```php
composer require laravel-admin-ext/helpers

php artisan admin:import helpers
```

> 工具的部分功能会在项目中创建或删除文件，可能会出现文件或目录权限的问题，这个问题需要自行解决。
> 另外部分数据库和artisan命令无法在web环境下使用。

## 脚手架工具

脚手架工具能帮你一键生成控制器、模型、迁移文件，并运行迁移文件，访问`http://localhost/admin/helpers/scaffold`打开。

其中设置迁移表结构的时候，主键字段是自动生成的不需要填写。

![qq20170220-2](https://cloud.githubusercontent.com/assets/1479100/23147949/cbf03e84-f81d-11e6-82b7-d7929c3033a0.png)

## 数据库命令行

数据库命令行工具的web集成，目前支持`mysql`、`mongodb` 和 `redis`，访问`http://localhost/admin/helpers/terminal/database`打开。

在右上角的`select`选择框切换数据库连接，然后在底部的输入框输入对应数据库的查询语句然后回车，就能得到查询结果：

![qq20170220-3](https://cloud.githubusercontent.com/assets/1479100/23147951/ce08e5d6-f81d-11e6-8b20-605e8cd06167.png)

实用方式和终端上操作数据库是一致的，可以运行所选择数据库的所支持的查询语句。

## artisan命令行工具

`Laravel`的`artisan`命令的web实现，可以在上面运行artisan命令，访问`http://localhost/admin/helpers/terminal/artisan`打开。

![qq20170220-1](https://cloud.githubusercontent.com/assets/1479100/23147963/da8a5d30-f81d-11e6-97b9-239eea900ad3.png)

## 路由列表

这个工具能用用比较直观的展现出系统的所有路由，包括路由的uri、方法和中间件等，还能查询路由。访问`http://localhost/admin/helpers/routes`打开。

![helpers_routes](https://user-images.githubusercontent.com/1479100/30899066-e8bdd5ca-a390-11e7-809d-4ceccd0da27f.png)
