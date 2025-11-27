<?php
  // ===============================================================================
  /* 
   * Note:
   * P99 PHP Check Order Sample Code
   * 
   */
  // ===============================================================================
  include( "Common.php" );
  
  $isPostBack = ($_POST["is_postback"] == "T");

  if ( $isPostBack ) {
  
    // 取得送出查單之交易資料
    $transData = $_POST["data"];
    
    try{
    
      // 設定查單服務位置
      $serviceURL = "https://api.p99pay.com/v1";
      
      // 進行查單
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
        
        // 檢核 P99 交易驗證壓碼
        $isCorrect = ( $trans->VerifyERPC( $k, $v ) );  
        
      }
      
    }catch ( Exception $ex ) {
      $transData = "";
    }

  }else{
  
    $trans = new Trans( null );
    // 交易訊息代碼
    $trans->nodes["MSG_TYPE"] = "0100"; 
    // 交易處理代碼 
    $trans->nodes["PCODE"] = "200000"; // 查詢訂單請使用 200000
    // 商家遊戲代碼
    $trans->nodes["CID"] = "C001430000143";
    // 商家訂單編號
    $trans->nodes["COID"] = "CP20250124010100";
    // 幣別 
    $trans->nodes["CUID"] = "USD";
    // 交易金額
    $trans->nodes["AMOUNT"] = "1";
    // 以商家密碼、商家密鑰 I , II ( 已於 Common.php 內設定 ) 取得 ERQC
    $erqc = $trans->GetERQC( $p, $k, $v );
    // 商家交易驗證壓碼
    $trans->nodes["ERQC"] = $erqc;
    // 取得送出之交易資料
    $data = $trans->GetSendData();
  }
?>

<html> 
<head> 
<title>P99 Check Order Sample Code</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
  
  <?php
  if ( $isPostBack ) {
  ?>
  
    Test P99 Check Order is get result <br>
    P99 交易結果 : <?php echo ( ( $isSuccess ) ? "成功" : "失敗" ); ?> <br>
    P99 交易驗證壓碼檢核結果 : <?php echo ( ( $isCorrect ) ? "正常" : "異常 or N/A" ); ?> <br>
    玩家付款結果 : <?php echo $trans->nodes["PAY_STATUS"]?> <br>
    交易幣別 : <?php echo $trans->nodes["CUID"]; ?> <br>
    交易金額 : <?php echo $trans->nodes["AMOUNT"]; ?> <br>
      
  <?php
  }else{
  ?>
  
    Test P99 Check Order start <br>
    <?php
    if ( $trans->nodes["COID"] != "" ) {
    ?>
    <?php echo $data . "<BR>"; ?>
    COID : <?php echo $trans->nodes["COID"]; ?>
    
    <form name="form1" id="form1" action="checkorder.php" method="post">
    <input type="hidden" name="data" value="<?php echo $data ?>">
    <input type="hidden" name="is_postback" value="T">
    <input type="submit" value="送出查單至測試機">
    </form>
    <?php
    }else{
    ?>
    <form name="form1" id="form1" action="checkorder.php" method="post">
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