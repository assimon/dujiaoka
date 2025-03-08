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
        'SystemSetting' => 'การตั้งค่าระบบ',
        'system_setting' => 'การตั้งค่าระบบ',
        'base_setting' => 'การตั้งค่าพื้นฐาน',
        'mail_setting' => 'บริการอีเมล',
        'order_push_setting' => 'การกำหนดค่าการผลักดันคำสั่งซื้อ',
        'geetest' => 'การยืนยัน Geetest',
    ],

    'fields' => [
        'title' => 'ชื่อเว็บไซต์',
        'text_logo' => 'โลโก้ข้อความ',
        'img_logo' => 'โลโก้รูปภาพ',
        'keywords' => 'คำสำคัญของเว็บไซต์',
        'description' => 'คำอธิบายเว็บไซต์',
        'notice' => 'ประกาศเว็บไซต์',
        'footer' => 'โค้ดที่กำหนดเองในส่วนท้าย',
        'manage_email' => 'อีเมลผู้ดูแลระบบ',
        'is_open_anti_red' => 'เปิดการป้องกัน WeChat/QQ หรือไม่',
        'is_open_img_code' => 'เปิดรหัสยืนยันรูปภาพหรือไม่',
        'is_open_search_pwd' => 'เปิดรหัสผ่านค้นหาหรือไม่',
        'is_open_server_jiang' => 'เปิด server jiang หรือไม่',
        'server_jiang_token' => 'โทเค็นการสื่อสาร server jiang',
        'is_open_telegram_push' => 'เปิดการผลักดัน Telegram หรือไม่',
        'telegram_userid' => 'รหัสผู้ใช้ Telegram',
        'telegram_bot_token' => 'โทเค็นการสื่อสาร Telegram',
        'template' => 'เทมเพลตเว็บไซต์',
        'language' => 'ภาษาเว็บไซต์',
        'order_expire_time' => 'เวลาหมดอายุคำสั่งซื้อ (นาที)',

        'driver' => 'ไดรเวอร์อีเมล',
        'host' => 'ที่อยู่เซิร์ฟเวอร์ SMTP',
        'port' => 'พอร์ต',
        'username' => 'บัญชี',
        'password' => 'รหัสผ่าน',
        'encryption' => 'โปรโตคอล',
        'from_address' => 'ที่อยู่ผู้ส่ง',
        'from_name' => 'ชื่อผู้ส่ง',

        'geetest_id' => 'รหัส Geetest',
        'geetest_key' => 'คีย์ Geetest',
        'is_open_geetest' => 'เปิด Geetest หรือไม่',
    ],
    'options' => [
    ],
    'rule_messages' => [
        'save_system_setting_success' => 'ใช้การกำหนดค่าระบบสำเร็จ!',
        'change_reboot_php_worker' => 'การแก้ไขการกำหนดค่าบางส่วนจำเป็นต้องรีสตาร์ท [supervisor] หรือเครื่องมือจัดการกระบวนการ PHP เพื่อให้มีผล เช่น บริการอีเมล, server jiang เป็นต้น'
    ]
];
