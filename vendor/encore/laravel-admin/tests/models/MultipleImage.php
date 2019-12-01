<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleImage extends Model
{
    protected $table = 'test_multiple_images';

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true) ?: [];
    }
}
