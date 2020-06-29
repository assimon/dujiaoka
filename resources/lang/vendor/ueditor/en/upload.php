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
    UPLOAD_ERR_INI_SIZE => 'file size exceeds MAX_FILE_SIZE in php.ini limit',
    UPLOAD_ERR_FORM_SIZE => 'file size exceeds MAX_FILE_SIZE in form limit',
    UPLOAD_ERR_PARTIAL => 'upload file is not complete',
    UPLOAD_ERR_NO_FILE => 'no files uploaded',
    UPLOAD_ERR_NO_TMP_DIR => 'no temporary directory found',
    UPLOAD_ERR_CANT_WRITE => 'fail to write file',

    'ERROR_TMP_FILE' => 'create temporary file error',
    'ERROR_TMP_FILE_NOT_FOUND' => 'can\'t find a temporary file',
    'ERROR_SIZE_EXCEED' => 'file size beyond the site restrictions',
    'ERROR_TYPE_NOT_ALLOWED' => 'file type does not allowed',
    'ERROR_CREATE_DIR' => 'directory creation fails',
    'ERROR_DIR_NOT_WRITEABLE' => 'directory does not have write permission',
    'ERROR_FILE_MOVE' => 'file save error',
    'ERROR_FILE_NOT_FOUND' => 'can\'t find the uploaded file',
    'ERROR_WRITE_CONTENT' => 'error writing file content',
    'ERROR_UNKNOWN' => 'An unknown error',
    'ERROR_DEAD_LINK' => 'link is not available',
    'ERROR_HTTP_LINK' => 'not a HTTP link',
    'ERROR_HTTP_CONTENTTYPE' => 'link contentType incorrect',
    'ERROR_UNKNOWN_MODE' => 'Please Config the core.mode',
];
