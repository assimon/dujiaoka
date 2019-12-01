# 数据查询过滤

`model-grid`提供了一系列的方法实现表格数据的查询过滤：

```php
$grid->filter(function($filter){

    // 去掉默认的id过滤器
    $filter->disableIdFilter();
    
    // 自定义id过滤器，在去掉默认id过滤器后必须调用 setId 方法，
    // 并设置一个和主键不同的值，自定义的id过滤器才会显示。
    $filter->equal('id', '产品序列号')->setId('product_id');

    // 在这里添加字段过滤器
    $filter->like('name', 'name');
    ...

});

```
## 查询类型

目前支持的过滤类型有下面这些:

### equal
`sql: ... WHERE `column` = "$input"`：
```php
$filter->equal('column', $label);
```

### not equal
`sql: ... WHERE `column` != "$input"`：
```php
$filter->notEqual('column', $label);
```

### like
`sql: ... WHERE `column` LIKE "%$input%"`：
```php
$filter->like('column', $label);
```

### ilike
`sql: ... WHERE `column` ILIKE "%$input%"`：
```php
$filter->ilike('column', $label);
```

### 大于
`sql: ... WHERE `column` > "$input"`：
```php
$filter->gt('column', $label);
```

### 小于
`sql: ... WHERE `column` < "$input"`：
```php
$filter->lt('column', $label);
```

### between
`sql: ... WHERE `column` BETWEEN "$start" AND "$end"`：
```php
$filter->between('column', $label);

// 设置datetime类型
$filter->between('column', $label)->datetime();

// 设置time类型
$filter->between('column', $label)->time();
```

### in
`sql: ... WHERE `column` in (...$inputs)`：
```php
$filter->in('column', $label)->multipleSelect(['key' => 'value']);
```

### notIn
`sql: ... WHERE `column` not in (...$inputs)`：
```php
$filter->notIn('column', $label)->multipleSelect(['key' => 'value']);
```

### date
`sql: ... WHERE DATE(`column`) = "$input"`：
```php
$filter->date('column', $label);
```

### day
`sql: ... WHERE DAY(`column`) = "$input"`：
```php
$filter->day('column', $label);
```

### month
`sql: ... WHERE MONTH(`column`) = "$input"`：
```php
$filter->month('column', $label);
```

### year
`sql: ... WHERE YEAR(`column`) = "$input"`：
```php
$filter->year('column', $label);
```

### where

可以用where来构建比较复杂的查询过滤

`sql: ... WHERE `title` LIKE "%$input" OR `content` LIKE "%$input"`：
```php
$filter->where(function ($query) {

    $query->where('title', 'like', "%{$this->input}%")
        ->orWhere('content', 'like', "%{$this->input}%");

}, 'Text');
```

`sql: ... WHERE `rate` >= 6 AND `created_at` = {$input}`:
```php
$filter->where(function ($query) {

    $query->whereRaw("`rate` >= 6 AND `created_at` = {$this->input}");

}, 'Text');
```

关系查询，查询对应关系`profile`的字段：
```php
$filter->where(function ($query) {

    $query->whereHas('profile', function ($query) {
        $query->where('address', 'like', "%{$this->input}%")->orWhere('email', 'like', "%{$this->input}%");
    });

}, '地址或手机号');
```

## 表单类型

### text

表单类型默认是text input，可以设置placeholder：

```php
$filter->equal('column')->placeholder('请输入。。。');
```

也可以通过下面的一些方法来限制用户输入格式：

```php
$filter->equal('column')->url();

$filter->equal('column')->email();

$filter->equal('column')->integer();

$filter->equal('column')->ip();

$filter->equal('column')->mac();

$filter->equal('column')->mobile();

// $options 参考 https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->decimal($options = []);

// $options 参考 https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->currency($options = []);

// $options 参考 https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->percentage($options = []);

// $options 参考 https://github.com/RobinHerbots/Inputmask, $icon为input前面的图标
$filter->equal('column')->inputmask($options = [], $icon = 'pencil');
```

### select
```php
$filter->equal('column')->select(['key' => 'value'...]);

// 或者从api获取数据，api的格式参考model-form的select组件
$filter->equal('column')->select('api/users');
```

### multipleSelect
一般用来配合`in`和`notIn`两个需要查询数组的查询类型使用，也可以在`where`类型的查询中使用：
```php
$filter->in('column')->multipleSelect(['key' => 'value'...]);

// 或者从api获取数据，api的格式参考model-form的multipleSelect组件
$filter->in('column')->multipleSelect('api/users');
```

### radio
比较常见的场景是选择分类

```php
$filter->equal('released')->radio([
    ''   => 'All',
    0    => 'Unreleased',
    1    => 'Released',
]);
```

### checkbox
比较常见的场景是配合`whereIn`来做范围筛选

```php
$filter->in('gender')->checkbox([
    'm'    => 'Male',
    'f'    => 'Female',
]);
```

### datetime

通过日期时间组件来查询，`$options`的参数和值参考[bootstrap-datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/Options/)

```php
$filter->equal('column')->datetime($options);

// `date()` 相当于 `datetime(['format' => 'YYYY-MM-DD'])`
$filter->equal('column')->date();

// `time()` 相当于 `datetime(['format' => 'HH:mm:ss'])`
$filter->equal('column')->time();

// `day()` 相当于 `datetime(['format' => 'DD'])`
$filter->equal('column')->day();

// `month()` 相当于 `datetime(['format' => 'MM'])`
$filter->equal('column')->month();

// `year()` 相当于 `datetime(['format' => 'YYYY'])`
$filter->equal('column')->year();

```
