# Web widgets

## Box

`Encore\Admin\Widgets\Box` used to generate box components:

```php
use Encore\Admin\Widgets\Box;

$box = new Box('Box Title', 'Box content');

$box->removable();

$box->collapsable();

$box->style('info');

$box->solid();

echo $box;

```

The `$content` parameter is the content element of the Box, which can be either an implementation of the `Illuminate\Contracts\Support\Renderable` interface, or other printable variables.

`Box::title($title)` method is used to set the Box component title.

`Box::content($content)` method is used to set the content element of a Box component.

`Box::removable()` method sets the Box component as removable.

`Box::collapsable()` method sets the Box component as collapsable.

`Box::style($style)` method sets the style of the Box component to fill in `primary`, `info`, `danger`, `warning`, `success`, `default`.

`Box::solid()` method adds a border to the Box component.

## Collapse

`Encore\Admin\Widgets\Collapse` class used to generate folding components:
```php
use Encore\Admin\Widgets\Collapse;

$collapse = new Collapse();

$collapse->add('Bar', 'xxxxx');
$collapse->add('Orders', new Table());

echo $collapse->render();

```

`Collapse::add($title, $content)` method is used to add a collapsed item to the collapsing component. The `$title` parameter sets the title of the item. The`$content` parameter is used to .


## Form

`Encore\Admin\Widgets\Form` class is used to quickly build a form:

```php

$form = new Form();

$form->action('example');

$form->email('email')->default('qwe@aweq.com');
$form->password('password');
$form->text('name');
$form->url('url');
$form->color('color');
$form->map('lat', 'lng');
$form->date('date');
$form->json('val');
$form->dateRange('created_at', 'updated_at');

echo $form->render();
```

`Form::__construct($data = [])` generates a form object. If the `$data` parameter is passed, the elements in the `$data` array will be filled into the form.

`Form::action($uri)` method is used to set the form submission address.

`Form::method($method)` method is used to set the submit method of the form, the default is `POST` method.

`Form::disablePjax()` disable pjax for form submit.

## Infobox

`Encore\Admin\Widgets\InfoBox` class is used to generate the information presentation block:

```php
use Encore\Admin\Widgets\InfoBox;

$infoBox = new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024');

echo $infoBox->render();

```

Refer to the section on the `InfoBox` in the `index()` method of the home page layout file [HomeController.php](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/HomeController.stub).

## Tab component

`Encore\Admin\Widgets\Tab` class is used to generate the tab components:

```php
use Encore\Admin\Widgets\Tab;

$tab = new Tab();

$tab->add('Pie', $pie);
$tab->add('Table', new Table());
$tab->add('Text', 'blablablabla....');

echo $tab->render();

```

`Tab::add($title, $content)` method is used to add new tab, `$title` is tab title, `$content` is tab content.

## Table

`Encore\Admin\Widgets\Table` class is used to generate tables:

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

