<?php

namespace Tests\Seeds;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Tests\Models\User::class, 50)
            ->create()
            ->each(function ($u) {
                $u->profile()->save(factory(\Tests\Models\Profile::class)->make());
                $u->tags()->saveMany(factory(\Tests\Models\Tag::class, 5)->make());
            });
    }
}
