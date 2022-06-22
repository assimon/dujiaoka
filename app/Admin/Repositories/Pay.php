<?php

namespace App\Admin\Repositories;

use App\Models\Pay as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Pay extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
