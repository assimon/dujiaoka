<?php

use Illuminate\Support\Arr;

/**
 * 获取顶级域名 带协议
 * @return string
 */
function site_url()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!== 'off' || $_SERVER['SERVER_PORT'] == 443)?"https://" :"http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}

/**
 * 根据建值去掉重复数组
 * @param $arr
 * @param $key
 * @return mixed
 */
function assoc_unique($arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    sort($arr); //sort函数对数组进行排序
    return $arr;
}

/**
 * 去除html内容
 * @param $str
 * @return string
 */
function delete_html($str)
{
    $str = trim($str); //清除字符串两边的空格
    $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/","",$str);
    $str = preg_replace("/\r/","",$str);
    $str = preg_replace("/\n/","",$str);
    $str = preg_replace("/ /","",$str);
    $str = preg_replace("/  /","",$str);  //匹配html中的空格
    return trim($str); //返回字符串
}

function replace_mail_tpl($mailtpl = [], $data = [])
{
    if (!$mailtpl) {
        return false;
    }
    if ($data) {
        foreach ($data as $key => $val) {
            $title = str_replace('{' . $key . '}', $val, isset($title) ? $title : $mailtpl['tpl_name']);
            $content = str_replace('{' . $key . '}', $val, isset($content) ? $content : $mailtpl['tpl_content']);
        }
        return ['tpl_name' => $title, 'tpl_content' => $content];
    }
    return $mailtpl;
}

function mzf_md5_signquery($parameter, $signKey)
{
    ksort($parameter); //重新排序$data数组
    reset($parameter); //内部指针指向数组中的第一个元素
    $sign = '';
    $urls = '';
    foreach ($parameter as $key => $val) {
        if ($val == '') continue;
        if ($key != 'sign') {
            if ($sign != '') {
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式
        }
    }
    $sign = md5($sign . $signKey);//密码追加进入开始MD5签名
    $query = $urls . '&sign=' . $sign; //创建订单所需的参数
    return $query;
}

function create_link_string($data){
    ksort($data); //排序post参数
    reset($data); //内部指针指向数组中的第一个元素
    $sign = ''; //加密字符串初始化
    foreach ($data as $key => $val) {
        if ($val == '' || $key == 'sign') continue; //跳过这些不签名
        if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
        $sign .= "$key=$val"; //拼接为url参数形式
    }
    return $sign;
}


if (! function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        return Arr::set($array, $key, $value);
    }
}

