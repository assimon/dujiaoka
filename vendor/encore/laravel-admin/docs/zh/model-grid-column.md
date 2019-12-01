# 列操作

`model-grid`内置了很多对于列的操作方法，可以通过这些方法很灵活的操作列数据。

`Encore\Admin\Grid\Column`对象内置了`display()`方法来通过传入的回调函数来处理当前列的值，
```php
$grid->column('title')->display(function ($title) {

    return "<span style='color:blue'>$title</span>";
    
});
```
在传入的匿名函数中可以通过任何方式对数据进行处理，另外匿名函数绑定了当前列的数据作为父对象，可以在函数中调用当前行的数据：
```php

$grid->first_name();

$grid->last_name();

// 不存在的`full_name`字段
$grid->column('full_name')->display(function () {
    return $this->first_name . ' ' . $this->last_name;
});
```

> `value()`方法作为`display()`方法的别名存在

## 内置方法

`model-grid`内置了若干方法来帮助你扩展列功能

### editable

通过`editable.js`的帮助，可以让你在表格中直接编辑数据，使用方法如下
```php
$grid->title()->editable();

$grid->title()->editable('textarea');

$grid->title()->editable('select', [1 => 'option1', 2 => 'option2', 3 => 'option3']);

// select 支持传递闭包作为参数，该闭包接收参数为当前行对应的模型
$grid->title()->editable('select', function($row) {
    if ($row->title === 'test') {
        return ['test1', 'test2'];
    }
    return ['test3', 'test4'];
});

$grid->birth()->editable('date');

$grid->published_at()->editable('datetime');

$grid->column('year')->editable('year');

$grid->column('month')->editable('month');

$grid->column('day')->editable('day');

```

### switch

> 注意：在`grid`中对某字段设置了`switch`，同时需要在`form`里面对该字段设置同样的`switch`

快速将列变成开关组件，使用方法如下：
```php
$grid->status()->switch();

// 设置text、color、和存储值
$states = [
    'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
    'off' => ['value' => 2, 'text' => '关闭', 'color' => 'default'],
];
$grid->status()->switch($states);

```

### switchGroup

> 注意：在`grid`中对某些字段设置了`switch`，同时需要在`form`里面对这些字段设置同样的`switch`

快速将列变成开关组件组，使用方法如下：
```php
$states = [
    'on' => ['text' => 'YES'],
    'off' => ['text' => 'NO'],
];

$grid->column('switch_group')->switchGroup([
    'hot'        => '热门',
    'new'        => '最新',
    'recommend'  => '推荐',
    'image.show' => '显示图片', // 更新对应关联模型
], $states);

```

### select

```php
$grid->options()->select([
    1 => 'Sed ut perspiciatis unde omni',
    2 => 'voluptatem accusantium doloremque',
    3 => 'dicta sunt explicabo',
    4 => 'laudantium, totam rem aperiam',
]);
```

`select` 也支持参数为闭包，使用方法和`editable`的`select`类似。

### radio
```php
$grid->options()->radio([
    1 => 'Sed ut perspiciatis unde omni',
    2 => 'voluptatem accusantium doloremque',
    3 => 'dicta sunt explicabo',
    4 => 'laudantium, totam rem aperiam',
]);
```

`radio` 也支持参数为闭包，使用方法和`editable`的`select`类似。

### checkbox
```php
$grid->options()->checkbox([
    1 => 'Sed ut perspiciatis unde omni',
    2 => 'voluptatem accusantium doloremque',
    3 => 'dicta sunt explicabo',
    4 => 'laudantium, totam rem aperiam',
]);
```

`checkbox` 也支持参数为闭包，使用方法和`editable`的`select`类似。

### image

```php
$grid->picture()->image();

//设置服务器和宽高
$grid->picture()->image('http://xxx.com', 100, 100);

// 显示多图
$grid->pictures()->display(function ($pictures) {
    
    return json_decode($pictures, true);
    
})->image('http://xxx.com', 100, 100);
```

### label
```php
$grid->name()->label();

//设置颜色，默认`success`,可选`danger`、`warning`、`info`、`primary`、`default`、`success`
$grid->name()->label('danger');

// 接收数组
$grid->keywords()->label();
```

### badge

```php
$grid->name()->badge();

//设置颜色，默认`success`,可选`danger`、`warning`、`info`、`primary`、`default`、`success`
$grid->name()->badge('danger');

// 接收数组
$grid->keywords()->badge();
```

## 扩展列功能

可以通过两种方式扩展列功能，第一种是通过匿名函数的方式。

在`app/Admin/bootstrap.php`加入以下代码:
```php
use Encore\Admin\Grid\Column;

Column::extend('color', function ($value, $color) {
    return "<span style='color: $color'>$value</span>"
});
```
然后在`model-grid`中使用这个扩展：
```php

$grid->title()->color('#ccc');

```

如果列显示逻辑比较复杂，可以通过扩展类来实现。

扩展类`app/Admin/Extensions/Popover.php`:
```php
<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Popover extends AbstractDisplayer
{
    public function display($placement = 'left')
    {
        Admin::script("$('[data-toggle=\"popover\"]').popover()");

        return <<<EOT
<button type="button"
    class="btn btn-secondary"
    title="popover"
    data-container="body"
    data-toggle="popover"
    data-placement="$placement"
    data-content="{$this->value}"
    >
  弹出提示
</button>

EOT;

    }
}
```
然后在`app/Admin/bootstrap.php`注册扩展类：
```php
use Encore\Admin\Grid\Column;
use App\Admin\Extensions\Popover;

Column::extend('popover', Popover::class);
```
然后就能在`model-grid`中使用了：
```php
$grid->desciption()->popover('right');
```


## 帮助方法
### 字符串操作
如果当前里的输出数据为字符串，那么可以通过链式方法调用`Illuminate\Support\Str`的方法。

比如有如下一列，显示`title`字段的字符串值:

```php
$grid->title();
```

在`title`列输出的字符串基础上调用`Str::limit()`方法
```php
$grid->title()->limit(30);
```
调用方法之后输出的还是字符串，所以可以继续调用`Illuminate\Support\Str`的方法：
```php
$grid->title()->limit(30)->ucfirst();

$grid->title()->limit(30)->ucfirst()->substr(1, 10);

```

### 数组操作
如果当前列输出的是数组，可以直接链式调用`Illuminate\Support\Collection`方法。

比如`tags`列是从一对多关系取出来的数组数据：
```php
$grid->tags();

array (
  0 => 
  array (
    'id' => '16',
    'name' => 'php',
    'created_at' => '2016-11-13 14:03:03',
    'updated_at' => '2016-12-25 04:29:35',
    
  ),
  1 => 
  array (
    'id' => '17',
    'name' => 'python',
    'created_at' => '2016-11-13 14:03:09',
    'updated_at' => '2016-12-25 04:30:27',
  ),
)

```

调用`Collection::pluck()`方法取出数组的中的`name`列
```php
$grid->tags()->pluck('name');

array (
    0 => 'php',
    1 => 'python',
  ),

```
取出`name`列之后输出的还是数组，还能继续调用用`Illuminate\Support\Collection`的方法

```php
$grid->tags()->pluck('name')->map('ucwords');

array (
    0 => 'Php',
    1 => 'Python',
  ),
```
将数组输出为字符串
```php
$grid->tags()->pluck('name')->map('ucwords')->implode('-');

"Php-Python"
```

### 混合使用

在上面两种类型的方法调用中，只要上一步输出的是确定类型的值，便可以调用类型对应的方法，所以可以很灵活的混合使用。

比如`images`字段是存储多图片地址数组的JSON格式字符串类型：
```php

$grid->images();

"['foo.jpg', 'bar.png']"

// 链式方法调用来显示多图
$grid->images()->display(function ($images) {

    return json_decode($images, true);
    
})->map(function ($path) {

    return 'http://localhost/images/'. $path;
    
})->image();

```




