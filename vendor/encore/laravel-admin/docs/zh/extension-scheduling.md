# 定时任务

这个工具是管理Laravel计划任务的web管理页面

![wx20170810-101048](https://user-images.githubusercontent.com/1479100/29151552-8affc0b2-7db4-11e7-932a-a10d8a42ec50.png)

## 安装

```
$ composer require laravel-admin-ext/scheduling -vvv

$ php artisan admin:import scheduling
```

打开`http://localhost/admin/scheduling`访问。

## 添加任务

打开`app/Console/Kernel.php`， 试着添加两项计划任务：

```php
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->everyTenMinutes();
        
        $schedule->command('route:list')->dailyAt('02:00');
    }
}

```

然后就能在后台看到这两项计划任务的详细情况，也能直接运行这两个计划任务。
