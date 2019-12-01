# Custom tools

`model-grid` has `batch delete` and `refresh` operations tools as default, `model-grid` provides custom tool functionality if there are more operational requirements, the following example will show you how to add a `Gender selector` button group tool.

First define the tool class `app/Admin/Extensions/Tools/UserGender.php`：

```php
<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class UserGender extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['gender' => '_gender_']);

        return <<<EOT
    
$('input:radio.user-gender').change(function () {

    var url = "$url".replace('_gender_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'all'   => 'All',
            'm'     => 'Male',
            'f'     => 'Female',
        ];

        return view('admin.tools.gender', compact('options'));
    }
}

```
The blade file of view `admin.tools.gender` is `resources/views/admin/tools/gender.blade.php`:
```php
<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
    <label class="btn btn-default btn-sm {{ \Request::get('gender', 'all') == $option ? 'active' : '' }}">
        <input type="radio" class="user-gender" value="{{ $option }}">{{$label}}
    </label>
    @endforeach
</div>
```

Import this tool in `model-grid`：
```php

$grid->tools(function ($tools) {
    $tools->append(new UserGender());
});

```

In the `model-grid`, pass `gender` query to model：
```php
if (in_array(Request::get('gender'), ['m', 'f'])) {
    $grid->model()->where('gender', Request::get('gender'));
}
```

You can refer to the above way to add your own tools.

## Batch operation

At present, the default implementation of the batch delete operation, if you want to turn off the batch delete operation:
```php
$grid->tools(function ($tools) {
    $tools->batch(function ($batch) {
        $batch->disableDelete();
    });
});

```

If you want to add a custom batch operation, you can refer to the following example.

The following example will show you how to implements a `post batch release` operation:

First define the tool class `app/Admin/Extensions/Tools/ReleasePost.php`：
```php
<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class ReleasePost extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }
    
    public function script()
    {
        return <<<EOT
        
$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '{$this->resource}/release',
        data: {
            _token:LA.token,
            ids: selectedRows(),
            action: {$this->action}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
```

See the code above, use ajax to pass the selected `ids` to back-end api through a POST request, the back-end api modifies the state of the corresponding data according to the received `ids`, and then front-end refresh the page (pjax reload), and pop-up a `toastr` prompt operation is successful.

Import this operation in `model-grid`：
```php
$grid->tools(function ($tools) {
    $tools->batch(function ($batch) {
        $batch->add('Release post', new ReleasePost(1));
        $batch->add('Unrelease post', new ReleasePost(0));
    });
});
```

So that the batch operation of the drop-down button will add the following two operations, the final step is to add an api to handle the request of the batch operation, the api code is as follows:
```php

class PostController extends Controller
{
    ...
    
    public function release(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->released = $request->get('action');
            $post->save();
        }
    }
    
    ...
}
```

Then add a route for the api above:
```php
$router->post('posts/release', 'PostController@release');
```

This completes the entire process.