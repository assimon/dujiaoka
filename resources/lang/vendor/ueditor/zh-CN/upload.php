<?php

/*
 * This file is part of the overtrue/laravel-ueditor.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    UPLOAD_ERR_INI_SIZE => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
    UPLOAD_ERR_FORM_SIZE => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
    UPLOAD_ERR_PARTIAL => '文件只有部分被上传',
    UPLOAD_ERR_NO_FILE => '没有文件被上传',
    UPLOAD_ERR_NO_TMP_DIR => '找不到临时文件夹',
    UPLOAD_ERR_CANT_WRITE => '文件写入失败',

    'ERROR_SIZE_EXCEED' => '文件大小超出网站限制',
    'ERROR_TYPE_NOT_ALLOWED' => '文件类型不允许',
    'ERROR_CREATE_DIR' => '目录创建失败',
    'ERROR_DIR_NOT_WRITEABLE' => '目录没有写权限',
    'ERROR_FILE_MOVE' => '文件保存时出错',
    'ERROR_WRITE_CONTENT' => '写入文件内容错误',
    'ERROR_UNKNOWN' => '未知错误',
    'ERROR_DEAD_LINK' => '链接不可用',
    'ERROR_HTTP_LINK' => '链接不是http链接',
    'ERROR_HTTP_CONTENTTYPE' => '链接contentType不正确',
    'ERROR_UNKNOWN_MODE' => '文件上传模式错误',
];
