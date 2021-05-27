<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($semesterID) && isset($teacherId)) {
    include_once '../config/dbconnect.php';
		require_once '../config/BogsClass.php';
		$c = new BogsClass();
    $mob = $c->getCourseOptionsList($semesterID, $teacherId);
  		if ($mob != false) {
  			echo json_encode($mob);
  		} else {
  			echo json_encode(array('result' => '0'));
  		}
  } else {
    echo json_encode(array('result' => '0'));
  }
} else {
	echo 0;
	exit;
}
?>
