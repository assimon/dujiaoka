<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webset extends Model
{
    protected $table = "webset";

    public static function loadWebset()
    {
        $config = self::where('id', 1)->first()->toArray();
        foreach ($config as $key => $value) {
            config(['webset.' . $key => $value]);
        }
    }

}
