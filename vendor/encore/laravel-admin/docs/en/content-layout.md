# Page content

The layout usage of `laravel-admin` can be found in the `index()` method of the home page's layout file [HomeController.php](https://github.com/z-song/laravel-admin/blob/master/src/Console/stubs/HomeController.stub).

The `Encore\Admin\Layout\Content` class is used to implement the layout of the content area. The `Content::body ($element)` method is used to add page content:

The page code for an unfilled content is as follows：

```php
public function index()
{
    return Admin::content(function (Content $content) {

        // optional
        $content->header('page header');
        
        // optional
        $content->description('page description');

        // add breadcrumb since v1.5.7
        $content->breadcrumb(
            ['text' => 'Dashboard', 'url' => '/admin'],
            ['text' => 'User management', 'url' => '/admin/users'],
            ['text' => 'Edit user']
        );

        // Fill the page body part, you can put any renderable objects here
        $content->body('hello world');
    });
}
```

Method `$content->body();` can accepts any renderable objects, like string, number, class that has method `__toString`,  or implements `Renderable`、`Htmlable` interface , include Laravel View objects.

## Layout

`laravel-admin` use grid system of bootstrap,The length of each line is 12, the following is a few simple examples:

Add a line of content:

```php
$content->row('hello')

---------------------------------
|hello                          |
|                               |
|                               |
|                               |
|                               |
|                               |
---------------------------------

```

Add multiple columns within the line：

```php
$content->row(function(Row $row) {
    $row->column(4, 'foo');
    $row->column(4, 'bar');
    $row->column(4, 'baz');
});
----------------------------------
|foo       |bar       |baz       |
|          |          |          |
|          |          |          |
|          |          |          |
|          |          |          |
|          |          |          |
----------------------------------


$content->row(function(Row $row) {
    $row->column(4, 'foo');
    $row->column(8, 'bar');
});
----------------------------------
|foo       |bar                  |
|          |                     |
|          |                     |
|          |                     |
|          |                     |
|          |                     |
----------------------------------

```

Column in the column：

```php
$content->row(function (Row $row) {

    $row->column(4, 'xxx');

    $row->column(8, function (Column $column) {
        $column->row('111');
        $column->row('222');
        $column->row('333');
    });
});
----------------------------------
|xxx       |111                  |
|          |---------------------|
|          |222                  |
|          |---------------------|
|          |333                  |
|          |                     |
----------------------------------


```


Add rows in rows and add columns：

```php
$content->row(function (Row $row) {

    $row->column(4, 'xxx');

    $row->column(8, function (Column $column) {
        $column->row('111');
        $column->row('222');
        $column->row(function(Row $row) {
            $row->column(6, '444');
            $row->column(6, '555');
        });
    });
});
----------------------------------
|xxx       |111                  |
|          |---------------------|
|          |222                  |
|          |---------------------|
|          |444      |555        |
|          |         |           |
----------------------------------
```

Add body into a page：

Create a blade view file inside `/project/resources/views/admin/custom.blade.php`

```php
    public function customPage($id)
    {
        $content = new Content();
        $content->header('View');
        $content->description('Description...');
        $content->body('admin.custom',['id' => $id]);
        return $content;
    }
```
