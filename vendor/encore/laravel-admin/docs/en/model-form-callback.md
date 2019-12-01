# Model form callback

`model-form` currently has three methods for receiving callback functions:

```php
// callback after form submission
$form->submitted(function (Form $form) {
    //...
});

// callback before save
$form->saving(function (Form $form) {
    //...
});

// callback after save
$form->saved(function (Form $form) {
    //...
});

```
If required, you can add additional fields to ignore using the submitted function e.g.
```php
$form->submitted(function (Form $form) {
    $form->ignore('username');

});

```
The form data that is currently submitted can be retrieved from the callback parameter `$form`:

```php
$form->saving(function (Form $form) {

    dump($form->username);

});

```

Get data in model
```php
$form->saved(function (Form $form) {

    $form->model()->id;

});
```

Can redirect other urls by returning an instance of `Symfony\Component\HttpFoundation\Response` directly in the callback:

```php
$form->saving(function (Form $form) {

    // returns a simple response
    return response('xxxx');

});

$form->saving(function (Form $form) {

    // redirect url
    return redirect('/admin/users');

});

$form->saving(function (Form $form) {

    // throws an exception
    throw new \Exception('Error friends. . .');

});

```

Return error or success information on the page:

```php
use Illuminate\Support\MessageBag;

// redirect back with an error message
$form->saving(function ($form) {

    $error = new MessageBag([
        'title'   => 'title...',
        'message' => 'message....',
    ]);

    return back()->with(compact('error'));
});

// redirect back with a successful message
$form->saving(function ($form) {

    $success = new MessageBag([
        'title'   => 'title...',
        'message' => 'message....',
    ]);

    return back()->with(compact('success'));
});

```
