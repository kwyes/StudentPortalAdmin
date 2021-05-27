<?php



error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$grade = $_POST[0];
$semester = $_POST[1];
$where = "a.SemesterID = $semester";
if($grade) {
  $where = $where." AND GradeGroup = $grade";
}
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../PHPExcel/Classes/PHPExcel.php';
require_once '../../settings.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1','StudentID');
$objPHPExcel->getActiveSheet()->setCellValue('B1','Name');
$objPHPExcel->getActiveSheet()->setCellValue('C1','Grade');
$objPHPExcel->getActiveSheet()->setCellValue('D1','Communcation');
$objPHPExcel->getActiveSheet()->setCellValue('E1','Thinking');
$objPHPExcel->getActiveSheet()->setCellValue('F1','Personal');
$objPHPExcel->getActiveSheet()->setCellValue('G1','CR');
$objPHPExcel->getActiveSheet()->setCellValue('H1','TR');
$objPHPExcel->getActiveSheet()->setCellValue('I1','PR');
// exit;
$db = $settings['pdo']['dsn'];
$conn = new PDO($db);
$result = array();
$sql = "SELECT s.AssessmentID,
   s.AssessmentFormID,
   s.StudentID,
   t.FirstName,
   t.LastName,
   t.EnglishName,
   a.SemesterID,
   m.SemesterName,
   a.FormHtml,
   s.CurrentGrade,
   s.CommunicationRate,
   s.PersonalRate,
   s.ThinkingRate,
   s.CommunicationText,
   s.PersonalText,
   s.ThinkingText,
   a.Grade,
  CONVERT(char(10), s.CreateDate, 126) as CreateDate,
  CONVERT(char(10), s.ModifyDate, 126) as ModifyDate,
  CASE
    WHEN s.CurrentGrade LIKE 'AEP 10%' THEN 'aep'
    WHEN s.CurrentGrade LIKE 'AEP 11%' THEN 'aep'
    WHEN s.CurrentGrade LIKE 'AEP 8%' THEN 'g8'
    WHEN s.CurrentGrade LIKE 'AEP 9%' THEN 'g8'
    WHEN s.CurrentGrade LIKE 'Grade 8%' THEN 'g8'
    WHEN s.CurrentGrade LIKE 'Grade 9%' THEN 'g8'
    WHEN s.CurrentGrade LIKE 'Grade 10%' THEN 'g10'
    WHEN s.CurrentGrade LIKE 'Grade 11%' THEN 'g10'
    WHEN s.CurrentGrade LIKE 'Grade 12%' THEN 'g10'
    ELSE ''
  END AS GradeGroup
FROM tblBHSStudentAssessment s
LEFT JOIN tblBHSAssessmentForm a on a.AssessmentFormID = s.AssessmentFormID
LEFT JOIN tblBHSStudent t on t.StudentID = s.StudentID
LEFT JOIN tblBHSSemester m on m.SemesterID = a.SemesterID
WHERE $where";
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
    $StudentID = $result[$i]['StudentID'];
		$FirstName = $result[$i]['FirstName'];
		$CommunicationText = $result[$i]['CommunicationText'];
		$PersonalText = $result[$i]['PersonalText'];
		$ThinkingText = $result[$i]['ThinkingText'];
		$Grade = $result[$i]['Grade'];
		$CommunicationRate = $result[$i]['CommunicationRate'];
		$ThinkingRate = $result[$i]['ThinkingRate'];
		$PersonalRate = $result[$i]['PersonalRate'];

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$j", $StudentID)
                ->setCellValue("B$j", $FirstName)
								->setCellValue("C$j", $Grade)
								->setCellValue("D$j", $CommunicationText)
								->setCellValue("E$j", $ThinkingText)
								->setCellValue("F$j", $PersonalText)
								->setCellValue("G$j", $CommunicationRate)
								->setCellValue("H$j", $ThinkingRate)
								->setCellValue("I$j", $PersonalRate);
		$j++;

}


$objPHPExcel->getActiveSheet()->setTitle('Student Assessments Summary');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();

$date= date("Y-m-d");
$filename=$date."- Student Assessments Summary";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed

$objWriter->save('php://output');
exit;
