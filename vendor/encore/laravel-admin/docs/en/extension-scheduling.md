# Task scheduling

This tool is a web interface for manage Laravel's scheduled tasks

![wx20170810-101048](https://user-images.githubusercontent.com/1479100/29151552-8affc0b2-7db4-11e7-932a-a10d8a42ec50.png)

## Installation

```
$ composer require laravel-admin-ext/scheduling -vvv

$ php artisan admin:import scheduling
```

Then open `http://localhost/admin/scheduling`

## Add tasks

Open `app/Console/Kernel.php`, try adding two scheduled tasks:

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

And then you can see the tasks with details in the page, and you can also directly run these two tasks in the page.
