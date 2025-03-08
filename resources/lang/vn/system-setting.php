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
        'SystemSetting' => 'Cài đặt hệ thống',
        'system_setting' => 'Cài đặt hệ thống',
        'base_setting' => 'Cài đặt cơ bản',
        'mail_setting' => 'Dịch vụ email',
        'order_push_setting' => 'Cấu hình đẩy đơn hàng',
        'geetest' => 'Xác minh Geetest',
    ],

    'fields' => [
        'title' => 'Tiêu đề trang web',
        'text_logo' => 'Logo văn bản',
        'img_logo' => 'Logo hình ảnh',
        'keywords' => 'Từ khóa trang web',
        'description' => 'Mô tả trang web',
        'notice' => 'Thông báo trang web',
        'footer' => 'Mã tùy chỉnh chân trang',
        'manage_email' => 'Email quản trị viên',
        'is_open_anti_red' => 'Có bật chống đỏ WeChat/QQ không',
        'is_open_img_code' => 'Có bật mã xác nhận hình ảnh không',
        'is_open_search_pwd' => 'Có bật mật khẩu tìm kiếm không',
        'is_open_server_jiang' => 'Có bật server jiang không',
        'server_jiang_token' => 'Token giao tiếp server jiang',
        'is_open_telegram_push' => 'Có bật đẩy Telegram không',
        'telegram_userid' => 'ID người dùng Telegram',
        'telegram_bot_token' => 'Token giao tiếp Telegram',
        'template' => 'Mẫu trang web',
        'language' => 'Ngôn ngữ trang web',
        'order_expire_time' => 'Thời gian hết hạn đơn hàng (phút)',

        'driver' => 'Driver email',
        'host' => 'Địa chỉ máy chủ SMTP',
        'port' => 'Cổng',
        'username' => 'Tài khoản',
        'password' => 'Mật khẩu',
        'encryption' => 'Giao thức',
        'from_address' => 'Địa chỉ gửi',
        'from_name' => 'Tên người gửi',

        'geetest_id' => 'ID Geetest',
        'geetest_key' => 'Key Geetest',
        'is_open_geetest' => 'Có bật Geetest không',
    ],
    'options' => [
    ],
    'rule_messages' => [
        'save_system_setting_success' => 'Áp dụng cấu hình hệ thống thành công!',
        'change_reboot_php_worker' => 'Sửa đổi một số cấu hình cần khởi động lại [supervisor] hoặc công cụ quản lý quy trình PHP để có hiệu lực, chẳng hạn như dịch vụ email, server jiang, v.v.'
    ]
];
