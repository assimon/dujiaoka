<?php
  // ===============================================================================
  /* 
   * Note:
   * P99 PHP 主動通知 Sample Code
   * 
   */
  // ===============================================================================
  
  $post_body = file_get_contents("php://input");
  
  $results = print_r($post_body, true);
  
  if(strtolower(substr($results, 0, 5)) == "data="){
    $str = substr($results,5);
  }
  
  if(strpos($str, "%") > 0){
    $str = urldecode($str);
  }

  $str_decode = base64_decode($str);
  $json_data = json_decode($str_decode,true);
  
  $r_RRN = "";
  $r_PAY_STATUS = "";
  foreach($json_data as $key => $value){
    if($key == "RRN"){
      $r_RRN = $value;
    }
    if($key == "PAY_STATUS"){
      $r_PAY_STATUS = $value;
    }
  }
  
  //RRN|PAY_STATUS
  echo $r_RRN . "|" . $r_PAY_STATUS;
?>