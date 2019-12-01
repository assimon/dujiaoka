Form validation
========

`model-form` uses laravel's validation rules to verify the data submitted by the form:

```php
$form->text('title')->rules('required|min:3');

// Complex validation rules can be implemented in the callback
$form->text('title')->rules(function ($form) {
    
    // If it is not an edit state, add field unique verification
    if (!$id = $form->model()->id) {
        return 'unique:users,email_address';
    }
    
});

```

You can also customize the error message for the validation rule:

```php
$form->text('code')->rules('required|regex:/^\d+$/|min:10', [
    'regex' => 'code must be numbers',
    'min'   => 'code can not be less than 10 characters',
]);
```

If you want to allow the field to be empty, first in the database table to face the field set to `NULL`, and then

```php
$form->text('title')->rules('nullable');
```

Please refer to the more rules [Validation](https://laravel.com/docs/5.5/validation).