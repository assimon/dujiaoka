# 模型表单回调

`model-form`目前提供了两个方法来接收回调函数：

```php
//保存前回调
$form->saving(function (Form $form) {
    //...
});

//保存后回调
$form->saved(function (Form $form) {
    //...
});

```
可以从回调参数`$form`中获取当前提交的表单数据：

```php
$form->saving(function (Form $form) {

    dump($form->username);

});

```

获取获取模型中的数据
```php
$form->saved(function (Form $form) {

    $form->model()->id;

});
```

可以直接在回调中返回`Symfony\Component\HttpFoundation\Response`的实例，来跳转或进入页面：
```php
$form->saving(function (Form $form) {

    // 返回一个简单response
    return response('xxxx');

});

$form->saving(function (Form $form) {

    // 跳转页面
    return redirect('/admin/users');

});

$form->saving(function (Form $form) {

    // 抛出异常
    throw new \Exception('出错啦。。。');

});

```

返回错误或者成功信息在页面上：

```php
use Illuminate\Support\MessageBag;

// 抛出错误信息
$form->saving(function ($form) {

    $error = new MessageBag([
        'title'   => 'title...',
        'message' => 'message....',
    ]);

    return back()->with(compact('error'));
});

// 抛出成功信息
$form->saving(function ($form) {

    $success = new MessageBag([
        'title'   => 'title...',
        'message' => 'message....',
    ]);

    return back()->with(compact('success'));
});

```