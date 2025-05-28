<?php
  // ===============================================================================
  /* 
   * Note:
   * 加解密
   * 
   */
  // ===============================================================================
  
  class Crypt3Des {
    private $key = "";
    private $iv = "";

    /**
     * 構造，傳遞二個已經進行base64_encode的KEY與IV
     *
     * @param string $key
     * @param string $iv
     */
    function __construct ($key, $iv)
    {
        if (empty($key) || empty($iv)) {
            echo 'key and iv is not valid';
            exit();
        }
        $this->key = $key;
        $this->iv = $iv;//8
        //$this->iv = $iv.'00000000000';//16

    }

    /**
     * @title 加密
     * @param string $value 要傳的參數
     * @ //OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING //AES-128-ECB|AES-256-CBC|BF-CBC
     * @return json
     * */
    public function encrypt ($value) {
        $value = $this->PaddingPKCS7($value);
        $key = base64_decode($this->key);
        $iv  = base64_decode($this->iv);
        $cipher = "DES-EDE3-CBC";
        if (in_array($cipher, array_map('strtoupper',openssl_get_cipher_methods()))) {
            $result = openssl_encrypt($value, $cipher, $key, OPENSSL_SSLV23_PADDING, $iv);
        }
        return $result;
    }

    /**
     * @title 解密
     * @param string $value 要傳的參數
     * @return json
     * */
    public function decrypt ($value) {
        $key       = base64_decode($this->key);
        $iv        = base64_decode($this->iv);
        $decrypted = openssl_decrypt($value, 'DES-EDE3-CBC', $key, OPENSSL_SSLV23_PADDING, $iv);
        $ret = $this->UnPaddingPKCS7($decrypted);
        return $ret;
    }


    private function PaddingPKCS7 ($data) {
        $block_size = 8;
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }
    private function UnPaddingPKCS7($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, - 1 * $pad);
    }
  }

?>
