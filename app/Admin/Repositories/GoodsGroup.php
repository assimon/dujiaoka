<?php

namespace App\Admin\Repositories;

use App\Models\GoodsGroup as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class GoodsGroup extends EloquentRepository
{

    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
