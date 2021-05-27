<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($title) && isset($staff1) && isset($start) && isset($end) && isset($hours)) {
    include_once '../config/dbconnect.php';
		require_once '../config/SPAdminClass.php';
		$c = new SPAdminClass();
    $mob = $c->addAcitivityByStaff($title, $staff1, $staff2, $description, $category, $enrollType, $Actvlwe, $location, $place, $start, $end, $hours, $maxEnroll);
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