<?php

return [
    'labels' => [
        'Goods' => 'Sản phẩm',
        'goods' => 'Sản phẩm',
    ],
    'fields' => [
        'actual_price' => 'Giá bán thực tế',
        'group_id' => 'Danh mục liên quan',
        'api_hook' => 'Sự kiện callback',
        'buy_prompt' => 'Gợi ý mua hàng',
        'description' => 'Mô tả sản phẩm',
        'gd_name' => 'Tên sản phẩm',
        'gd_description' => 'Mô tả sản phẩm',
        'gd_keywords' => 'Từ khóa sản phẩm',
        'in_stock' => 'Tồn kho',
        'ord' => 'Trọng số sắp xếp',
        'other_ipu_cnf' => 'Cấu hình ô nhập khác',
        'picture' => 'Hình ảnh sản phẩm',
        'retail_price' => 'Giá bán lẻ',
        'sales_volume' => 'Doanh số',
        'type' => 'Loại sản phẩm',
        'buy_limit_num' => 'Giới hạn số lượng tối đa mua một lần',
        'wholesale_price_cnf' => 'Cấu hình giá bán buôn',
        'automatic_delivery' => 'Giao hàng tự động',
        'manual_processing' => 'Xử lý thủ công',
        'is_open' => 'Có bày bán không',
        'coupon_id' => 'Mã giảm giá có thể sử dụng'
    ],
    'options' => [
    ],
    'helps' => [
        'retail_price' => 'Có thể để trống, chủ yếu dùng để hiển thị',
        'picture' => 'Có thể không tải lên, sẽ dùng hình ảnh mặc định',
        'in_stock' => 'Khi loại sản phẩm là "Xử lý thủ công", số lượng tồn kho nhập thủ công mới có hiệu lực. Đối với sản phẩm loại "Giao hàng tự động", hệ thống sẽ tự động xác định số lượng tồn kho',
        'buy_limit_num' => 'Ngăn chặn việc quét tồn kho độc hại, 0 nghĩa là không giới hạn số lượng tối đa khách hàng có thể đặt hàng một lần',
        'other_ipu_cnf' => 'Định dạng là [định danh duy nhất(tiếng Anh)=tên ô nhập=có bắt buộc không], ví dụ: điền line_account=Tài khoản Line=true nghĩa là trang chi tiết sản phẩm sẽ thêm một ô nhập [Tài khoản Line], khách hàng có thể nhập [Tài khoản Line], true là bắt buộc, false là tùy chọn. (Mỗi dòng một mục)',
        'wholesale_price_cnf' => 'Ví dụ: điền 5=3 nghĩa là khi khách hàng mua từ 5 cái trở lên, giá mỗi cái sẽ là 3 đồng. Mỗi dòng một mục',

    ]
];
