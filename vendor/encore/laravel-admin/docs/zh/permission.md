# 权限控制

`laravel-admin`已经内置了`RBAC`权限控制模块，展开左侧边栏的`Auth`，下面有用户、角色、权限三项的管理面板，权限控制的使用如下：

## 路由控制

在`laravel-admin 1.5`中，权限和路由是绑定在一起的，在编辑权限页面里面设置当前权限能访问的路由，在`HTTP方法`select框中选择访问路由的方法，在`HTTP路径`textarea中填写能访问的路径。

比如要添加一个权限，该权限可以以`GET`方式访问路径`/admin/users`，那么`HTTP方法`选择`GET`，`HTTP路径`填写`/users`。

如果要访问前缀是`/admin/users`的所有路径，那么`HTTP路径`填写`/users*`，如果权限包括多个访问路径，换行填写每条路径。

## 页面控制

如果你要在页面中控制用户的权限，可以参考下面的例子

### 场景1

比如现在有一个场景，对文章发布模块做权限管理，以创建文章为例

首先创建一项权限，进入`http://localhost/admin/auth/permissions`，权限标识（slug）填写`create-post`，权限名称填写`创建文章`，这样权限就创建好了。
第二步可以把这个权限直接附加给个人或者角色，在用户编辑页面可以直接把上面创建好的权限附加给当前编辑用户，也可以在编辑角色页面附加给某个角色。
第三步，在创建文章控制器里面添加控制代码：
```php
use Encore\Admin\Auth\Permission;

class PostController extends Controller
{
    public function create()
    {
        // 检查权限，有create-post权限的用户或者角色可以访问创建文章页面
        Permission::check('create-post');
    }
}
```
这样就完成了一个页面的权限控制。

### 场景2

如果你要在表格中控制用户对元素的显示，那么需要先定义两个权限，比如权限标示`delete-image`、和`view-title-column`分别用来控制有删除图片的权限和显示某一列的权限，把这两个权限赋给你设置的角色，然后在grid中加入代码：
```php
$grid->actions(function ($actions) {

    // 没有`delete-image`权限的角色不显示删除按钮
    if (!Admin::user()->can('delete-image')) {
        $actions->disableDelete();
    }
});

// 只有具有`view-title-column`权限的用户才能显示`title`这一列
if (Admin::user()->can('view-title-column')) {
    $grid->column('title');
}
```

## 相关方法

获取当前用户对象
```php
Admin::user();
```

获取当前用户id
```php
Admin::user()->id;
```

获取用户角色
```php
Admin::user()->roles;
```

获取用户的权限
```php
Admin::user()->permissions;
```

用户是否某个角色
```php
Admin::user()->isRole('developer');
```

是否有某个权限
```php
Admin::user()->can('create-post');
```

是否没有某个权限
```php
Admin::user()->cannot('delete-post');
```

是否是超级管理员
```php
Admin::user()->isAdministrator();
```

是否是其中的角色
```php
Admin::user()->inRoles(['editor', 'developer']);
```

## 权限中间件

可以在路由配置上结合权限中间件来控制路由的权限

```php

// 允许administrator、editor两个角色访问group里面的路由
Route::group([
    'middleware' => 'admin.permission:allow,administrator,editor',
], function ($router) {

    $router->resource('users', UserController::class);
    ...
    
});

// 禁止developer、operator两个角色访问group里面的路由
Route::group([
    'middleware' => 'admin.permission:deny,developer,operator',
], function ($router) {

    $router->resource('users', UserController::class);
    ...
    
});

// 有edit-post、create-post、delete-post三个权限的用户可以访问group里面的路由
Route::group([
    'middleware' => 'admin.permission:check,edit-post,create-post,delete-post',
], function ($router) {

    $router->resource('posts', PostController::class);
    ...
    
});
```

权限中间件和其它中间件使用方法一致。

