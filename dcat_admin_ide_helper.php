<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection wholesale_price_cnf
     * @property Grid\Column|Collection other_ipu_cnf
     * @property Grid\Column|Collection api_hook
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection carmi
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection goods_id
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection coupon
     * @property Grid\Column|Collection discount
     * @property Grid\Column|Collection is_open
     * @property Grid\Column|Collection is_use
     * @property Grid\Column|Collection ret
     * @property Grid\Column|Collection coupons_id
     * @property Grid\Column|Collection tpl_content
     * @property Grid\Column|Collection tpl_name
     * @property Grid\Column|Collection tpl_token
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection actual_price
     * @property Grid\Column|Collection buy_limit_num
     * @property Grid\Column|Collection buy_prompt
     * @property Grid\Column|Collection gd_name
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection in_stock
     * @property Grid\Column|Collection ord
     * @property Grid\Column|Collection picture
     * @property Grid\Column|Collection retail_price
     * @property Grid\Column|Collection sales_volume
     * @property Grid\Column|Collection gp_name
     * @property Grid\Column|Collection buy_amount
     * @property Grid\Column|Collection buy_ip
     * @property Grid\Column|Collection coupon_discount_price
     * @property Grid\Column|Collection coupon_id
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection goods_price
     * @property Grid\Column|Collection info
     * @property Grid\Column|Collection order_sn
     * @property Grid\Column|Collection pay_id
     * @property Grid\Column|Collection search_pwd
     * @property Grid\Column|Collection total_price
     * @property Grid\Column|Collection trade_no
     * @property Grid\Column|Collection wholesale_discount_price
     * @property Grid\Column|Collection merchant_id
     * @property Grid\Column|Collection merchant_key
     * @property Grid\Column|Collection merchant_pem
     * @property Grid\Column|Collection pay_check
     * @property Grid\Column|Collection pay_client
     * @property Grid\Column|Collection pay_handleroute
     * @property Grid\Column|Collection pay_method
     * @property Grid\Column|Collection pay_name
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection wholesale_price_cnf(string $label = null)
     * @method Grid\Column|Collection other_ipu_cnf(string $label = null)
     * @method Grid\Column|Collection api_hook(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection carmi(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection goods_id(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection coupon(string $label = null)
     * @method Grid\Column|Collection discount(string $label = null)
     * @method Grid\Column|Collection is_open(string $label = null)
     * @method Grid\Column|Collection is_use(string $label = null)
     * @method Grid\Column|Collection ret(string $label = null)
     * @method Grid\Column|Collection coupons_id(string $label = null)
     * @method Grid\Column|Collection tpl_content(string $label = null)
     * @method Grid\Column|Collection tpl_name(string $label = null)
     * @method Grid\Column|Collection tpl_token(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection actual_price(string $label = null)
     * @method Grid\Column|Collection buy_limit_num(string $label = null)
     * @method Grid\Column|Collection buy_prompt(string $label = null)
     * @method Grid\Column|Collection gd_name(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection in_stock(string $label = null)
     * @method Grid\Column|Collection ord(string $label = null)
     * @method Grid\Column|Collection picture(string $label = null)
     * @method Grid\Column|Collection retail_price(string $label = null)
     * @method Grid\Column|Collection sales_volume(string $label = null)
     * @method Grid\Column|Collection gp_name(string $label = null)
     * @method Grid\Column|Collection buy_amount(string $label = null)
     * @method Grid\Column|Collection buy_ip(string $label = null)
     * @method Grid\Column|Collection coupon_discount_price(string $label = null)
     * @method Grid\Column|Collection coupon_id(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection goods_price(string $label = null)
     * @method Grid\Column|Collection info(string $label = null)
     * @method Grid\Column|Collection order_sn(string $label = null)
     * @method Grid\Column|Collection pay_id(string $label = null)
     * @method Grid\Column|Collection search_pwd(string $label = null)
     * @method Grid\Column|Collection total_price(string $label = null)
     * @method Grid\Column|Collection trade_no(string $label = null)
     * @method Grid\Column|Collection wholesale_discount_price(string $label = null)
     * @method Grid\Column|Collection merchant_id(string $label = null)
     * @method Grid\Column|Collection merchant_key(string $label = null)
     * @method Grid\Column|Collection merchant_pem(string $label = null)
     * @method Grid\Column|Collection pay_check(string $label = null)
     * @method Grid\Column|Collection pay_client(string $label = null)
     * @method Grid\Column|Collection pay_handleroute(string $label = null)
     * @method Grid\Column|Collection pay_method(string $label = null)
     * @method Grid\Column|Collection pay_name(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection wholesale_price_cnf
     * @property Show\Field|Collection other_ipu_cnf
     * @property Show\Field|Collection api_hook
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection carmi
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection goods_id
     * @property Show\Field|Collection status
     * @property Show\Field|Collection coupon
     * @property Show\Field|Collection discount
     * @property Show\Field|Collection is_open
     * @property Show\Field|Collection is_use
     * @property Show\Field|Collection ret
     * @property Show\Field|Collection coupons_id
     * @property Show\Field|Collection tpl_content
     * @property Show\Field|Collection tpl_name
     * @property Show\Field|Collection tpl_token
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection actual_price
     * @property Show\Field|Collection buy_limit_num
     * @property Show\Field|Collection buy_prompt
     * @property Show\Field|Collection gd_name
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection in_stock
     * @property Show\Field|Collection ord
     * @property Show\Field|Collection picture
     * @property Show\Field|Collection retail_price
     * @property Show\Field|Collection sales_volume
     * @property Show\Field|Collection gp_name
     * @property Show\Field|Collection buy_amount
     * @property Show\Field|Collection buy_ip
     * @property Show\Field|Collection coupon_discount_price
     * @property Show\Field|Collection coupon_id
     * @property Show\Field|Collection email
     * @property Show\Field|Collection goods_price
     * @property Show\Field|Collection info
     * @property Show\Field|Collection order_sn
     * @property Show\Field|Collection pay_id
     * @property Show\Field|Collection search_pwd
     * @property Show\Field|Collection total_price
     * @property Show\Field|Collection trade_no
     * @property Show\Field|Collection wholesale_discount_price
     * @property Show\Field|Collection merchant_id
     * @property Show\Field|Collection merchant_key
     * @property Show\Field|Collection merchant_pem
     * @property Show\Field|Collection pay_check
     * @property Show\Field|Collection pay_client
     * @property Show\Field|Collection pay_handleroute
     * @property Show\Field|Collection pay_method
     * @property Show\Field|Collection pay_name
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection wholesale_price_cnf(string $label = null)
     * @method Show\Field|Collection other_ipu_cnf(string $label = null)
     * @method Show\Field|Collection api_hook(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection carmi(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection goods_id(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection coupon(string $label = null)
     * @method Show\Field|Collection discount(string $label = null)
     * @method Show\Field|Collection is_open(string $label = null)
     * @method Show\Field|Collection is_use(string $label = null)
     * @method Show\Field|Collection ret(string $label = null)
     * @method Show\Field|Collection coupons_id(string $label = null)
     * @method Show\Field|Collection tpl_content(string $label = null)
     * @method Show\Field|Collection tpl_name(string $label = null)
     * @method Show\Field|Collection tpl_token(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection actual_price(string $label = null)
     * @method Show\Field|Collection buy_limit_num(string $label = null)
     * @method Show\Field|Collection buy_prompt(string $label = null)
     * @method Show\Field|Collection gd_name(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection in_stock(string $label = null)
     * @method Show\Field|Collection ord(string $label = null)
     * @method Show\Field|Collection picture(string $label = null)
     * @method Show\Field|Collection retail_price(string $label = null)
     * @method Show\Field|Collection sales_volume(string $label = null)
     * @method Show\Field|Collection gp_name(string $label = null)
     * @method Show\Field|Collection buy_amount(string $label = null)
     * @method Show\Field|Collection buy_ip(string $label = null)
     * @method Show\Field|Collection coupon_discount_price(string $label = null)
     * @method Show\Field|Collection coupon_id(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection goods_price(string $label = null)
     * @method Show\Field|Collection info(string $label = null)
     * @method Show\Field|Collection order_sn(string $label = null)
     * @method Show\Field|Collection pay_id(string $label = null)
     * @method Show\Field|Collection search_pwd(string $label = null)
     * @method Show\Field|Collection total_price(string $label = null)
     * @method Show\Field|Collection trade_no(string $label = null)
     * @method Show\Field|Collection wholesale_discount_price(string $label = null)
     * @method Show\Field|Collection merchant_id(string $label = null)
     * @method Show\Field|Collection merchant_key(string $label = null)
     * @method Show\Field|Collection merchant_pem(string $label = null)
     * @method Show\Field|Collection pay_check(string $label = null)
     * @method Show\Field|Collection pay_client(string $label = null)
     * @method Show\Field|Collection pay_handleroute(string $label = null)
     * @method Show\Field|Collection pay_method(string $label = null)
     * @method Show\Field|Collection pay_name(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
