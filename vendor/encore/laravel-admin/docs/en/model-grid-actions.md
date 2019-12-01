# Model grid row actions

`model-grid` By default, there are two actions `edit` and `delete`, which can be turned off in the following way:

```php
 $grid->actions(function ($actions) {
    $actions->disableDelete();
    $actions->disableEdit();
});
```
You can get the data for the current row by `$actions` parameter passed in:
```php
 $grid->actions(function ($actions) {
    
    // the array of data for the current row
    $actions->row;
    
    // gets the current row primary key value
    $actions->getKey();
});
```

If you have a custom action button, you can add the following:

```php
$grid->actions(function ($actions) {
    
    // append an action.
    $actions->append('<a href=""><i class="fa fa-eye"></i></a>');

    // prepend an action.
    $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
}
```

If you have more complex actions, you can refer to the following ways:

First define the action class:
```php
<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class CheckRow
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {
    
    // Your code.
    console.log($(this).data('id'));
    
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs btn-success fa fa-check grid-check-row' data-id='{$this->id}'></a>";
    }
    
    public function __toString()
    {
        return $this->render();
    }
}
```
Then add the action:
```php
$grid->actions(function ($actions) {
    
    // add action
    $actions->append(new CheckRow($actions->getKey()));
}
```

Row manipulations with column conditions:
For row attributes, you can use `$row->model()` array or `$row->column()` method.
You need to set style after setting attributes. Otherwise style method will be by-passed 
```php
$grid->rows(function ($row) {
   // if relased column value is Yes
   if ( $row->column('released') == 'Yes' ) {
        // Set attributes for row.
        $row->setAttributes([ 'data-row-id' => $row->model()['id'], 'data-row-date' => $row->column('release_date') ]);
        // Set style of row
        $row->style("background-color:green");
    }

});
```
