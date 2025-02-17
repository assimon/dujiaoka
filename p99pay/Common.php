<?php
  // ===============================================================================
  /* 
   * Note:
   * 解析回傳資料
   * 
   */
  // ===============================================================================
  include( "Cryptography7.php" );

  // 商家密碼
  $p = "k2sWbsonDe";
  // 商家密鑰 I
  $k = "U1BHcHl4MlRVMVQ4d056Q2c1bElnaXBj";
  // 商家密鑰 II
  $v = "UmRRVHZ3S0Q=";
  
  // 交易物件
  class Trans
  {
    private $key = ""; // key for content provider 
    private $iv = ""; // iv for content provider 
    private $odata = ""; // Recv From CP Module 
    private $data = ""; // Json String
    private $bolIsParsed = false; // parse flag
    public $msg = ""; 
    public $recvDesc = ""; 
    public $nodes = null; 
    public $base64_encrypt_data = ""; 
    public $encrypt_data = ""; 

    /**
    * 建構式
    *
    * @param string $odata
    */
    function __construct ($odata)
    {
      if (empty($odata)) {
      
        $this->bolIsParsed = true;
        $this->nodes = array();
        
      }else{
        $this->odata = $odata;
        $this->data = base64_decode( $this->odata );
        
        $json_data = json_decode($this->data,true);
        $this->bolIsParsed = $this->IsParsedByJson($json_data);
        
        if ( !$this->bolIsParsed ) {
          $this->msg = "trans data format is not valid";
          return;
        }
        //Json to Nodes
        $this->nodes = array();
        $this->PutNodes($json_data);
      }
    }
    
    private function IsParsedByJson($json_data){
      $ret = true;
      if(!array_key_exists("MSG_TYPE",$json_data)){
        $ret = false;
      }
      return $ret;
    }
    
    // 解析 Json 資料
    private function PutNodes($json_data)
    {
      foreach($json_data as $key => $value){
        $this->nodes[ $key ] = $value;
      }
    }
    
    // 建構送出之交易、查詢、請款資料
    public function GenerateJson()
    {
      $return_data = Array();
      if ( count( $this->nodes ) > 0 ){
        foreach ( $this->nodes as $key => $value ) 
        {
          $return_data[$key] = $value;
        }
      }
      $json_data = json_encode($return_data);
      return $json_data;
    }
    
    // 建構送出之交易、查詢、請款資料
    public function GetSendData()
    {
      return base64_encode($this->GenerateJson());
    }
    
    /**
    * 產生商家交易驗證壓碼
    * 
    * @param string $pwd
    * @param string $key
    * @param string $iv
    */
    public function GetERQC( $pwd = "xxx", $key = "xxx", $iv = "xxx" )
    {
      if ( !$this->bolIsParsed ) {
        
        $this->msg = "trans data format is not valid";
        return false;
        
      }else if (empty($key) || empty($iv)) {
        
        $this->msg = "key and iv is not valid";
        return false;
      
      }
      
      $this->key = $key;
      $this->iv = $iv;
      
      // Get Content ID
      $cid = !empty($this->nodes["CID"]) ? $this->nodes["CID"] : "";
      
      // Get Content Ordere ID
      $coid = !empty($this->nodes["COID"]) ? $this->nodes["COID"] : "";
            
      // Get Trans Currency ID
      $cuid = !empty($this->nodes["CUID"]) ? $this->nodes["CUID"] : "";
      
      // Get Trans Payment ID
      $paid = !empty($this->nodes["PAID"]) ? $this->nodes["PAID"] : "";
      
      // Get Trans Amount need parse to fix format
      $amt = !empty($this->nodes["AMOUNT"]) ? $this->nodes["AMOUNT"] : "";
      
      // Get Content USER_ACCTID
      $user_acctid = !empty($this->nodes["USER_ACCTID"]) ? $this->nodes["USER_ACCTID"] : "";
      
      return $this->_GetERQC($cid, $coid, $cuid, $paid, $amt, $user_acctid, $pwd);
    }
    
    /**
    * 產生商家交易驗證壓碼
    * 
    * @param string $cid
    * @param string $coid
    * @param string $cuid
    * @param string $paid
    * @param string $amt
    * @param string $user_acctid
    * @param string $pwd
    */
    private function _GetERQC(...$Variables)
    {
      $erqc = "";
      
      $amt = $Variables[4];
      
      // 驗證用的 AMOUNT 需整理成 14 碼
      if (strpos($amt, ".") !== false)
      {
          $amt = substr($amt, 0, strpos($amt, ".")) . ((strlen($amt) - strpos($amt, ".")) > 3 ? substr($amt, strpos($amt, ".") + 1, 2) : str_pad(substr($amt, (strpos($amt, ".") + 1)), 2, "0"));
          $amt = str_pad($amt, 14, "0", STR_PAD_LEFT);
      }
      else
      {
          $amt = str_pad($amt, 12, "0", STR_PAD_LEFT) . "00"; //.PadLeft(14, '0');
      }
      
      $Variables[4] = $amt;
      
      //$amt = "00000000005000";
      $this->encrypt_data = implode("",$Variables);
      $des = new Crypt3Des($this->key,$this->iv);
      $this->base64_encrypt_data = $des->encrypt( $this->encrypt_data );
      $erqc = base64_encode( sha1( $this->base64_encrypt_data, true ) );
      
      return $erqc;
    }
    
    // 檢核商家交易驗證壓碼
    public function VerifyERQC($pwd = "xxx", $key = "xxx", $iv = "xxx")
    {
      if ( $pwd == "xxx" || $key == "xxx" || $iv == "xxx" ) return false;
      
      $cp_data = $this->GetERQC($pwd, $key, $iv);
      $P99_data = $this->nodes["ERQC"];
      
      return ($P99_data != "" && $cp_data != "" && $P99_data == $cp_data);
    }
    
    /**
    * 產生P99交易驗證壓碼
    * 
    * @param string $key
    * @param string $iv
    */
    public function GetERPC( $key = "xxx", $iv = "xxx" )
    {
      if ( !$this->bolIsParsed ) {
        $this->msg = "trans data format is not valid";
        return false;
      } else if (empty($key) || empty($iv)) {
        $this->msg = "key and iv is not valid";
        return false;
      }
      
      $this->key = $key;
      $this->iv = $iv;
      
      
      // vdata = cid + coid + rrn + cuid + paid + amt(12,2) + user_acctid + $rcode
      // or
      // vdata = did + doid + rrn + cuid + paid + amt(12,2) + user_acctid + $rcode
      
      
      // Get Content ID
      $cid = !empty($this->nodes["CID"]) ? $this->nodes["CID"] : "";
      
      // Get Content Ordere ID
      $coid = !empty($this->nodes["COID"]) ? $this->nodes["COID"] : "";
      
      // Get KIWI System Ordere ID
      $rrn = !empty($this->nodes["RRN"]) ? $this->nodes["RRN"] : "";
      
      // Get Trans Currency ID
      $cuid = !empty($this->nodes["CUID"]) ? $this->nodes["CUID"] : "";
      
      // Get Trans Payment ID
      $paid = !empty($this->nodes["PAID"]) ? $this->nodes["PAID"] : "";
      
      // Get Trans Amount need parse to fix format
      $amt = !empty($this->nodes["AMOUNT"]) ? $this->nodes["AMOUNT"] : "";
      
      // Get Content USER_ACCTID
      $user_acctid = !empty($this->nodes["USER_ACCTID"]) ? $this->nodes["USER_ACCTID"] : "";
      
      // Get Trans Amount need parse to fix format
      $rcode = !empty($this->nodes["RCODE"]) ? $this->nodes["RCODE"] : "";
      
      $Variables = array($cid, $coid, $rrn, $cuid, $paid, $amt, $user_acctid, $rcode);
      return $this->_GetERPC($Variables);
    }
    
    /**
    * 產生P99交易驗證壓碼
    * 
    * @param string $cid
    * @param string $coid
    * @param string $rrn
    * @param string $cuid
    * @param string $paid
    * @param string $amt
    * @param string $user_acctid
    * @param string $rcode
    */
    private function _GetERPC($Variables)
    {
      $erpc = "";
      
      $amt = $Variables[5];
      
      // 驗證用的 AMOUNT 需整理成 14 碼
      if (strpos($amt, ".") !== false)
      {
        $amt = substr($amt, 0, strpos($amt, ".")) . ((strlen($amt) - strpos($amt, ".")) > 3 ? substr($amt, strpos($amt, ".") + 1, 2) : str_pad(substr($amt, (strpos($amt, ".") + 1)), 2, "0"));
        $amt = str_pad($amt, 14, "0", STR_PAD_LEFT);
      }
      else
      {
        $amt = str_pad($amt, 12, "0", STR_PAD_LEFT) . "00"; //.PadLeft(14, '0');
      }
      
      $Variables[5] = $amt;
      //$amt = "00000000005000";
      $this->encrypt_data = implode("",$Variables);
      $des = new Crypt3Des($this->key,$this->iv);
      $this->base64_encrypt_data = $des->encrypt( $this->encrypt_data );
      $erpc = base64_encode( sha1( $this->base64_encrypt_data, true ) );
      
      return $erpc;
    }
    
    // 檢核P99交易驗證壓碼
    public function VerifyERPC($key = "xxx", $iv = "xxx")
    {
      if ( $key == "xxx" || $iv == "xxx" ) return false;
      
      $cp_data = $this->GetERPC($key, $iv);
      $P99_data = $this->nodes["ERPC"];    
      
      return ($P99_data != "" && $cp_data != "" && $P99_data == $cp_data);      
    }
    
  }
  
?>