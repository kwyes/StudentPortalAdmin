<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	@extract($_POST);
  if(isset($from) && isset($to)) {
		include_once '../config/dbconnect.php';
		require_once '../config/SPAdminClass.php';
		$c = new SPAdminClass();
		$mob = $c->getCurrentStudentListG8G9($from, $to);
		if ($mob != false) {
			echo json_encode($mob);
		} else {
			echo json_encode(array('result' => '0'));
		}
	}	else {
    echo json_encode(array('result' => '0'));
  }

} else {
	echo 0;
	exit;
}
?>
