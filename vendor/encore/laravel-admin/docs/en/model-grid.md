# Model-grid

Class `Encore\Admin\Grid` is used to generate tables based on the data model,for example,we have a table `movies` in database:

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

And the model of this table is `App\Models\Movie`,The following code can generate the data grid for table `movies`:

```php

use App\Models\Movie;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;

$grid = Admin::grid(Movie::class, function(Grid $grid){

    // The first column displays the id field and sets the column as a sortable column
    $grid->id('ID')->sortable();

    // The second column shows the title field, because the title field name and the Grid object's title method conflict, so use Grid's column () method instead
    $grid->column('title');
    
    // The third column shows the director field, which is set by the display($callback) method to display the corresponding user name in the users table
    $grid->director()->display(function($userId) {
        return User::find($userId)->name;
    });
    
    // The fourth column appears as the describe field
    $grid->describe();
    
    // The fifth column is displayed as the rate field
    $grid->rate();

    // The sixth column shows the released field, formatting the display output through the display($callback) method
    $grid->released('Release?')->display(function ($released) {
        return $released ? 'yes' : 'no';
    });

    // The following shows the columns for the three time fields
    $grid->release_at();
    $grid->created_at();
    $grid->updated_at();

    // The filter($callback) method is used to set up a simple search box for the table
    $grid->filter(function ($filter) {
    
        // Sets the range query for the created_at field
        $filter->between('created_at', 'Created Time')->datetime();
    });
});

```

## Basic Usage

#### Add a column
```php

// Add the column directly through the field name `username`
$grid->username('Username');

// The effect is the same as above
$grid->column('username', 'Username');

// Add multiple columns
$grid->columns('email', 'username' ...);
```

#### Modify the source data
```php
$grid->model()->where('id', '>', 100);

$grid->model()->orderBy('id', 'desc');

$grid->model()->take(100);

```

#### Sets the number of lines displayed per page

```php
// The default is 15 per page
$grid->paginate(20);
```

#### Modify the display output of column

```php
use Illuminate\Support\Str;
$grid->text()->display(function($text) {
    return Str::limit($text, 30, '...');
});

$grid->name()->display(function ($name) {
    return "<span class='label'>$name</span>";
});

$grid->email()->display(function ($email) {
    return "mailto:$email";
});

// column not in table
$grid->column('column_not_in_table')->display(function () {
    return 'blablabla....';
});

```

The closure passed to method `display()` is bind to row data object, you can use other column data in current row.

```php
$grid->first_name();
$grid->last_name();

// column not in table
$grid->column('full_name')->display(function () {
    return $this->first_name.' '.$this->last_name;
});
```

#### Disable the create button 
```php
$grid->disableCreateButton();
```

#### Disable Pagination
```php
$grid->disablePagination();
```

#### Disable all tools on header of grid. Filter, refresh, export, batch actions
```php
$grid->disableTools();
```

#### Disable data filter
```php
$grid->disableFilter();
```

#### Disable the export button
```php
$grid->disableExport();
```

#### Disable row selector
```php
$grid->disableRowSelector();
```

#### Disable row actions
```php
$grid->disableActions();
```

#### Enable orderable grid
```php
$grid->orderable();
```

#### Set options for perPage selector
```php
$grid->perPages([10, 20, 30, 40, 50]);
```

## Relation


### One to one

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

You can associate them in a grid with the following code:

```php
Admin::grid(User::class, function (Grid $grid) {

    $grid->id('ID')->sortable();

    $grid->name();
    $grid->email();
    
    $grid->column('profile.age');
    $grid->column('profile.gender');

    //or
    $grid->profile()->age();
    $grid->profile()->gender();

    $grid->created_at();
    $grid->updated_at();
});

```

### One to many

The `posts` and `comments` tables generate a one-to-many association via the `comments.post_id` field

```sql

CREATE TABLE `posts` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `comments` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`post_id` int(10) unsigned NOT NULL,
`content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

The corresponding data model are:

```php

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

```

You can associate them in a grid with the following code:

```php

return Admin::grid(Post::class, function (Grid $grid) {
    $grid->id('id')->sortable();
    $grid->title();
    $grid->content();

    $grid->comments('Comments count')->display(function ($comments) {
        $count = count($comments);
        return "<span class='label label-warning'>{$count}</span>";
    });

    $grid->created_at();
    $grid->updated_at();
});


return Admin::grid(Comment::class, function (Grid $grid) {
    $grid->id('id');
    $grid->post()->title();
    $grid->content();

    $grid->created_at()->sortable();
    $grid->updated_at();
});

```

### Many to many

The `users` and` roles` tables produce a many-to-many relationship through the pivot table `role_user`

```sql

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```

The corresponding data model are:

```php

class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

```

You can associate them in a grid with the following code:

```php
return Admin::grid(User::class, function (Grid $grid) {
    $grid->id('ID')->sortable();
    $grid->username();
    $grid->name();

    $grid->roles()->display(function ($roles) {

        $roles = array_map(function ($role) {
            return "<span class='label label-success'>{$role['name']}</span>";
        }, $roles);

        return join('&nbsp;', $roles);
    });

    $grid->created_at();
    $grid->updated_at();
});

```
