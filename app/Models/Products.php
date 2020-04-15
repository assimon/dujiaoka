<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{

    use SoftDeletes;

    /**
     * 关联分类表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classify()
    {
        return $this->belongsTo(Classifys::class, 'pd_class');
    }





}
