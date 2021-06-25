<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Service;


use App\Exceptions\RuleValidationException;
use App\Models\BaseModel;
use App\Models\Coupon;
use App\Models\Goods;
use App\Models\Order;
use App\Rules\SearchPwd;
use App\Rules\VerifyImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderService
{

    /**
     * 商品服务层.
     * @var \App\Service\PayService
     */
    private $goodsService;


    /**
     * 优惠码服务层
     * @var \App\Service\CouponService
     */
    private $couponService;

    public function __construct()
    {
        $this->goodsService = app('Service\GoodsService');
        $this->couponService = app('Service\CouponService');
    }


    /**
     * 验证集合
     *
     * @param Request $request
     * @throws RuleValidationException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function validatorCreateOrder(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'gid' => 'required' ,
            'email' => ['required', 'email'],
            'payway' => ['required', 'integer'],
            'search_pwd' => [new SearchPwd()],
            'by_amount' => ['required', 'integer'],
            'img_verify_code' => [new VerifyImg()],
        ], [
            'by_amount.required' =>  __('dujiaoka.prompt.buy_amount_format_error'),
            'by_amount.integer' =>  __('dujiaoka.prompt.buy_amount_format_error'),
            'payway.required' =>  __('dujiaoka.prompt.please_select_mode_of_payment'),
            'payway.integer' =>  __('dujiaoka.prompt.please_select_mode_of_payment'),
            'email.required' =>  __('dujiaoka.prompt.email_format_error'),
            'email.email' =>  __('dujiaoka.prompt.email_format_error'),
            'gid.required' =>  __('dujiaoka.prompt.goods_does_not_exist'),
        ]);
        if ($validator->fails()) {
            throw new RuleValidationException($validator->errors()->first());
        }
        // 极验验证
        if (
            dujiaoka_config_get('is_open_geetest') == BaseModel::STATUS_OPEN
            &&
            !Validator::make($request->all(),
                ['geetest_challenge' => 'geetest',],
                [ 'geetest' => __('dujiaoka.prompt.geetest_validate_fail')])

        ) {
            throw new RuleValidationException(__('dujiaoka.prompt.geetest_validate_fail'));
        }
    }

    /**
     * 得到商品详情并验证
     *
     * @param Request $request 请求
     * @throws RuleValidationException
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function validatorGoods(Request $request): Goods
    {
        // 获得商品详情
        $goods = $this->goodsService->detail($request->input('gid'));
        // 商品状态验证
        $this->goodsService->validatorGoodsStatus($goods);
        // 如果有限购
        if ($goods->buy_limit_num > 0 && $request->input('by_amount') > $goods->buy_limit_num) {
            throw new RuleValidationException(__('dujiaoka.prompt.purchase_limit_exceeded'));
        }
        // 库存不足
        if ($request->input('by_amount') > $goods->in_stock) {
            throw new RuleValidationException(__('dujiaoka.prompt.inventory_shortage'));
        }
        return $goods;
    }

    /**
     * 优惠码验证
     *
     * @param Request $request
     * @return Coupon|null
     * @throws RuleValidationException
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function validatorCoupon(Request $request):? Coupon
    {
        // 如果提交了优惠码
        if ($request->filled('coupon_code')) {
            // 查询优惠码是否存在
            $coupon = $this->couponService->withHasGoods($request->input('coupon_code'), $request->input('gid'));
            // 此商品没有这个优惠码
            if (empty($coupon)) {
                throw new RuleValidationException(__('dujiaoka.prompt.coupon_does_not_exist'));
            }
            // 剩余次数不足
            if ($coupon->ret <= 0) {
                throw new RuleValidationException(__('dujiaoka.prompt.coupon_lack_of_available_opportunities'));
            }
            return $coupon;
        }
        return null;
    }

    /**
     * 代充框验证.
     *
     * @param Goods $goods
     * @param Request $request
     * @return string
     * @throws RuleValidationException
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function validatorChargeInput(Goods $goods, Request $request): string
    {
        $otherIpt = '';
        // 代充框验证
        if ($goods->type == Goods::MANUAL_PROCESSING && !empty($goods->other_ipu_cnf)) {
            // 如果有其他输入框 判断其他输入框内容  然后载入信息
            $formatIpt = format_charge_input($goods->other_ipu_cnf);
            foreach ($formatIpt as $item) {
                if ($item['rule'] && !$request->filled($item['field'])) {
                    $errMessage = $item['desc'] . __('dujiaoka.prompt.can_not_be_empty');
                    throw new RuleValidationException($errMessage);
                }
                $otherIpt .= $item['desc'].':'.$request->input($item['field']) . PHP_EOL;
            }
        }
        return $otherIpt;
    }

    /**
     * 通过订单号查询订单
     * @param string $orderSN
     * @return Order
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function detailOrderSN(string $orderSN):? Order
    {
        $order = Order::query()->with(['coupon', 'pay', 'goods'])->where('order_sn', $orderSN)->first();
        return $order;
    }

    /**
     * 根据订单号过期订单.
     *
     * @param string $orderSN
     * @return bool
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function expiredOrderSN(string $orderSN): bool
    {
        return Order::query()->where('order_sn', $orderSN)->update(['status' => Order::STATUS_EXPIRED]);
    }

    /**
     * 设置订单优惠码已回退
     *
     * @param string $orderSN
     * @return bool
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function couponIsBack(string $orderSN): bool
    {
        return Order::query()->where('order_sn', $orderSN)->update(['coupon_ret_back' => Order::COUPON_BACK_OK]);
    }

    /**
     * 通过邮箱和查询密码查询
     *
     * @param string $email 邮箱
     * @param string $searchPwd 查询面面
     * @return array|\Illuminate\Database\Concerns\BuildsQueries[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withEmailAndPassword(string $email, string $searchPwd = '')
    {
        return Order::query()
            ->where('email', $email)
            ->when(!empty($searchPwd), function ($query) use ($searchPwd) {
                $query->where('search_pwd', $searchPwd);
            })
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * 通过订单号集合查询
     *
     * @param array $orderSNS 订单号集合
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function byOrderSNS(array $orderSNS)
    {
        return Order::query()
            ->whereIn('order_sn', $orderSNS)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

}
