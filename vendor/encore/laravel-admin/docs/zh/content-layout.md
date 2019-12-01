# 页面内容

`laravel-admin`的布局可参考后台首页的布局文件[HomeController.php](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/HomeController.stub)的`index()`方法。

`Encore\Admin\Layout\Content`类用来实现内容区的布局。`Content::body($content)`方法用来添加页面内容：

一个简单的后台页面代码如下：

```php
public function index()
{
    return Admin::content(function (Content $content) {

        // 选填
        $content->header('填写页面头标题');
        
        // 选填
        $content->description('填写页面描述小标题');
        
        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/admin'],
            ['text' => '用户管理', 'url' => '/admin/users'],
            ['text' => '编辑用户']
        );

        // 填充页面body部分，这里可以填入任何可被渲染的对象
        $content->body('hello world');
    });
}

```

其中`$content->body();`方法可以接受任何可字符串化的对象作为参数，可以是字符串、数字、包含了`__toString`方法的对象，实现了`Renderable`、`Htmlable`接口的对象，包括laravel的视图。


## 布局

`laravel-admin`的布局使用bootstrap的栅格系统，每行的长度是12，下面是几个简单的示例：

添加一行内容:

```php
$content->row('hello')

---------------------------------
|hello                          |
|                               |
|                               |
|                               |
|                               |
|                               |
---------------------------------

```

行内添加多列：

```php
$content->row(function(Row $row) {
    $row->column(4, 'foo');
    $row->column(4, 'bar');
    $row->column(4, 'baz');
});
----------------------------------
|foo       |bar       |baz       |
|          |          |          |
|          |          |          |
|          |          |          |
|          |          |          |
|          |          |          |
----------------------------------


$content->row(function(Row $row) {
    $row->column(4, 'foo');
    $row->column(8, 'bar');
});
----------------------------------
|foo       |bar                  |
|          |                     |
|          |                     |
|          |                     |
|          |                     |
|          |                     |
----------------------------------

```

列中添加行：

```php
$content->row(function (Row $row) {

    $row->column(4, 'xxx');

    $row->column(8, function (Column $column) {
        $column->row('111');
        $column->row('222');
        $column->row('333');
    });
});
----------------------------------
|xxx       |111                  |
|          |---------------------|
|          |222                  |
|          |---------------------|
|          |333                  |
|          |                     |
----------------------------------


```


列中添加行, 行内再添加列：

```php
$content->row(function (Row $row) {

    $row->column(4, 'xxx');

    $row->column(8, function (Column $column) {
        $column->row('111');
        $column->row('222');
        $column->row(function(Row $row) {
            $row->column(6, '444');
            $row->column(6, '555');
        });
    });
});
----------------------------------
|xxx       |111                  |
|          |---------------------|
|          |222                  |
|          |---------------------|
|          |444      |555        |
|          |         |           |
----------------------------------
```

