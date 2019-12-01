# Model-Form

The `Encore\Admin\Form` class is used to generate a data model-based form. For example, there is a` movies` table in the database

```sql
CREATE TABLE `movies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `director` int(10) unsigned NOT NULL,
  `describe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rate` tinyint unsigned NOT NULL,
  `released` enum(0, 1),
  `release_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

```

The corresponding data model is `App\Models\Movie`, and the following code can generate the` movies` data form:

```php

use App\Models\Movie;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;

$grid = Admin::form(Movie::class, function(Form $grid){

    // Displays the record id
    $form->display('id', 'ID');

    // Add an input box of type text
    $form->text('title', 'Movie title');
    
    $directors = [
        1 => 'John',
        2 => 'Smith',
        3 => 'Kate',
    ];
    
    $form->select('director', 'Director')->options($directors);
    
    // Add textarea for the describe field
    $form->textarea('describe', 'Describe');
    
    // Number input
    $form->number('rate', 'Rate');
    
    // Add a switch field
    $form->switch('released', 'Released?');
    
    // Add a date and time selection box
    $form->dateTime('release_at', 'release time');
    
    // Display two time column 
    $form->display('created_at', 'Created time');
    $form->display('updated_at', 'Updated time');
});

```

## Custom tools

The top right corner of the form has two button tools by default. You can modify it in the following way:

```php
$form->tools(function (Form\Tools $tools) {

    // Disable back btn.
    $tools->disableBackButton();
    
    // Disable list btn
    $tools->disableListButton();

    // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
    $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
});
```

## Other methods

Disable submit btn:

```php
$form->disableSubmit();
```

Disable reset btn:
```php
$form->disableReset();
```

Ignore fields to store
```php
$form->ignore('column1', 'column2', 'column3');
```

Set width for label and field

```php
$form->setWidth(10, 2);
```

Set form action

```php
$form->setAction('admin/users');
```

## Model relationship


### One to One
The `users` table and the `profiles` table are generated one-to-one relation through the `profiles.user_id` field.

```sql

CREATE TABLE `users` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `profiles` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`age` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

The corresponding data model are:

```php

class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

```

You can associate them in a form with the following code:

```php
Admin::form(User::class, function (Form $form) {

    $form->display('id');

    $form->text('name');
    $form->text('email');
    
    $form->text('profile.age');
    $form->text('profile.gender');

    $form->datetime('created_at');
    $form->datetime('updated_at');
});

```
