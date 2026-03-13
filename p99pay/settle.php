<?php
  // ===============================================================================
  /* 
   * Note:
   * P99 PHP Settle Sample Code
   * 
   */
  // ===============================================================================
  include( "Common.php" );
  
  $isPostBack = ($_POST["is_postback"] == "T");

  if ( $isPostBack ) {
  
    // 取得送出查單之交易資料
    $transData = $_POST["data"];

    try{
    
      // 設定請款服務位置
      $serviceURL = "https://api.p99pay.com/v1";
      
      // 進行請款
      $post = "data=" . $transData;
      
      $curl = curl_init($serviceURL);
      curl_setopt($curl, CURLOPT_HEADER,FALSE);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
      // 取得結果
      $result = curl_exec($curl);
      curl_close($curl);

      $transData = urldecode($result);

      // 解析回傳結果
      $trans = new Trans( $transData );
      
      $isSuccess = ($trans->nodes["RCODE"] == "0000");
      $isCorrect = false;
      
      if ( $isSuccess ) {
        
        // 檢核 P99 請款驗證壓碼
        $isCorrect = ( $trans->VerifyERPC( $k, $v ) );  
        
      }
      
    }catch ( Exception $ex ) {
      $transData = "";
    }

  }else{
  
    $trans = new Trans( null );
    // 交易訊息代碼
    $trans->nodes["MSG_TYPE"] = "0500"; // 請款請使用 0500
    // 交易處理代碼 
    $trans->nodes["PCODE"] = "300000"; // 一般交易請使用 300000
    // 商家遊戲代碼
    $trans->nodes["CID"] = "C001430000143";
    // 商家訂單編號
    $trans->nodes["COID"] = "CP20250124010100";
    //$trans->nodes["COID"] = $_POST["COID"];
    // 幣別 ISO Alpha Code
    $trans->nodes["CUID"] = "USD";
    // 付款代收業者代碼 
    $trans->nodes["PAID"] = "COPKWP01";
    // 交易金額
    $trans->nodes["AMOUNT"] = "1";
    // 以商家密碼、商家密鑰 I , II ( 已於 Common.php 內設定 ) 取得 ERQC
    $erqc = $trans->GetERQC( $p, $k, $v );
    // 商家請款驗證壓碼
    $trans->nodes["ERQC"] = $erqc;
    // 取得送出之交易資料
    $data = $trans->GetSendData();
  
  }
?>
<html> 
<head> 
<title>P99 Settle Sample Code</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
  
  <?php 
  if ( $isPostBack ) {
  ?>
  
    Test P99 Settle is get result <br>
    P99 請款結果 : <?php echo ( ( $isSuccess ) ? "成功" : "失敗" ); ?> <br>
    P99 請款驗證壓碼檢核結果 : <?php echo ( ( $isCorrect ) ? "正常" : "異常 or N/A" ); ?> <br>
    
  <?php
  }else{
  ?>
  
    Test P99 Settle start <br>
    <?php
    if ( $trans->nodes["COID"] != "" ) {
    ?>
    COID : <?php echo $trans->nodes["COID"]; ?>
    
    <form name="form1" id="form1" action="settle.php" method="post">
    <input type="hidden" name="data" value="<?php echo $data ?>">
    <input type="hidden" name="is_postback" value="T">
    <input type="submit" value="送出請款P99至測試機">
    </form>
    <?php
    }else{
    ?>
    <form name="form1" id="form1" action="settle.php" method="post">
    <input type="text" name="COID" value="<?php echo $trans->nodes["COID"]; ?>">
    <input type="submit" value="指定商家訂單編號">
    </form>
    <?php
    }
    ?>

    
  <?php
  }
  ?>
  
</body>
</html>
