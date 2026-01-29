<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    const STATUS_OPEN = 1; // 状态开启
    const STATUS_CLOSE = 0; // 状态关闭

    const AUTOMATIC_DELIVERY = 1; // 自动发货
    const MANUAL_PROCESSING = 2; // 人工处理

    /**
     * map
     *
     * @return array
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public static function getIsOpenMap()
    {
        return [
            self::STATUS_OPEN => admin_trans('dujiaoka.status_open'),
            self::STATUS_CLOSE => admin_trans('dujiaoka.status_close')
        ];
    }

}
