<?php



error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../PHPExcel/Classes/PHPExcel.php';
require_once '../settings.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1','ACTIVITY NAME');
$objPHPExcel->getActiveSheet()->setCellValue('B1','DATE');
$objPHPExcel->getActiveSheet()->setCellValue('C1','HOURS');
$objPHPExcel->getActiveSheet()->setCellValue('D1','STAFF LEADER');
$objPHPExcel->getActiveSheet()->setCellValue('E1','ENROLLMENT TYPE');
$objPHPExcel->getActiveSheet()->setCellValue('F1','ACTIVITY CATEGORY');
$objPHPExcel->getActiveSheet()->setCellValue('G1','VLWE');
$objPHPExcel->getActiveSheet()->setCellValue('H1','CURRENT / MAX');
$objPHPExcel->getActiveSheet()->setCellValue('I1','ENROLLMENT STATUS');
// exit;
$db = $settings['pdo']['dsn'];
$conn = new PDO($db);
$result = array();
$sql = "SELECT
          category.ActivityCategory category,
          category.Title categoryTitle,
          category.Body categoryDescription,
          activity.SemesterID termId,
          seme.SemesterName,
          activity.ActivityID activityId,
          activity.ActivityType EnrollType,
          activity.ActivityCategory ActivityCategory,
          activity.Title title,
          activity.Body description,
          activity.StaffID staffId,
          CONCAT(staff.FirstName, ' ', staff.LastName) staffName,
          activity.StaffID2 staffId2,
          CONCAT(staff2.FirstName, ' ', staff2.LastName) staff2Name,
          activity.Location location,
          activity.BaseHours baseHours,
          activity.StartDate startDate,
          activity.EndDate endDate,
          activity.AllDay allDay,
          activity.DPA dpa,
          activity.VLWE workExp,
          activity.MeetingPlace MeetingPlace,
          activity.ModifyDate,
          activity.ModifyUserID,
          CONCAT(staff3.FirstName, ' ', staff3.LastName) ModifyUserName,
          activity.CreateDate,
          activity.CreateUserID,
          CONCAT(staff4.FirstName, ' ', staff4.LastName) CreateUserName,
          ISNULL(activity.CurrentEnrolment,0) curEnroll,
          ISNULL(activity.PendingEnrolment,0) penEnroll,
          ISNULL(activity.MaxEnrolment,0) maxEnroll,
          ISNULL(activity.MaxEnrolment,0) - ISNULL(activity.CurrentEnrolment,0) SubstractNum,
          CASE WHEN activity.StartDate <= GETDATE() THEN 1 ELSE 0 END overdue
              FROM tblBHSSPActivity activity
                LEFT JOIN tblBHSSPActivityConfig category ON activity.ActivityCategory = category.ActivityCategory
                LEFT JOIN tblStaff staff ON activity.StaffID = staff.StaffID
                LEFT JOIN tblStaff staff2 ON activity.StaffID2 = staff2.StaffID
                LEFT JOIN tblStaff staff3 ON activity.ModifyUserID = staff3.StaffID
                LEFT JOIN tblStaff staff4 ON activity.CreateUserID = staff4.StaffID
                LEFT JOIN tblBHSSemester seme ON seme.SemesterID = activity.SemesterID
              WHERE activity.SemesterID=72
              ORDER BY
                activity.StartDate ASC,
                activity.Title ASC";
$stmt = $conn->prepare($sql);

$stmt->execute();

while ($row = $stmt->fetch()) {
	$result[] = $row;
}
// print_r($result);
// exit;
$rowCount = 2;


$j = 2;
for ($i=0; $i < sizeof($result); $i++)
{
    // Add some data
    $title = $result[$i]['title'];
		$categoryTitle = $result[$i]['categoryTitle'];
		$startDate = $result[$i]['startDate'];
		$baseHours = $result[$i]['baseHours'];
		$staffName = $result[$i]['staffName'];
		$EnrollType = $result[$i]['EnrollType'];
		$ActivityCategory = $result[$i]['ActivityCategory'];
		$workExp = $result[$i]['workExp'];
		$curEnroll = $result[$i]['curEnroll'];

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$j", $title)
                ->setCellValue("B$j", $startDate)
								->setCellValue("C$j", $baseHours)
								->setCellValue("D$j", $staffName)
								->setCellValue("E$j", $EnrollType)
								->setCellValue("F$j", $categoryTitle)
								->setCellValue("G$j", $workExp)
								->setCellValue("H$j", $curEnroll)
								->setCellValue("I$j", $curEnroll);
		$j++;

}


$objPHPExcel->getActiveSheet()->setTitle('ACTIVITY SCHOOL LIST');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);














ob_clean();

$date= date("Y-m-d");
$filename=$date."- ACTIVITY SCHOOL List";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed

$objWriter->save('php://output');
exit;
