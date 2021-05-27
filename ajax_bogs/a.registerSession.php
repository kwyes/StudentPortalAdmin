<?php
session_start();
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($input) && isset($text)) {
    $_SESSION[$text] = $input;
    echo json_encode(array('result'=>$_SESSION[$text]));
  } else {
    echo json_encode(array('result' => '0'));
  }
} else {
	echo 0;
	exit;
}
?>
