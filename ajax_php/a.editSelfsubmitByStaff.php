<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($title) && isset($staff1) && isset($status) && isset($category) && isset($location) && isset($sDate) && isset($eDate) && isset($hours)) {
    include_once '../config/dbconnect.php';
		require_once '../config/SPAdminClass.php';
		$c = new SPAdminClass();
    $mob = $c->editSelfsubmitByStaff($studentId, $studentActivityId, $category, $comment, $comment1, $comment2, $comment3, $sDate, $eDate, $hours, $status, $location, $vlwe, $staff1, $title, $preStatus, $student, $StaffFullName);
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