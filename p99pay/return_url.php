<?php
  // ===============================================================================
  /* 
   * Note:
   * P99 PHP Order Return Sample Code
   * 
   */
  // ===============================================================================
  
  include( "Common.php" );
  $post_body = file_get_contents("php://input");
  
  $results = print_r($post_body, true);
  $str = $results;
  
  if(strtolower(substr($results, 0, 5)) == "data="){
		$str = substr($results,5);
	}  
  
  if(strpos($str, "%") > 0){
    $str = urldecode($str);
  }
  
  $trans = new Trans( $str );
  
  if($trans->VerifyERPC( $k, $v )){
  	echo "Verify True" . "</br>";
	}else{
		echo "Verify False" . "</br>";
	}
	
  $str_decode = base64_decode($str);
  $json_data = json_decode($str_decode,true);
  
  foreach($json_data as $key => $value){
    echo "[$key] => $value" . "</br>";
  }
?>