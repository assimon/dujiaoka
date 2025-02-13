<?php
  // ===============================================================================
  /* 
   * Note:
   * P99 PHP Order Sample Code
   * 
   */
  // ===============================================================================
  include( "Common.php" );

  $trans = new Trans( null );
    
  // 交易訊息代碼
  $trans->nodes["MSG_TYPE"] = "0100"; 
  // 交易處理代碼 
  $trans->nodes["PCODE"] = "300000"; // 一般交易請使用 300000
  // 商家遊戲代碼
  $trans->nodes["CID"] = "C001430000143";
  // 商家訂單編號
  $trans->nodes["COID"] = "CP" . date("YmdHis");
  // 幣別
  $trans->nodes["CUID"] = "USD";
  // 付款代收業者代碼 
  $trans->nodes["PAID"] = ""; // 不帶入 PAID 可由系統顯示
  // 交易金額
  $trans->nodes["AMOUNT"] = "1";
  // 商家接收交易結果網址
  $trans->nodes["RETURN_URL"] = "http://111.111.111.111/return_url.php";
  // 是否指定付款代收業者
  $trans->nodes["ORDER_TYPE"] = "E";
  // 商家商品名稱
  $trans->nodes["PRODUCT_NAME"] = ""; // 需要帶入 USER 購買商品名稱
  // 商家商品代碼
  $trans->nodes["PRODUCT_ID"] = ""; // 需要帶入 USER 購買商品 ID
  // 玩家帳號
  $trans->nodes["USER_ACCTID"] = "USER_001"; // 需要帶入 USER 唯一識別值
  // 交易備註 ( 此為選填 )
  $trans->nodes["MEMO"] = "";
  // 以商家密碼、商家密鑰 I , II ( 已於 Common.php 內設定 ) 取得 ERQC
  $erqc = $trans->GetERQC( $p, $k, $v );
  // 商家交易驗證壓碼
  $trans->nodes["ERQC"] = $erqc;
  
  // 取得送出之交易資料
  $data = $trans->GetSendData();
?>

<html> 
<head> 
<title>P99 Transaction Sample Code</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
  Test P99 transaction start <br>
  
  COID : <?php echo $trans->nodes["COID"]; ?>

  <form name="form1" id="form1" action="https://api.p99pay.com/v1" method="post" target="_blank">
  <input type="hidden" name="data" value="<?php echo $data ?>">
  <input type="submit" value="送出交易至p99測試機">
  </form>
    
</body>
</html>