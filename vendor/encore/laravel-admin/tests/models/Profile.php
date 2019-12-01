<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'test_user_profiles';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
