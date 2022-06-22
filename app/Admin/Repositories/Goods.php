<?php

namespace App\Admin\Repositories;

use App\Models\Goods as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Goods extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
