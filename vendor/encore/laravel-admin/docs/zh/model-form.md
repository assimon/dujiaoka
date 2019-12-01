# 基于数据模型的表单

`Encore\Admin\Form`类用于生成基于数据模型的表单，先来个例子，数据库中有`movies`表

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

对应的数据模型为`App\Models\Movie`，下面的代码可以生成`movies`的数据表单：

```php

use App\Models\Movie;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;

$grid = Admin::form(Movie::class, function(Form $form){

    // 显示记录id
    $form->display('id', 'ID');

    // 添加text类型的input框
    $form->text('title', '电影标题');
    
    $directors = [
        1 => 'John',
        2 => 'Smith',
        3 => 'Kate',
    ];
    
    $form->select('director', '导演')->options($directors);
    
    // 添加describe的textarea输入框
    $form->textarea('describe', '简介');
    
    // 数字输入框
    $form->number('rate', '打分');
    
    // 添加开关操作
    $form->switch('released', '发布？');
    
    // 添加日期时间选择框
    $form->dateTime('release_at', '发布时间');
    
    // 两个时间显示
    $form->display('created_at', '创建时间');
    $form->display('updated_at', '修改时间');
});

```

## 自定义工具

表单右上角默认有返回和跳转列表两个按钮工具, 可以使用下面的方式修改它:

```php
$form->tools(function (Form\Tools $tools) {

    // 去掉返回按钮
    $tools->disableBackButton();
    
    // 去掉跳转列表按钮
    $tools->disableListButton();

    // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
    $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
});
```

## 其它方法

去掉提交按钮:

```php
$form->disableSubmit();
```

去掉重置按钮:
```php
$form->disableReset();
```

忽略掉不需要保存的字段

```php
$form->ignore(['column1', 'column2', 'column3']);
```

设置宽度

```php
$form->setWidth(10, 2);
```

设置表单提交的action

```php
$form->setAction('admin/users');
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

通过下面的代码可以关联在一个form里面:

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
