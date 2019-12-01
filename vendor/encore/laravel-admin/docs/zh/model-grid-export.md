数据导出
=======

`model-grid`内置的导出功能只是实现了简单的csv格式文件的导出，如果遇到文件编码问题或者满足不了自己需求的情况，可以按照下面的步骤来自定义导出功能

本示例用[Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel)作为excel操作库，当然也可以使用任何其他excel库

首先安装好它：

```shell
composer require maatwebsite/excel:~2.1.0

php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

然后新建自定义导出类，比如`app/Admin/Extensions/ExcelExpoter.php`:
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

                // 这段逻辑是从表格数据中取出需要导出的字段
                $rows = collect($this->getData())->map(function ($item) {
                    return Arr::only($item, ['id', 'title', 'content', 'rate', 'keywords']);
                });

                $sheet->rows($rows);

            });

        })->export('xls');
    }
}
```

然后在`model-grid`中使用这个导出类：
```php

use App\Admin\Extensions\ExcelExpoter;

$grid->exporter(new ExcelExpoter());

```

有关更多`Laravel-Excel`的使用方法，参考[laravel-excel/docs](http://www.maatwebsite.nl/laravel-excel/docs)