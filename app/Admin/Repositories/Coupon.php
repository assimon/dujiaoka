<?php

namespace App\Admin\Repositories;

use App\Models\Coupon as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Coupon extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
