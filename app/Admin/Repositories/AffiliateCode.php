<?php

namespace App\Admin\Repositories;

use App\Models\AffiliateCode as Model;
use Dcat\Admin\Repositories\EloquentRepository;

/**
 * 推广码 Repository
 *
 * 为 Dcat Admin 管理后台提供推广码数据访问层。
 * 连接 AffiliateCode 模型，支持 CRUD 操作。
 *
 * @author assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link http://utf8.hk/
 */
class AffiliateCode extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
