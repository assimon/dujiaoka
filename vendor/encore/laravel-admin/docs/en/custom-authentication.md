# Custom authentication

If you do not use the `laravel-admin` built-in authentication login logic, you can refer to the following way to customize the login authentication logic.

First of all, you need define a `User provider`, used to obtain the user identity, such as `app/Providers/CustomUserProvider.php`:

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
        // Use $credentials to get the user data, and then return an object implements interface `Illuminate\Contracts\Auth\Authenticatable` 
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Verify the user with the username password in $ credentials, return `true` or `false`
    }
}

```

In the methods `retrieveByCredentials` and `validateCredentials` the parameter `$credentials` is the user name and password array submitted on the login page, you can use `$credentials` to implement your own login logic.

The definition of interface `Illuminate\Contracts\Auth\Authenticatable`:
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

For more details about custom authentication please refer to [adding-custom-user-providers](https://laravel.com/docs/5.5/authentication#adding-custom-user-providers).


After you created cusom user provider, you will need to extend Laravel with it:

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

Finally modify the configuration, open `config/admin.php`, find the `auth` part:

```php
    'auth' => [
        'guards' => [
            'admin' => [
                'driver' => 'session',
                'provider' => 'admin',
            ]
        ],

        // Modify the following
        'providers' => [
            'admin' => [
                'driver' => 'custom',
            ]
        ],
    ],
```
This completes the logic of custom authentication.
