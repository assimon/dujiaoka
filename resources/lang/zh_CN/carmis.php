<?php

return [
    'labels' => [
        'Carmis' => '卡密',
        'carmis' => '卡密',
    ],
    'fields' => [
        'goods_id' => '所属商品',
        'status' => '状态',
        'carmi' => '卡密内容',
        'status_unsold' => '未售出',
        'status_sold' => '已售出',
        'is_loop' => '循环卡密',
		'yes'=>'是',
        'import_carmis' => '导入卡密',
        'carmis_list' => '卡密列表',
        'carmis_txt' => '卡密文本',
        'are_you_import_sure' => '确定要导入卡密吗？',
        'remove_duplication' => '是否去重',
    ],
    'options' => [
    ],
    'helps' => [
        'carmis_list' => '一行一个，回车分隔。请勿导入单个文本长度过大的卡密，容易导致内存溢出。如果卡密过大建议修改商品为人工处理'
    ],
    'rule_messages' => [
        'carmis_list_and_carmis_txt_can_not_be_empty' => '请填写需要导入的卡密或选择需要上传的卡密文件',
        'import_carmis_success' => '导入卡密成功！'
    ]
];
