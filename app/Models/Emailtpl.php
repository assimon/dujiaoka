<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Emailtpl extends Model
{

    use SoftDeletes;

    protected $table = 'emailtpls';

}
