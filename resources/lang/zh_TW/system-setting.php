<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

return [
    'labels' => [
        'SystemSetting' => '系統設定',
        'system_setting' => '系統設定',
        'base_setting' => '基本設定',
        'mail_setting' => '信箱服務',
        'order_push_setting' => '訂單推送配置',
        'geetest' => '極驗驗證',
    ],

    'fields' => [
        'title' => '網站標題',
        'text_logo' => '文字LOGO',
        'img_logo' => '圖片LOGO',
        'keywords' => '網站關鍵詞',
        'description' => '網站描述',
        'notice' => '站點公告',
        'footer' => '頁尾自訂代碼',
        'manage_email' => '管理員信箱',
        'is_open_anti_red' => '是否開啟Wechat/QQ防紅',
        'is_open_img_code' => '是否開啟圖形驗證碼',
        'is_open_search_pwd' => '是否開啟查詢密碼',
        'is_open_server_jiang' => '是否開啟server醬',
        'server_jiang_token' => 'server醬通訊token',
        'is_open_telegram_push' => '是否開啟Telegram推送',
        'telegram_userid' => 'Telegram用戶id',
        'telegram_bot_token' => 'Telegram通訊token',
        'template' => '站點模板',
        'language' => '站點語言',
        'order_expire_time' => '訂單逾期時間(分鐘)',

        'driver' => '信箱驅動',
        'host' => 'smtp伺服器地址',
        'port' => '通訊埠',
        'username' => '賬戶',
        'password' => '密碼',
        'encryption' => '協議',
        'from_address' => '發件地址',
        'from_name' => '發件名稱',

        'geetest_id' => '極驗id',
        'geetest_key' => '極驗key',
        'is_open_geetest' => '是否開啟極驗',
    ],
    'options' => [
    ],
    'rule_messages' => [
        'save_system_setting_success' => '系統配置套用成功！',
        'change_reboot_php_worker' => '修改部分配置需要重新啓動[supervisor]或php進程管理工具才會生效，例如信箱服務，server醬等。'
    ]
];
