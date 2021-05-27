<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($projectId) && isset($course) && isset($subjectName) && isset($teacherID) && isset($topic) && isset($firstName) && isset($lastName) && isset($email) && isset($position) && isset($description)) {
    include_once '../config/dbconnect.php';
		require_once '../config/SPAdminClass.php';
		$category = '';
    if($other) {
      $category = $other;
    } else {
      $category = $capCategory;
    }
		$c = new SPAdminClass();
    $mob = $c->UpdateCareerLife($projectId,$course,$subjectName,$teacherID,$topic,$category,$firstName,$lastName,$email,$phone,$position,$description,$status,$preStatus,$studentName, $staffName,$tComment);
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