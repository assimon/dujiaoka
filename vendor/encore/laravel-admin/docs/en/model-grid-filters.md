# Model grid filters

`model-grid`Provides a set of data filters:

```php
$grid->filter(function($filter){

    // Remove the default id filter
    $filter->disableIdFilter();

    // Add a column filter
    $filter->like('name', 'name');
    ...

});

```

## Filter type

Currently supported filter types are the following:

### Equal
`sql: ... WHERE `column` = ""$input""`：
```php
$filter->equal('column', $label);
```

### Not equal
`sql: ... WHERE `column` != ""$input""`：
```php
$filter->notEqual('column', $label);
```

### Like
`sql: ... WHERE `column` LIKE "%"$input"%"`：
```php
$filter->like('column', $label);
```

### Ilike
`sql: ... WHERE `column` ILIKE "%"$input"%"`：
```php
$filter->ilike('column', $label);
```

### Greater then
`sql: ... WHERE `column` > "$input"`：
```php
$filter->gt('column', $label);
```

### Less than
`sql: ... WHERE `column` < "$input"`：
```php
$filter->lt('column', $label);
```

### Between
`sql: ... WHERE `column` BETWEEN "$start" AND "$end"`：
```php
$filter->between('column', $label);

// set datetime field type
$filter->between('column', $label)->datetime();

// set time field type
$filter->between('column', $label)->time();
```

### In
`sql: ... WHERE `column` in (...$inputs)`：
```php
$filter->in('column', $label)->multipleSelect(['key' => 'value']);
```

### NotIn
`sql: ... WHERE `column` not in (...$inputs)`：
```php
$filter->notIn('column', $label)->multipleSelect(['key' => 'value']);
```

### Date
`sql: ... WHERE DATE(`column`) = "$input"`：
```php
$filter->date('column', $label);
```

### Day
`sql: ... WHERE DAY(`column`) = "$input"`：
```php
$filter->day('column', $label);
```

### Month
`sql: ... WHERE MONTH(`column`) = "$input"`：
```php
$filter->month('column', $label);
```

### year
`sql: ... WHERE YEAR(`column`) = "$input"`：
```php
$filter->year('column', $label);
```

### Where

You can use `where` to build more complex query filtering

`sql: ... WHERE `title` LIKE "%$input" OR `content` LIKE "%$input"`：
```php
$filter->where(function ($query) {

    $query->where('title', 'like', "%{$this->input}%")
        ->orWhere('content', 'like', "%{$this->input}%");

}, 'Text');
```

`sql: ... WHERE `rate` >= 6 AND `created_at` = {$input}`:
```php
$filter->where(function ($query) {

    $query->whereRaw("`rate` >= 6 AND `created_at` = {$this->input}");

}, 'Text');
```

Relationship query, query the corresponding relationship `profile` field:
```php
$filter->where(function ($query) {

    $query->whereHas('profile', function ($query) {
        $query->where('address', 'like', "%{$this->input}%")->orWhere('email', 'like', "%{$this->input}%");
    });

}, 'Address or mobile');
```

## Field type

The default field type is text input, set placeholder for text input:

```php
$filter->equal('column')->placeholder('Please input...');
```

You can also restrict the user input format by using some of the following methods:

```php
$filter->equal('column')->url();

$filter->equal('column')->email();

$filter->equal('column')->integer();

$filter->equal('column')->ip();

$filter->equal('column')->mac();

$filter->equal('column')->mobile();

// $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->decimal($options = []);

// $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->currency($options = []);

// $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
$filter->equal('column')->percentage($options = []);

// $options refer to https://github.com/RobinHerbots/Inputmask
$filter->equal('column')->inputmask($options = [], $icon = 'pencil');
```

### Select
```php
$filter->equal('column')->select(['key' => 'value'...]);

// Or from the api to obtain data, api format reference model-form `select` component
$filter->equal('column')->select('api/users');
```

### multipleSelect
Generally used in conjunction with `in` and` notIn` need to query the array of two types of inquiries can also be used in the `type` type of query:
```php
$filter->in('column')->multipleSelect(['key' => 'value'...]);

// // Or from the api to obtain data, api format reference model-form `multipleSelect` component
$filter->in('column')->multipleSelect('api/users');
```

### radio
The more common scenario is the selection of categories

```php
$filter->equal('released')->radio([
    ''   => 'All',
    0    => 'Unreleased',
    1    => 'Released',
]);
```

### checkbox
The more common scene is do the scope query with `whereIn`:

```php
$filter->in('gender')->checkbox([
    'm'    => 'Male',
    'f'    => 'Female',
]);
```

### datetime

Use date and time components,`$options` parameter and value reference [bootstrap-datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/Options/)

```php
$filter->equal('column')->datetime($options);

// `date()` equals to `datetime(['format' => 'YYYY-MM-DD'])`
$filter->equal('column')->date();

// `time()` equals to `datetime(['format' => 'HH:mm:ss'])`
$filter->equal('column')->time();

// `day()` equals to `datetime(['format' => 'DD'])`
$filter->equal('column')->day();

// `month()` equals to `datetime(['format' => 'MM'])`
$filter->equal('column')->month();

// `year()` equals to `datetime(['format' => 'YYYY'])`
$filter->equal('column')->year();

```

## Complex query filter

You can use the `$this->input` to trigger complex custom queries:
```php
$filter->where(function ($query) {
    switch ($this->input) {
        case 'yes':
            // custom complex query if the 'yes' option is selected
            $query->has('somerelationship');
            break;
        case 'no':
            $query->doesntHave('somerelationship');
            break;
    }
}, 'Label of the field', 'name_for_url_shortcut')->radio([
    '' => 'All',
    'yes' => 'Only with relationship',
    'no' => 'Only without relationship',
]);
```
