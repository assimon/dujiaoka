# 自定义登陆

如果不使用`laravel-admin`内置的认证登陆逻辑，可以参考下面的方式自定义登陆认证逻辑

首先要先定义一个`user provider`，用来获取用户身份, 比如`app/Providers/CustomUserProvider.php`：

```php
<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {}

    public function retrieveByToken($identifier, $token)
    {}

    public function updateRememberToken(Authenticatable $user, $token)
    {}

    public function retrieveByCredentials(array $credentials)
    {
        // 用$credentials里面的用户名密码去获取用户信息，然后返回Illuminate\Contracts\Auth\Authenticatable对象
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // 用$credentials里面的用户名密码校验用户，返回true或false
    }
}

```

在方法`retrieveByCredentials`和`validateCredentials`中, 传入的`$credentials`就是登陆页面提交的用户名和密码数组，然后你可以使用`$credentials`去实现自己的登陆逻辑

Interface `Illuminate\Contracts\Auth\Authenticatable`的定义如下：
```php
<?php

namespace Illuminate\Contracts\Auth;

interface Authenticatable {

    public function getAuthIdentifierName();
    public function getAuthIdentifier();
    public function getAuthPassword();
    public function getRememberToken();
    public function setRememberToken($value);
    public function getRememberTokenName();

}
```

上面interface每个方法的解释参考[adding-custom-user-providers](https://laravel.com/docs/5.5/authentication#adding-custom-user-providers)

定义好了`User provider`之后，打开`app/Providers/AuthServiceProvider.php`注册它：

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config) {
            
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new CustomUserProvider();
        });
    }
}
```

最后修改一下配置,打开`config/admin.php`，找到`auth`部分修改:

```php
    'auth' => [
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ]
        ],

        // 修改下面
        'providers' => [
            'admin' => [
                'driver' => 'custom',
            ]
        ],
    ],
```
这样就完成了自定义登陆认证的逻辑，自定义登陆算是laravel中比较复杂的部分，需要开发者有耐心的一步步调试完成。

