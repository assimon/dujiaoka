# Customize the head navigation bar

Since version `1.5.6`, you can add the html element to the top navigation bar, open `app/Admin/bootstrap.php`:
```php
use Encore\Admin\Facades\Admin;

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    $navbar->left('html...');

    $navbar->right('html...');

});
```

Methods `left` and `right` are used to add content to the left and right sides of the head, the method parameters can be any object that can be rendered (objects which impletements `Htmlable`, `Renderable`, or has method `__toString()`) or strings.

## Add elements to the left

For example, add a search bar on the left, first create a view `resources/views/search-bar.blade.php`:
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
Then add it to the head navigation bar:
```php
$navbar->left(view('search-bar'));
```

## Add elements to the right

You can only add the `<li>` tag on the right side of the navigation, such as adding some prompt icons, creating a new rendering class `app/Admin/Extensions/Nav/Links.php`
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

Then add it to the head navigation bar:
```php
$navbar->right(new \App\Admin\Extensions\Nav\Links());
```

Or use the following html to add a drop-down menu:
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

More components can be found here [Bootstrap](https://getbootstrap.com/)
