# 基于数据模型的表格

`Encore\Admin\Grid`类用于生成基于数据模型的表格，先来个例子，数据库中有`movies`表

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

对应的数据模型为`App\Models\Movie`，下面的代码可以生成表`movies`的数据表格：

```php

use App\Models\Movie;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;

$grid = Admin::grid(Movie::class, function(Grid $grid){

    // 第一列显示id字段，并将这一列设置为可排序列
    $grid->id('ID')->sortable();

    // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
    $grid->column('title');
    
    // 第三列显示director字段，通过display($callback)方法设置这一列的显示内容为users表中对应的用户名
    $grid->director()->display(function($userId) {
        return User::find($userId)->name;
    });
    
    // 第四列显示为describe字段
    $grid->describe();
    
    // 第五列显示为rate字段
    $grid->rate();

    // 第六列显示released字段，通过display($callback)方法来格式化显示输出
    $grid->released('上映?')->display(function ($released) {
        return $released ? '是' : '否';
    });

    // 下面为三个时间字段的列显示
    $grid->release_at();
    $grid->created_at();
    $grid->updated_at();

    // filter($callback)方法用来设置表格的简单搜索框
    $grid->filter(function ($filter) {
    
        // 设置created_at字段的范围查询
        $filter->between('created_at', 'Created Time')->datetime();
    });
});

```

## 基本使用方法

#### 添加列
```php

// 直接通过字段名`username`添加列
$grid->username('用户名');

// 效果和上面一样
$grid->column('username', '用户名');

// 添加多列
$grid->columns('email', 'username' ...);
```

#### 修改来源数据
```php
$grid->model()->where('id', '>', 100);

$grid->model()->orderBy('id', 'desc');

$grid->model()->take(100);

...

```

其它查询方法可以参考`eloquent`的查询方法.

#### 设置每页显示行数

```php
// 默认为每页20条
$grid->paginate(15);
```

#### 修改显示输出


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

// 添加不存在的字段
$grid->column('column_not_in_table')->display(function () {
    return 'blablabla....';
});
```

`display()`方法接收的匿名函数绑定了当前行的数据对象，可以在里面调用当前行的其它字段数据

```php
$grid->first_name();
$grid->last_name();

// 不存的字段列
$grid->column('full_name')->display(function () {
    return $this->first_name.' '.$this->last_name;
});
```

#### 禁用创建按钮
```php
$grid->disableCreateButton();
```

#### 禁用分页条
```php
$grid->disablePagination();
```

#### 禁用查询过滤器
```php
$grid->disableFilter();
```

#### 禁用导出数据按钮
```php
$grid->disableExport();
```

#### 禁用行选择checkbox
```php
$grid->disableRowSelector();
```

#### 禁用行操作列
```php
$grid->disableActions();
```

#### 设置分页选择器选项
```php
$grid->perPages([10, 20, 30, 40, 50]);
```

## 关联模型


### 一对一
`users`表和`profiles`表通过`profiles.user_id`字段生成一对一关联

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

对应的数据模分别为:

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

通过下面的代码可以关联在一个grid里面:

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

### 一对多

`posts`表和`comments`表通过`comments.post_id`字段生成一对多关联

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

对应的数据模分别为:

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

通过下面的代码可以让两个模型在grid里面互相关联:

```php

return Admin::grid(Post::class, function (Grid $grid) {
    $grid->id('id')->sortable();
    $grid->title();
    $grid->content();

    $grid->comments('评论数')->display(function ($comments) {
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

### 多对多

`users`和`roles`表通过中间表`role_users`产生多对多关系

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

对应的数据模分别为:

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

通过下面的代码可以让两个模型在grid里面互相关联:


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
