# 前端组件

## Box组件

`Encore\Admin\Widgets\Box`用来生成box组件：

```php
use Encore\Admin\Widgets\Box;

$box = new Box('Box标题', 'Box内容');

$box->removable();

$box->collapsable();

$box->style('info');

$box->solid();

echo $box;

```

`Box::__construct($title, $content)`,`$title`参数为Box组件的标题，`$content`参数为Box的内容元素，可以是实现了`Illuminate\Contracts\Support\Renderable`接口的对象或者其他可打印变量。

`Box::title($title)`方法用来设置Box组件标题。

`Box::content($content)`方法用来设置Box组件的内容元素。

`Box::removable()`方法将Box组件设置为可关闭。

`Box::collapsable()`方法将Box组件设置为可展开和收起。

`Box::style($style)`方法设置Box组件的样式，可填值为`primary`,`info`,`danger`,`warning`,`success`,`default`。

`Box::solid()`方法为Box组件添加边框。

## Collapse组件

`Encore\Admin\Widgets\Collapse`类用来生成折叠插件：
```php
use Encore\Admin\Widgets\Collapse;

$collapse = new Collapse();

$collapse->add('Bar', 'xxxxx');
$collapse->add('Orders', new Table());

echo $collapse->render();

```

`Collapse::add($title, $content)`方法用来给折叠组件添加一个折叠项，`$title`参数设置该折叠项的标题，`$content`参数用来舍子折叠区的内用。


## 表单

`Encore\Admin\Widgets\Form`类用来快速构建表单：

```php

$form = new Form();

$form->action('example');

$form->email('email')->default('qwe@aweq.com');
$form->password('password');
$form->text('name', '输入框');
$form->url('url');
$form->color('color');
$form->map('lat', 'lng');
$form->date('date');
$form->json('val');
$form->dateRange('created_at', 'updated_at');

echo $form->render();
```
`Form::__construct($data = [])`生成一个form对象，如果传入了`$data`参数，`$data`数组中的元素将会按照`key`对应填入`form`对应name的表单中。

`Form::action($uri)`方法用来设置表单提交地址。

`Form::method($method)`方法用来设置form表单的提交方法,默认为`POST`方法。

`Form::disablePjax()` 不使用pjax方式提交表单。


## Infobox组件

`Encore\Admin\Widgets\InfoBox`类用来生成信息展示块：

```php
use Encore\Admin\Widgets\InfoBox;

$infoBox = new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024');

echo $infoBox->render();

```

效果请参考后台首页的布局文件[HomeController.php](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/HomeController.stub)的`index()`方法中，关于`InfoBox`的部分。

## Tab组件

`Encore\Admin\Widgets\Tab`类用来生成选项卡组件：

```php
use Encore\Admin\Widgets\Tab;

$tab = new Tab();

$tab->add('Pie', $pie);
$tab->add('Table', new Table());
$tab->add('Text', 'blablablabla....');

echo $tab->render();

```

`Tab::add($title, $content)`方法用来添加一个选项卡，`$title`为选项标题，`$content`选项卡内容。

## Table

`Encore\Admin\Widgets\Table`类用来生成表格：

```php
use Encore\Admin\Widgets\Table;

// table 1
$headers = ['Id', 'Email', 'Name', 'Company'];
$rows = [
    [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica'],
    [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar'],
    [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC'],
    [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor'],
    [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.'],
];

$table = new Table($headers, $rows);

echo $table->render();

// table 2
$headers = ['Keys', 'Values'];
$rows = [
    'name'   => 'Joe',
    'age'    => 25,
    'gender' => 'Male',
    'birth'  => '1989-12-05',
];

$table = new Table($headers, $rows);

echo $table->render();

```

