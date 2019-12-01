# Builtin form fields

There are a lots of form components built into the `model-form` to help you quickly build forms.

## Public methods

### Set the value to save
```php
$form->text('title')->value('text...');
```

### Set default value
```php
$form->text('title')->default('text...');
```

### Set help message
```php
$form->text('title')->help('help...');
```

### Set fa-icon class
```php
$form->text('title')->icon('fa-copy');
```

### Set attributes of field element
```php
$form->text('title')->attribute(['data-title' => 'title...']);

$form->text('title')->attribute('data-title', 'title...');
```

### Set placeholder
```php
$form->text('title')->placeholder('Please input...');
```

### Model-form-tab

If the form contains too many fields, will lead to form page is too long, in which case you can use the tab to separate the form:

```php

$form->tab('Basic info', function ($form) {
    
    $form->text('username');
    $form->email('email');
    
})->tab('Profile', function ($form) {
                       
   $form->image('avatar');
   $form->text('address');
   $form->mobile('phone');
   
})->tab('Jobs', function ($form) {
                         
     $form->hasMany('jobs', function () {
         $form->text('company');
         $form->date('start_date');
         $form->date('end_date');
     });

  })

```

## Text input

```php
$form->text($column, [$label]);

// Add a submission validation rule
$form->text($column, [$label])->rules('required|min:10');
```

## Select
```php
$form->select($column[, $label])->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
```

If have too many options, you can load option by ajax:

```php
$form->select('user_id')->options(function ($id) {
    $user = User::find($id);

    if ($user) {
        return [$user->id => $user->name];
    }
})->ajax('/admin/api/users');

// using ajax and show selected item:

$form->select('user_id')->options(User::class)->ajax('/admin/api/users');

// or specifying the name and id

$form->select('user_id')->options(User::class, 'name', 'id')->ajax('/admin/api/users');
```

<sub>Notice：if you have modified the value of the `route.prefix` in the `config/admin.php` file, this api route should be modified to `config('admin.route.prefix').'/api/users'`.</sub>

The controller method for api `/admin/api/users` is:

```php
public function users(Request $request)
{
    $q = $request->get('q');

    return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
}

```

The json returned from api `/admin/demo/options`:
```
{
    "total": 4,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null,
    "from": 1,
    "to": 3,
    "data": [
        {
            "id": 9,
            "text": "xxx"
        },
        {
            "id": 21,
            "text": "xxx"
        },
        {
            "id": 42,
            "text": "xxx"
        },
        {
            "id": 48,
            "text": "xxx"
        }
    ]
}
```

### Select linkage

`select` component supports one-way linkage of parent-child relationship:
```php
$form->select('province')->options(...)->load('city', '/api/city');

$form->select('city');

```

Where `load('city', '/api/city');` means that, after the current select option is changed, the current option will call the api `/api/city` via the argument` q` api returns the data to fill the options for the city selection box, where api `/api/city` returns the data format that must match:

```php
[
    {
        "id": 1,
        "text": "foo"
    },
    {
        "id": 2,
        "text": "bar"
    },
    ...
]
```
The code for the controller action is as follows:

```php
public function city(Request $request)
{
    $provinceId = $request->get('q');

    return ChinaArea::city()->where('parent_id', $provinceId)->get(['id', DB::raw('name as text')]);
}
```

## Multiple select
```php
$form->multipleSelect($column[, $label])->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

// using ajax and show selected items:

$form->multipleSelect($column[, $label])->options(Model::class)->ajax('ajax_url');

// or specifying the name and id

$form->multipleSelect($column[, $label])->options(Model::class, 'name', 'id')->ajax('ajax_url');
```

You can store value of multiple select in two ways, one is `many-to-many` relation.

```

class Post extends Models
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

$form->multipleSelect('tags')->options(Tag::all()->pluck('name', 'id'));

```

The second is to store the option array into a single field. If the field is a string type, it is necessary to define [accessor and Mutator](https://laravel.com/docs/5.5/eloquent-mutators) for the field.

If have too many options, you can load option by ajax

```php
$form->select('user_id')->options(function ($id) {
    $user = User::find($id);

    if ($user) {
        return [$user->id => $user->name];
    }
})->ajax('/admin/api/users');
```

<sub>Notice：If you have modified the value of the `route.prefix` in the `config/admin.php` file, this api route should be modified to `config('admin.route.prefix').'/api/users'`.</sub>

The controller method for api `/admin/api/users` is:

```php
public function users(Request $request)
{
    $q = $request->get('q');

    return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
}

```

The json returned from api `/admin/demo/options`:
```
{
    "total": 4,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "prev_page_url": null,
    "from": 1,
    "to": 3,
    "data": [
        {
            "id": 9,
            "text": "xxx"
        },
        {
            "id": 21,
            "text": "xxx"
        },
        {
            "id": 42,
            "text": "xxx"
        },
        {
            "id": 48,
            "text": "xxx"
        }
    ]
}
```

## Listbox

The usage is as same as mutipleSelect.

```php
$form->listbox($column[, $label])->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
```

## Textarea
```php
$form->textarea($column[, $label])->rows(10);
```

## Radio
```php
$form->radio($column[, $label])->options(['m' => 'Female', 'f'=> 'Male'])->default('m');

$form->radio($column[, $label])->options(['m' => 'Female', 'f'=> 'Male'])->default('m')->stacked();
```

## Checkbox

`checkbox` can store values in two ways, see[multiple select](#Multiple select)

The `options()` method is used to set options:
```php
$form->checkbox($column[, $label])->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

$form->checkbox($column[, $label])->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name'])->stacked();
```

## Email input
```php
$form->email($column[, $label]);
```

## Password input
```php
$form->password($column[, $label]);
```

## URL input
```php
$form->url($column[, $label]);
```

## Ip input
```php
$form->ip($column[, $label]);
```

## Phone number input
```php
$form->mobile($column[, $label])->options(['mask' => '999 9999 9999']);
```

## Color select
```php
$form->color($column[, $label])->default('#ccc');
```

## Time input
```php
$form->time($column[, $label]);

// Set the time format, more formats reference http://momentjs.com/docs/#/displaying/format/    
$form->time($column[, $label])->format('HH:mm:ss');
```

## Date input
```php
$form->date($column[, $label]);

// Date format setting,more format please see http://momentjs.com/docs/#/displaying/format/
$form->date($column[, $label])->format('YYYY-MM-DD');
```

## Datetime input
```php
$form->datetime($column[, $label]);

// Set the date format, more format reference http://momentjs.com/docs/#/displaying/format/
$form->datetime($column[, $label])->format('YYYY-MM-DD HH:mm:ss');
```

## Time range select
`$startTime`、`$endTime`is the start and end time fields:
```php
$form->timeRange($startTime, $endTime, 'Time Range');
```

## Date range select
`$startDate`、`$endDate`is the start and end date fields:
```php
$form->dateRange($startDate, $endDate, 'Date Range');
```

## Datetime range select
`$startDateTime`、`$endDateTime` is the start and end datetime fields:
```php
$form->datetimeRange($startDateTime, $endDateTime, 'DateTime Range');
```

## Currency input
```php
$form->currency($column[, $label]);

// set the unit symbol
$form->currency($column[, $label])->symbol('￥');

```

## Number input
```php
$form->number($column[, $label]);
```

## Rate input
```php
$form->rate($column[, $label]);
```

## Image upload

Before use upload field, you must complete upload configuration, see [image/file upload](/en/model-form-upload.md).

You can use compression, crop, add watermarks and other methods, please refer to [[Intervention] (http://image.intervention.io/getting_started/introduction)], picture upload directory in the file `config / admin.php` `Upload.image` configuration, if the directory does not exist, you need to create the directory and open write permissions:
```php
$form->image($column[, $label]);

// Modify the image upload path and file name
$form->image($column[, $label])->move($dir, $name);

// Crop picture
$form->image($column[, $label])->crop(int $width, int $height, [int $x, int $y]);

// Add a watermark
$form->image($column[, $label])->insert($watermark, 'center');

// add delete button
$form->image($column[, $label])->removable();

```

## File upload

Before use upload field, you must complete upload configuration, see [image/file upload](/en/model-form-upload.md).

The file upload directory is configured in `upload.file` in the file `config/admin.php`. If the directory does not exist, it needs to be created and write-enabled.
```php
$form->file($column[, $label]);

// Modify the file upload path and file name
$form->file($column[, $label])->move($dir, $name);

// And set the upload file type
$form->file($column[, $label])->rules('mimes:doc,docx,xlsx');

// add delete button
$form->file($column[, $label])->removable();

```

## Multiple image/file upload

```php
// multiple image
$form->multipleImage($column[, $label]);

// multiple file
$form->multipleFile($column[, $label]);

// add delete button
$form->multipleFile($column[, $label])->removable();
```

The type of data submitted from multiple image/file field is array, if you the type of column in mysql table is array, or use mongodb, then you can save the array directly, 
but if you use string type to store the array data ,you need to specify a string format, For example, if you want to use json string to store the array data, you need to define
 a mutator for the column in model mutator, such as the field named `pictures`, define mutator:

```php
public function setPicturesAttribute($pictures)
{
    if (is_array($pictures)) {
        $this->attributes['pictures'] = json_encode($pictures);
    }
}

public function getPicturesAttribute($pictures)
{
    return json_decode($pictures, true);
}
```
Of course, you can also specify any other format.

## Map

The map field refers to the network resource, and if there is a problem with the network refer to [form Component Management](/en/model-form-field-management.md) to remove the component.

Used to select the latitude and longitude, `$ latitude`,` $ longitude` for the latitude and longitude field, using Tencent map when `locale` set of laravel is` zh_CN`, otherwise use Google Maps:
```php
$form->map($latitude, $longitude, $label);

// Use Tencent map
$form->map($latitude, $longitude, $label)->useTencentMap();

// Use google map
$form->map($latitude, $longitude, $label)->useGoogleMap();
```

## Slider
Can be used to select the type of digital fields, such as age:
```php
$form->slider($column[, $label])->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => 'years old']);
```
More options please ref to https://github.com/IonDen/ion.rangeSlider#settings

## Rich text editor

The editor field refers to the network resource, and if there is a problem with the network refer to [form Component Management](/en/model-form-field-management.md) to remove the component.

```php
$form->editor($column[, $label]);
```

## Hidden field
```php
$form->hidden($column);
```

## Switch
`On` and` off` pairs of switches with the values `1` and` 0`:
```php
$states = [
    'on'  => ['value' => 1, 'text' => 'enable', 'color' => 'success'],
    'off' => ['value' => 0, 'text' => 'disable', 'color' => 'danger'],
];

$form->switch($column[, $label])->states($states);
```

## Display field
Only display the fields and without any action:
```php
$form->display($column[, $label]);
```

## Divide
```php
$form->divide();
```

## Html
insert html,the argument passed in could be objects which impletements `Htmlable`、`Renderable`, or has method `__toString()`
```php
$form->html('html contents');
```

## Tags
Insert the comma (,) separated string `tags`
```php
$form->tags('keywords');
```

## Icon
Select the `font-awesome` icon.
```php
$form->icon('icon');
```

## HasMany

One-to-many built-in tables for dealing with one-to-many relationships. Here is a simple example:

There are two tables are one-to-many relationship:

```sql
CREATE TABLE `demo_painters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `demo_paintings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `painter_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY painter_id (`painter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

The model of tables are:
```php
<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Model;

class Painter extends Model
{
    public function paintings()
    {
        return $this->hasMany(Painting::class, 'painter_id');
    }
}

<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    protected $fillable = ['title', 'body', 'completed_at'];

    public function painter()
    {
        return $this->belongsTo(Painter::class, 'painter_id');
    }
}
```

Build the form code as follows:
```php
$form->display('id', 'ID');

$form->text('username')->rules('required');
$form->textarea('bio')->rules('required');

$form->hasMany('paintings', function (Form\NestedForm $form) {
    $form->text('title');
    $form->image('body');
    $form->datetime('completed_at');
});

$form->display('created_at', 'Created At');
$form->display('updated_at', 'Updated At');
```

## Embeds

Used to handle the `JSON` type field data of `mysql` or `object` type data of `mongodb`, or the data values of multiple fields can be stored in the form of the` JSON` string in the character type of mysql

Such as the `extra` column of the `JSON` or string type in the orders table, used to store data for multiple fields:

```php
class Order extends Model
{
    protected $casts = [
        'extra' => 'json',
    ];
}
```
And then use in the form:
```php
$form->embeds('extra', function ($form) {

    $form->text('extra1')->rules('required');
    $form->email('extra2')->rules('required');
    $form->mobile('extra3');
    $form->datetime('extra4');

    $form->dateRange('extra5', 'extra6', 'Date range')->rules('required');

});

// Customize the title
$form->embeds('extra', 'Extra', function ($form) {
    ...
});
```

Callback function inside the form element to create the method call and the outside is the same.
