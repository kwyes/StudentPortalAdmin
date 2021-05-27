<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($activityStudentId) && isset($activityName) && isset($activityCategory) && isset($activitySDate) && isset($activityEDate) && isset($activityHours) && isset($activityVLWE) && isset($activityApprover)) {
    include_once '../config/dbconnect.php';
		require_once '../config/SPAdminClass.php';
		$c = new SPAdminClass();
    $mob = $c->AddActivityRecords($activityStudentId, $activityName, $activityCategory, $activityLocation, $activitySDate, $activityEDate, $activityHours, $activityVLWE, $activityApprover, $activityComment1, $activityComment2, $activityComment3);
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