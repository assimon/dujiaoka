<?php

return [
    'labels' => [
        'Carmis' => '卡密',
        'carmis' => '卡密',
    ],
    'fields' => [
        'goods_id' => '所屬商品',
        'status' => '狀態',
        'carmi' => '卡密內容',
        'status_unsold' => '未售出',
        'status_sold' => '已售出',
        'import_carmis' => '匯入卡密',
        'carmis_list' => '卡密清單',
        'carmis_txt' => '卡密文字',
        'are_you_import_sure' => '確定要匯入卡密嗎？',
        'remove_duplication' => '是否去重',
    ],
    'options' => [
    ],
    'helps' => [
        'carmis_list' => '一行一個，輸入鍵分隔。請勿匯入單個文字長度過大的卡密，容易導致記憶體溢出。如果卡密過大建議修改商品為人工處理'
    ],
    'rule_messages' => [
        'carmis_list_and_carmis_txt_can_not_be_empty' => '請填寫需要匯入的卡密或選取需要上傳的卡密檔案',
        'import_carmis_success' => '匯入卡密成功！'
    ]
];
