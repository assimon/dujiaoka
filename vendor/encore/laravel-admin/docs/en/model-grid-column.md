# Model-grid column

`model-grid` built-in a lot of the operation of the column, you can use these methods very flexible operation of the column data.

The `Encore\Admin\Grid\Column` object has a built-in `display()` method to handle the value of the current column through the incoming callback function:
```php
$grid->column('title')->display(function ($title) {

    return "<span style='color:blue'>$title</span>";
    
});
```

The `display` callback bound to the current row data object as a parent object, you can use the data in current row by this way:
```php

$grid->first_name();

$grid->last_name();

$grid->column('full_name')->display(function () {
    return $this->first_name . ' ' . $this->last_name;
});
```

> method `value()` is a alias to method `display()`.

## Built-in methods

`model-grid` has built-in methods to help you extend the column functionality

### editable

With the help of `editable.js`, you can edit the data in the grid directly:
```php
$grid->title()->editable();

$grid->title()->editable('textarea');

$grid->title()->editable('select', [1 => 'option1', 2 => 'option2', 3 => 'option3']);

$grid->birth()->editable('date');

$grid->published_at()->editable('datetime');

$grid->column('year')->editable('year');

$grid->column('month')->editable('month');

$grid->column('day')->editable('day');

```

### switch

> notice: If set up a switch for a column the grid, then need to set the column in the form of the same switch

Quickly turn a column into a switch component using the following methods:
```php
$grid->status()->switch();

// set the `text`、`color`、and `value`
$states = [
    'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'primary'],
    'off' => ['value' => 2, 'text' => 'NO', 'color' => 'default'],
];
$grid->status()->switch($states);

```

### switchGroup

> notice: If set up switch for some columns the grid, then need to set these columns in the form of the same switch

To quickly change a column into a switch component group, use the following method:
```php
$states = [
    'on' => ['text' => 'YES'],
    'off' => ['text' => 'NO'],
];

$grid->column('switch_group')->switchGroup([
    'hot'       => 'Hot',
    'new'       => 'New',
    'recommend' => 'Recommend',
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

### radio
```php
$grid->options()->radio([
    1 => 'Sed ut perspiciatis unde omni',
    2 => 'voluptatem accusantium doloremque',
    3 => 'dicta sunt explicabo',
    4 => 'laudantium, totam rem aperiam',
]);
```

### checkbox
```php
$grid->options()->checkbox([
    1 => 'Sed ut perspiciatis unde omni',
    2 => 'voluptatem accusantium doloremque',
    3 => 'dicta sunt explicabo',
    4 => 'laudantium, totam rem aperiam',
]);
```

### image

```php
$grid->picture()->image();

//Set host, width and height
$grid->picture()->image('http://xxx.com', 100, 100);

// display multiple images
$grid->pictures()->display(function ($pictures) {
    
    return json_decode($pictures, true);
    
})->image('http://xxx.com', 100, 100);
```

### label
```php
$grid->name()->label();

//Set color,defaults to `success`, other options `danger`、`warning`、`info`、`primary`、`default`、`success`
$grid->name()->label('danger');

// can handle a array
$grid->keywords()->label();
```

### badge

```php
$grid->name()->badge();

//Set color,defaults to `success`, other options `danger`、`warning`、`info`、`primary`、`default`、`success`
$grid->name()->badge('danger');

// can handle a array
$grid->keywords()->badge();
```

## Extend the column

There are two ways to extend the column function, the first one is through the anonymous function.

Add following code to `app/Admin/bootstrap.php`:
```php
use Encore\Admin\Grid\Column;

Column::extend('color', function ($value, $color) {
    return "<span style='color: $color'>$value</span>";
});
```
Use this extension in `model-grid`:
```php

$grid->title()->color('#ccc');

```

If the column display logic is more complex, you can implement with an extension class.

Extension class `app/Admin/Extensions/Popover.php`:
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
  Popover
</button>

EOT;

    }
}
```
And then register the extension in `app/Admin/bootstrap.php`：
```php
use Encore\Admin\Grid\Column;
use App\Admin\Extensions\Popover;

Column::extend('popover', Popover::class);
```
Use the extension in `model-grid`：
```php
$grid->desciption()->popover('right');
```


## helpers
### String operations
If the current output data is a string, you can call the method of class `Illuminate\Support\Str`.

For example, the following column shows the string value of the `title` field:

```php
$grid->title();
```

Call `Str::limit()` on `title` colum.

Can call `Str::limit()` method on the output string of the `title` column.

```php
$grid->title()->limit(30);
```

Continue to call `Illuminate\Support\Str` method:

```php
$grid->title()->limit(30)->ucfirst();

$grid->title()->limit(30)->ucfirst()->substr(1, 10);

```

### Array operations
If the current output data is a array, you can call the method of class `Illuminate\Support\Collection`.

For example, the `tags` column is an array of data retrieved from a one-to-many relationship:
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

Call the `Collection::pluck()` method to get the `name` column from the array
```php
$grid->tags()->pluck('name');

array (
    0 => 'php',
    1 => 'python',
  ),

```

The output data is still a array after above, so you can call methods of `Illuminate\Support\Collection` continue.

```php
$grid->tags()->pluck('name')->map('ucwords');

array (
    0 => 'Php',
    1 => 'Python',
  ),
```
Outputs the array as a string
```php
$grid->tags()->pluck('name')->map('ucwords')->implode('-');

"Php-Python"
```

### Mixed use

In the above two types of method calls, as long as the output of the previous step is to determine the type of value, you can call the corresponding type of method, it can be very flexible mix.

For example, the `images` field is a JSON-formatted string type that stores a multiple-picture address array:

```php

$grid->images();

"['foo.jpg', 'bar.png']"

// chain method calls to display multiple images
$grid->images()->display(function ($images) {

    return json_decode($images, true);
    
})->map(function ($path) {

    return 'http://localhost/images/'. $path;
    
})->image();

```




