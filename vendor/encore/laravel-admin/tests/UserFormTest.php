<?php

use Encore\Admin\Auth\Database\Administrator;
use Tests\Models\User as UserModel;

class UserFormTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->be(Administrator::first(), 'admin');
    }

    public function testCreatePage()
    {
        $this->visit('admin/users/create')
            ->seeElement('input[type=text][name=username]')
            ->seeElement('input[type=email][name=email]')
            ->seeElement('input[type=text][name=mobile]')
            ->seeElement('input[type=file][name=avatar]')
            ->seeElement('hr')
            ->seeElement("input[type=text][name='profile[first_name]']")
            ->seeElement("input[type=text][name='profile[last_name]']")
            ->seeElement("input[type=text][name='profile[postcode]']")
            ->seeElement("textarea[name='profile[address]'][rows=15]")
            ->seeElement("input[type=hidden][name='profile[latitude]']")
            ->seeElement("input[type=hidden][name='profile[longitude]']")
            ->seeElement("input[type=text][name='profile[color]']")
            ->seeElement("input[type=text][name='profile[start_at]']")
            ->seeElement("input[type=text][name='profile[end_at]']")
            ->seeElement('span[class=help-block] i[class*=fa-info-circle]')
            ->seeInElement('span[class=help-block]', 'Please input your postcode')
            ->seeElement('span[class=help-block] i[class*=fa-image]')
            ->seeInElement('span[class=help-block]', '上传头像')
            ->seeElement("select[name='tags[]'][multiple=multiple]")
            ->seeInElement('a[html-field]', 'html...');
    }

    public function testSubmitForm()
    {
        $data = [
            'username'              => 'John Doe',
            'email'                 => 'hello@world.com',
            'mobile'                => '13421234123',
            'password'              => '123456',
            'password_confirmation' => '123456',
            //"avatar"   => "test.jpg",
            'profile' => [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'postcode'   => '123456',
                'address'    => 'Jinshajiang RD',
                'latitude'   => '131.2123123456',
                'longitude'  => '21.342123456',
                'color'      => '#ffffff',
                'start_at'   => date('Y-m-d H:i:s', time()),
                'end_at'     => date('Y-m-d H:i:s', time()),
            ],
        ];

        $this->visit('admin/users/create')
            ->attach(__DIR__.'/assets/test.jpg', 'avatar')

            ->submitForm('Submit', $data)
            ->seePageIs('admin/users')
            ->seeInElement('td', 1)
            ->seeInElement('td', $data['username'])
            ->seeInElement('td', $data['email'])
            ->seeInElement('td', $data['mobile'])
            ->seeInElement('td', "{$data['profile']['first_name']} {$data['profile']['last_name']}")
            ->seeElement('td img')
            ->seeInElement('td', $data['profile']['postcode'])
            ->seeInElement('td', $data['profile']['address'])
            ->seeInElement('td', "{$data['profile']['latitude']} {$data['profile']['longitude']}")
            ->seeInElement('td', $data['profile']['color'])
            ->seeInElement('td', $data['profile']['start_at'])
            ->seeInElement('td', $data['profile']['end_at']);

        $this->assertCount(1, UserModel::all());

        $this->seeInDatabase('test_users', ['username' => $data['username']]);
        $this->seeInDatabase('test_users', ['email' => $data['email']]);
        $this->seeInDatabase('test_users', ['mobile' => $data['mobile']]);
        $this->seeInDatabase('test_users', ['password' => $data['password']]);

        $this->seeInDatabase('test_user_profiles', ['first_name' => $data['profile']['first_name']]);
        $this->seeInDatabase('test_user_profiles', ['last_name' => $data['profile']['last_name']]);
        $this->seeInDatabase('test_user_profiles', ['postcode' => $data['profile']['postcode']]);
        $this->seeInDatabase('test_user_profiles', ['address' => $data['profile']['address']]);
        $this->seeInDatabase('test_user_profiles', ['latitude' => $data['profile']['latitude']]);
        $this->seeInDatabase('test_user_profiles', ['longitude' => $data['profile']['longitude']]);
        $this->seeInDatabase('test_user_profiles', ['color' => $data['profile']['color']]);
        $this->seeInDatabase('test_user_profiles', ['start_at' => $data['profile']['start_at']]);
        $this->seeInDatabase('test_user_profiles', ['end_at' => $data['profile']['end_at']]);

        $avatar = UserModel::first()->avatar;

        $this->assertFileExists(public_path('uploads/'.$avatar));
    }

    protected function seedsTable($count = 100)
    {
        factory(\Tests\Models\User::class, $count)
            ->create()
            ->each(function ($u) {
                $u->profile()->save(factory(\Tests\Models\Profile::class)->make());
                $u->tags()->saveMany(factory(\Tests\Models\Tag::class, 5)->make());
            });
    }

    public function testEditForm()
    {
        $this->seedsTable(10);

        $id = rand(1, 10);

        $user = UserModel::with('profile')->find($id);

        $this->visit("admin/users/$id/edit")
            ->seeElement("input[type=text][name=username][value='{$user->username}']")
            ->seeElement("input[type=email][name=email][value='{$user->email}']")
            ->seeElement("input[type=text][name=mobile][value='{$user->mobile}']")
            ->seeElement('hr')
            ->seeElement("input[type=text][name='profile[first_name]'][value='{$user->profile->first_name}']")
            ->seeElement("input[type=text][name='profile[last_name]'][value='{$user->profile->last_name}']")
            ->seeElement("input[type=text][name='profile[postcode]'][value='{$user->profile->postcode}']")
            ->seeInElement("textarea[name='profile[address]']", $user->profile->address)
            ->seeElement("input[type=hidden][name='profile[latitude]'][value='{$user->profile->latitude}']")
            ->seeElement("input[type=hidden][name='profile[longitude]'][value='{$user->profile->longitude}']")
            ->seeElement("input[type=text][name='profile[color]'][value='{$user->profile->color}']")
            ->seeElement("input[type=text][name='profile[start_at]'][value='{$user->profile->start_at}']")
            ->seeElement("input[type=text][name='profile[end_at]'][value='{$user->profile->end_at}']")
            ->seeElement("select[name='tags[]'][multiple=multiple]");

        $this->assertCount(50, $this->crawler()->filter("select[name='tags[]'] option"));
        $this->assertCount(5, $this->crawler()->filter("select[name='tags[]'] option[selected]"));
    }

    public function testUpdateForm()
    {
        $this->seedsTable(10);

        $id = rand(1, 10);

        $this->visit("admin/users/$id/edit")
            ->type('hello world', 'username')
            ->type('123', 'password')
            ->type('123', 'password_confirmation')
            ->press('Submit')
            ->seePageIs('admin/users')
            ->seeInDatabase('test_users', ['username' => 'hello world']);

        $user = UserModel::with('profile')->find($id);

        $this->assertEquals($user->username, 'hello world');
    }

    public function testUpdateFormWithRule()
    {
        $this->seedsTable(10);

        $id = rand(1, 10);

        $this->visit("admin/users/$id/edit")
            ->type('', 'email')
            ->press('Submit')
            ->seePageIs("admin/users/$id/edit")
            ->see('The email field is required');

        $this->type('xxaxx', 'email')
            ->press('Submit')
            ->seePageIs("admin/users/$id/edit")
            ->see('The email must be a valid email address.');

        $this->visit("admin/users/$id/edit")
            ->type('123', 'password')
            ->type('1234', 'password_confirmation')
            ->press('Submit')
            ->seePageIs("admin/users/$id/edit")
            ->see('The Password confirmation does not match.');

        $this->type('xx@xx.xx', 'email')
            ->type('123', 'password')
            ->type('123', 'password_confirmation')
            ->press('Submit')
            ->seePageIs('admin/users')
            ->seeInDatabase('test_users', ['email' => 'xx@xx.xx']);
    }

    public function testFormHeader()
    {
        $this->seedsTable(1);

        $this->visit('admin/users/1/edit')
            ->seeInElement('a[class*=btn-danger]', 'Delete')
            ->seeInElement('a[class*=btn-default]', 'List')
            ->seeInElement('a[class*=btn-primary]', 'View');
    }

    public function testFormFooter()
    {
        $this->seedsTable(1);

        $this->visit('admin/users/1/edit')
            ->seeElement('input[type=checkbox][value=1]')
            ->seeElement('input[type=checkbox][value=2]');
    }
}
