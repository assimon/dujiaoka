<?php

use Encore\Admin\Auth\Database\Administrator;
use Tests\Models\Profile as ProfileModel;
use Tests\Models\User as UserModel;

class UserGridTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->be(Administrator::first(), 'admin');
    }

    public function testIndexPage()
    {
        $this->visit('admin/users')
            ->see('All users')
            ->seeInElement('tr th', 'Username')
            ->seeInElement('tr th', 'Email')
            ->seeInElement('tr th', 'Mobile')
            ->seeInElement('tr th', 'Full name')
            ->seeInElement('tr th', 'Avatar')
            ->seeInElement('tr th', 'Post code')
            ->seeInElement('tr th', 'Address')
            ->seeInElement('tr th', 'Position')
            ->seeInElement('tr th', 'Color')
            ->seeInElement('tr th', '开始时间')
            ->seeInElement('tr th', '结束时间')
            ->seeInElement('tr th', 'Color')
            ->seeInElement('tr th', 'Created at')
            ->seeInElement('tr th', 'Updated at');

        $action = url('/admin/users');

        $this->seeElement("form[action='$action'][method=get]")
            ->seeElement("form[action='$action'][method=get] input[name=id]")
            ->seeElement("form[action='$action'][method=get] input[name=username]")
            ->seeElement("form[action='$action'][method=get] input[name=email]")
            ->seeElement("form[action='$action'][method=get] input[name='profile[start_at][start]']")
            ->seeElement("form[action='$action'][method=get] input[name='profile[start_at][end]']")
            ->seeElement("form[action='$action'][method=get] input[name='profile[end_at][start]']")
            ->seeElement("form[action='$action'][method=get] input[name='profile[end_at][end]']");

        $urlAll = url('/admin/users?_export_=all');
        $urlNew = url('/admin/users/create');
        $this->seeInElement("a[href=\"{$urlAll}\"]", 'All')
            ->seeInElement("a[href=\"{$urlNew}\"]", 'New');
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

    public function testGridWithData()
    {
        $this->seedsTable();

        $this->visit('admin/users')
            ->see('All users');

        $this->assertCount(100, UserModel::all());
        $this->assertCount(100, ProfileModel::all());
    }

    public function testGridPagination()
    {
        $this->seedsTable(65);

        $this->visit('admin/users')
            ->see('All users');

        $this->visit('admin/users?page=2');
        $this->assertCount(20, $this->crawler()->filter('td a i[class*=fa-edit]'));

        $this->visit('admin/users?page=3');
        $this->assertCount(20, $this->crawler()->filter('td a i[class*=fa-edit]'));

        $this->visit('admin/users?page=4');
        $this->assertCount(5, $this->crawler()->filter('td a i[class*=fa-edit]'));

        $this->click(1)->seePageIs('admin/users?page=1');
        $this->assertCount(20, $this->crawler()->filter('td a i[class*=fa-edit]'));
    }

    public function testEqualFilter()
    {
        $this->seedsTable(50);

        $this->visit('admin/users')
            ->see('All users');

        $this->assertCount(50, UserModel::all());
        $this->assertCount(50, ProfileModel::all());

        $id = rand(1, 50);

        $user = UserModel::find($id);

        $this->visit('admin/users?id='.$id)
            ->seeInElement('td', $user->username)
            ->seeInElement('td', $user->email)
            ->seeInElement('td', $user->mobile)
            ->seeElement("img[src='{$user->avatar}']")
            ->seeInElement('td', "{$user->profile->first_name} {$user->profile->last_name}")
            ->seeInElement('td', $user->postcode)
            ->seeInElement('td', $user->address)
            ->seeInElement('td', "{$user->profile->latitude} {$user->profile->longitude}")
            ->seeInElement('td', $user->color)
            ->seeInElement('td', $user->start_at)
            ->seeInElement('td', $user->end_at);
    }

    public function testLikeFilter()
    {
        $this->seedsTable(50);

        $this->visit('admin/users')
            ->see('All users');

        $this->assertCount(50, UserModel::all());
        $this->assertCount(50, ProfileModel::all());

        $users = UserModel::where('username', 'like', '%mi%')->get();

        $this->visit('admin/users?username=mi');

        $this->assertCount($this->crawler()->filter('table tr')->count() - 1, $users);

        foreach ($users as $user) {
            $this->seeInElement('td', $user->username);
        }
    }

    public function testFilterRelation()
    {
        $this->seedsTable(50);

        $user = UserModel::with('profile')->find(rand(1, 50));

        $this->visit('admin/users?email='.$user->email)
            ->seeInElement('td', $user->username)
            ->seeInElement('td', $user->email)
            ->seeInElement('td', $user->mobile)
            ->seeElement("img[src='{$user->avatar}']")
            ->seeInElement('td', "{$user->profile->first_name} {$user->profile->last_name}")
            ->seeInElement('td', $user->postcode)
            ->seeInElement('td', $user->address)
            ->seeInElement('td', "{$user->profile->latitude} {$user->profile->longitude}")
            ->seeInElement('td', $user->color)
            ->seeInElement('td', $user->start_at)
            ->seeInElement('td', $user->end_at);
    }

    public function testDisplayCallback()
    {
        $this->seedsTable(1);

        $user = UserModel::with('profile')->find(1);

        $this->visit('admin/users')
            ->seeInElement('th', 'Column1 not in table')
            ->seeInElement('th', 'Column2 not in table')
            ->seeInElement('td', "full name:{$user->profile->first_name} {$user->profile->last_name}")
            ->seeInElement('td', "{$user->email}#{$user->profile->color}");
    }

    public function testHasManyRelation()
    {
        factory(\Tests\Models\User::class, 10)
            ->create()
            ->each(function ($u) {
                $u->profile()->save(factory(\Tests\Models\Profile::class)->make());
                $u->tags()->saveMany(factory(\Tests\Models\Tag::class, 5)->make());
            });

        $this->visit('admin/users')
            ->seeElement('td code');

        $this->assertCount(50, $this->crawler()->filter('td code'));
    }

    public function testGridActions()
    {
        $this->seedsTable(15);

        $this->visit('admin/users');

        $this->assertCount(15, $this->crawler()->filter('td a i[class*=fa-edit]'));
        $this->assertCount(15, $this->crawler()->filter('td a i[class*=fa-trash]'));
    }

    public function testGridRows()
    {
        $this->seedsTable(10);

        $this->visit('admin/users')
            ->seeInElement('td a[class*=btn]', 'detail');

        $this->assertCount(5, $this->crawler()->filter('td a[class*=btn]'));
    }

    public function testGridPerPage()
    {
        $this->seedsTable(98);

        $this->visit('admin/users')
            ->seeElement('select[class*=per-page][name=per-page]')
            ->seeInElement('select option', 10)
            ->seeInElement('select option[selected]', 20)
            ->seeInElement('select option', 30)
            ->seeInElement('select option', 50)
            ->seeInElement('select option', 100);

        $this->assertEquals('http://localhost:8000/admin/users?per_page=20', $this->crawler()->filter('select option[selected]')->attr('value'));

        $perPage = rand(1, 98);

        $this->visit('admin/users?per_page='.$perPage)
            ->seeInElement('select option[selected]', $perPage)
            ->assertCount($perPage + 1, $this->crawler()->filter('tr'));
    }
}
