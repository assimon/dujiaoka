<?php

return [
    'labels' => [
        'Carmis' => 'Thẻ mã',
        'carmis' => 'Thẻ mã',
    ],
    'fields' => [
        'goods_id' => 'Sản phẩm liên quan',
        'status' => 'Trạng thái',
        'carmi' => 'Nội dung thẻ mã',
        'status_unsold' => 'Chưa bán',
        'status_sold' => 'Đã bán',
        'is_loop' => 'Thẻ mã tuần hoàn',
		'yes'=>'Có',
        'import_carmis' => 'Nhập thẻ mã',
        'carmis_list' => 'Danh sách thẻ mã',
        'carmis_txt' => 'Văn bản thẻ mã',
        'are_you_import_sure' => 'Bạn có chắc chắn muốn nhập thẻ mã không?',
        'remove_duplication' => 'Loại bỏ trùng lặp hay không',
    ],
    'options' => [
    ],
    'helps' => [
        'carmis_list' => 'Mỗi dòng một mục, phân cách bằng phím Enter. Vui lòng không nhập thẻ mã có độ dài văn bản quá lớn, dễ gây tràn bộ nhớ. Nếu thẻ mã quá lớn, nên sửa sản phẩm thành xử lý thủ công'
    ],
    'rule_messages' => [
        'carmis_list_and_carmis_txt_can_not_be_empty' => 'Vui lòng điền thẻ mã cần nhập hoặc chọn tệp thẻ mã cần tải lên',
        'import_carmis_success' => 'Nhập thẻ mã thành công!'
    ]
];
