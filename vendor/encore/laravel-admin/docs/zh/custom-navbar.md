# 自定义头部导航条

从版本`1.5.6`开始，可以在顶部导航条上添加html元素了,  打开`app/Admin/bootstrap.php`：
```php
use Encore\Admin\Facades\Admin;

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    $navbar->left('html...');

    $navbar->right('html...');

});
```

`left`和`right`方法分别用来在头部的左右两边添加内容，方法参数可以是任何可以渲染的对象(实现了`Htmlable`、`Renderable`接口或者包含`__toString()`方法的对象)或字符串

## 左侧添加示例

举个例子，比如在左边添加一个搜索条，先创建一个blade视图`resources/views/search-bar.blade.php`：
```php
<style>

.search-form {
    width: 250px;
    margin: 10px 0 0 20px;
    border-radius: 3px;
    float: left;
}
.search-form input[type="text"] {
    color: #666;
    border: 0;
}

.search-form .btn {
    color: #999;
    background-color: #fff;
    border: 0;
}

</style>

<form action="/admin/posts" method="get" class="search-form" pjax-container>
    <div class="input-group input-group-sm ">
        <input type="text" name="title" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
    </div>
</form>
```
然后加入头部导航条：
```php
$navbar->left(view('search-bar'));
```

## 右侧添加示例

导航右侧只能添加`<li>`标签, 比如要添加一些提示图标，新建渲染对象`app/Admin/Extensions/Nav/Links.php`
```php
<?php

namespace App\Admin\Extensions\Nav;

class Links
{
    public function __toString()
    {
        return <<<HTML

<li>
    <a href="#">
      <i class="fa fa-envelope-o"></i>
      <span class="label label-success">4</span>
    </a>
</li>

<li>
    <a href="#">
      <i class="fa fa-bell-o"></i>
      <span class="label label-warning">7</span>
    </a>
</li>

<li>
    <a href="#">
      <i class="fa fa-flag-o"></i>
      <span class="label label-danger">9</span>
    </a>
</li>

HTML;
    }
}
```

然后加入头部导航条：
```php
$navbar->right(new \App\Admin\Extensions\Nav\Links());
```

或者用下面的html加入下拉菜单：
```html
<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
  <i class="fa fa-bell-o"></i>
  <span class="label label-warning">10</span>
</a>
<ul class="dropdown-menu">
  <li class="header">You have 10 notifications</li>
  <li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
      <li>
        <a href="#">
          <i class="fa fa-users text-aqua"></i> 5 new members joined today
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
          page and may cause design problems
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-users text-red"></i> 5 new members joined
        </a>
      </li>

      <li>
        <a href="#">
          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-user text-red"></i> You changed your username
        </a>
      </li>
    </ul>
  </li>
  <li class="footer"><a href="#">View all</a></li>
</ul>
</li>
```

更多的组件可以参考[Bootstrap](https://getbootstrap.com/)