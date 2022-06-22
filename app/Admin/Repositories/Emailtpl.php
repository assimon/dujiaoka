<?php

namespace App\Admin\Repositories;

use App\Models\Emailtpl as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Emailtpl extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
