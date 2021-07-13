<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */


use App\Exceptions\AppException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('replace_mail_tpl')) {

    /**
     * 替换邮件模板
     *
     * @param array $mailtpl 模板
     * @param array $data 内容
     * @return array|false|mixed
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
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
}


if (! function_exists('dujiaoka_config_get')) {

    /**
     * 系统配置获取
     *
     * @param string $key 要获取的key
     * @param $default 默认
     * @return mixed|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function dujiaoka_config_get(string $key, $default = null)
    {
       $sysConfig = Cache::get('system-setting');
       return $sysConfig[$key] ?? $default;
    }
}

if (! function_exists('format_wholesale_price')) {

    /**
     * 格式化批发价
     *
     * @param string $wholesalePriceArr 批发价配置
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_wholesale_price(string $wholesalePriceArr): ?array
    {
        $waitArr = explode(PHP_EOL, $wholesalePriceArr);
        $formatData = [];
        foreach ($waitArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) != 2) {
                    return null;
                }
                $formatData[$key]['number'] = $explodeFormat[0];
                $formatData[$key]['price'] = $explodeFormat[1];
            }
        }
        sort($formatData);
        return $formatData;
    }
}

if (! function_exists('delete_html_code')) {

    /**
     * 去除html内容
     * @param string $str 需要去掉的字符串
     * @return string
     */
    function delete_html_code(string $str): string
    {
        $str = trim($str); //清除字符串两边的空格
        $str = preg_replace("/\t/", "", $str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/ /", "", $str);
        $str = preg_replace("/  /", "", $str);  //匹配html中的空格
        return trim($str); //返回字符串
    }
}

if (! function_exists('format_charge_input')) {

    /**
     * 格式化代充框
     *
     * @param string $charge
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_charge_input(string $charge): ?array
    {
        $inputArr = explode(PHP_EOL, $charge);
        $formatData = [];
        foreach ($inputArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) != 3) {
                    return null;
                }
                $formatData[$key]['field'] = $explodeFormat[0];
                $formatData[$key]['desc'] = $explodeFormat[1];
                $formatData[$key]['rule'] = filter_var($explodeFormat[2], FILTER_VALIDATE_BOOLEAN);
            }
        }
        return $formatData;
    }
}

if (! function_exists('site_url')) {

    /**
     * 获取顶级域名 带协议
     * @return string
     */
    function site_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }
}

if (! function_exists('md5_signquery')) {

    function md5_signquery(array $parameter, string $signKey)
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
}

if (! function_exists('signquery_string')) {

    function signquery_string(array $data)
    {
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
}

if (!function_exists('picture_ulr')) {

    /**
     * 生成前台图片链接 不存在使用默认图
     * @param string $file 图片地址
     * @param false $getHost 是否只获取图片前缀域名
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function picture_ulr($file, $getHost = false)
    {
        if ($getHost) return Storage::disk('admin')->url('');
        return $file ? Storage::disk('admin')->url($file) : url('assets/common/images/default.jpg');
    }
}

if (!function_exists('assoc_unique')) {
    function assoc_unique($arr, $key)
    {
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
}
