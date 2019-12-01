Data export
=======

`model-grid` built-in export function is to achieve a simple csv format file export, if you encounter a file coding problem or can not meet their own needs, you can follow the steps below to customize the export function

This example uses [Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel) as an excel library, and of course you can use any other excel library.

First install it:

```shell
composer require maatwebsite/excel:~2.1.0

php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

And then create a new custom export class, such as `app/Admin/Extensions/ExcelExpoter.php`:
```php
<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class ExcelExpoter extends AbstractExporter
{
    public function export()
    {
        Excel::create('Filename', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                // This logic get the columns that need to be exported from the table data
                $rows = collect($this->getData())->map(function ($item) {
                    return Arr::only($item, ['id', 'title', 'content', 'rate', 'keywords']);
                });

                $sheet->rows($rows);

            });

        })->export('xls');
    }
}
```

And then use this class in `model-grid`:
```php

use App\Admin\Extensions\ExcelExpoter;

$grid->exporter(new ExcelExpoter());

```

For more information on how to use `Laravel-Excel`, refer to [laravel-excel/docs](http://www.maatwebsite.nl/laravel-excel/docs)