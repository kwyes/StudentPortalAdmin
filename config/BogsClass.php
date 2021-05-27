<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

require_once 'bogsSql.php';
require_once 'sendEmailClass.php';
include_once 'grade-data.php';

class BogsClass extends DBController {
    function getSql($name) {
        global $_SQL;
        return $_SQL[$name];
    }

    public function getMyCourseList($semesterID, $tearcherId){
      $query = $this->getSql('get-my-courselist');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $semesterID);
      $stmt->bindParam(2, $tearcherId);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $response[]=$row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function getMyCourseListV2($semesterID, $tearcherId){
      $query = $this->getSql('get-my-courselist');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $semesterID);
      $stmt->bindParam(2, $tearcherId);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $response[$row['SubjectID']]=$row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function getCategory($courseId){
      $query = $this->getSql('get-category-course');
      $query = str_replace('{courseId}', $courseId, $query);
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          $response = array();
          $row = $stmt->fetchAll();
          $response[]=$row;

         return $row;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function getCategoryItems($courseId){
      $query = $this->getSql('get-categoryItems-course');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $courseId);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $response[]=$row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function AddBogsCategory($SemesterID, $SubjectID, $categoryCode, $categoryName, $categoryWeight) {
      $query = $this->getSql('insert-bogs-category');
      $stmt = $this->db->prepare($query);
      $UserID = $_SESSION['staffId'];
      $categoryWeight = $categoryWeight * 0.01;
      $stmt->bindValue(":Text", $categoryName);
      $stmt->bindValue(":CategoryCode", $categoryCode);
      $stmt->bindValue(":SubjectID", $SubjectID);
      $stmt->bindValue(":SemesterID", $SemesterID);
      $stmt->bindValue(":CategoryWeight", $categoryWeight);
      $stmt->bindValue(":RunningTotal", '0');
      $stmt->bindValue(":ModifyUserID", $UserID);
      $stmt->bindValue(":CreateUserID", $UserID);

      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    public function AddBogsCategoryItems($SemesterID, $SubjectID, $categoryCode, $numOfItem, $outOf, $text) {
      $UserID = $_SESSION['staffId'];
      $categoryWeight = 0;
      $realQuery = '';
      $categoryArr = array();
      for($i=0; $i<$numOfItem; $i++){
        $query = $this->getSql('insert-bogs-category-items');
        $query = str_replace('{CategoryID}', $categoryCode, $query);
        $query = str_replace('{SubjectID}', $SubjectID, $query);
        $query = str_replace('{SemesterID}', $SemesterID, $query);
        $query = str_replace('{Title}', $text.' #'.$i, $query);
        $query = str_replace('{MaxValue}', $outOf, $query);
        $query = str_replace('{ScoreType}', 10, $query);
        $query = str_replace('{ItemWeight}', $categoryWeight, $query);
        $query = str_replace('{ModifyUserID}', $UserID, $query);
        $query = str_replace('{CreateUserID}', $UserID, $query);
        $realQuery .= $query."\n";
      }
      array_push($categoryArr, $categoryCode);
      $NewItemWeightQuery = $this->UpdateBogsCategoryItemWeight($categoryArr);
      $finalQuery = $realQuery.$NewItemWeightQuery;
      $stmt = $this->db->prepare($finalQuery);

      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    public function UpdateBogsCategory($data) {
      $ModifyDate = date("Y-m-d H:i:s");
      $realQuery = '';
      for($i=0; $i<count($data); $i++){
        $query = $this->getSql('update-bogs-category');
        $categoryWeight = $data[$i]['categoryWeight'];
        $query = str_replace('{Text}', $data[$i]['categoryName'], $query);
        $query = str_replace('{CategoryWeight}', $categoryWeight, $query);
        $query = str_replace('{ModifyDate}', $ModifyDate, $query);
        $query = str_replace('{CategoryID}', $data[$i]['categoryId'], $query);
        $realQuery .= $query."\n";
      }
      // return $realQuery;
      $stmt = $this->db->prepare($realQuery);
      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    public function DeleteBogsCategory($data) {
      $realQuery = '';
      for($i=0; $i<count($data); $i++){
        $gradeQuery = $this->getSql('delete-bogs-grade-items-byCategoryID');
        $categoryQuery = $this->getSql('delete-bogs-category');
        $categoryItemsQuery = $this->getSql('delete-bogs-category-items-byCategoryID');

        $gradeQuery = str_replace('{CategoryID}', $data[$i]['categoryId'], $gradeQuery);
        $categoryItemsQuery = str_replace('{CategoryID}', $data[$i]['categoryId'], $categoryItemsQuery);
        $categoryQuery = str_replace('{CategoryID}', $data[$i]['categoryId'], $categoryQuery);

        $realQuery .= $gradeQuery."\n".$categoryItemsQuery."\n".$categoryQuery."\n";
      }

      // return $realQuery;
      $stmt = $this->db->prepare($realQuery);
      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    public function UpdateBogsCategoryItems($data) {
      $ModifyDate = date("Y-m-d H:i:s");
      $realQuery = '';
      for($i=0; $i<count($data); $i++){
        $query = $this->getSql('update-bogs-category-items');
        $itemWeight = $data[$i]['itemWeight'];
        if($itemWeight == '0.3333') {
          $itemWeight = 1/3;
        }
        $query = str_replace('{Title}', $data[$i]['title'], $query);
        $query = str_replace('{AssignDate}', $data[$i]['assignDate'], $query);
        $query = str_replace('{ItemWeight}', $itemWeight, $query);
        $query = str_replace('{MaxValue}', $data[$i]['outOf'], $query);
        $query = str_replace('{ModifyDate}', $ModifyDate, $query);
        $query = str_replace('{CategoryItemID}', $data[$i]['categoryItemId'], $query);
        $realQuery .= $query."\n";
      }
      // return $realQuery;
      $stmt = $this->db->prepare($realQuery);
      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    public function DeleteBogsCategoryItems($data) {
      $realQuery = '';
      $categoryArr = array();
      $categoryItemArr = array();
      for($i=0; $i<count($data); $i++){
        $query = $this->getSql('delete-bogs-category-items');
        $query = str_replace('{CategoryItemID}', $data[$i]['categoryItemId'], $query);
        $realQuery .= $query."\n";
        array_push($categoryArr,$data[$i]['categoryId']);
        array_push($categoryItemArr,$data[$i]['categoryItemId']);
      }
      $categoryArr = array_unique($categoryArr);
      $gradeQuery = $this->getSql('delete-bogs-grade-items');
      $gradeQuery = str_replace('{CategoryItemID}', implode(',', $categoryItemArr), $gradeQuery);
      $NewItemWeightQuery = $this->UpdateBogsCategoryItemWeight($categoryArr);
      $realQuery .= $gradeQuery."\n".$NewItemWeightQuery."\n";
      // return $realQuery;
      $stmt = $this->db->prepare($realQuery);
      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            $tmp['query'] = $realQuery;
            array_push($response, $tmp);
         return $response;
        } else {
          return NULL;
        }
      $stmt->close();

    }

    function UpdateBogsCategoryItemWeight($data) {
      $realQuery = '';
      for($i=0; $i<count($data); $i++){
        $query = $this->getSql('update-calculated-itemweight');
        $query = str_replace('{CategoryID}', $data[$i], $query);
        $realQuery .= $query."\n";
      }
      return $realQuery;

    }

   public function getEnterGradeRecord($term, $course, $category, $item) {
     $query = $this->getSql('student-grade-list');
     $query = str_replace('{SubjectID}', $course, $query);
     $query = str_replace('{CategoryID}', $category, $query);
     $query = str_replace('{CategoryItemID}', $item, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
         while ($row = $stmt->fetch()) {
           $response[]=$row;
        }
        return $response;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   public function getCourseOptionsList($SemesterID, $TeacherID) {
     $query = $this->getSql('course-category-categoryitems-list');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $query = str_replace('{TeacherID}', $TeacherID, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $subejctArr = array();
        $categoryArr = array();
        $parent = '';
        $parent2 = '';
        $i = -1;
        $s = -1;
         while ($row = $stmt->fetch()) {
           $response[] = $row;

           if($row['SubjectID'] !== $parent) {
             $i++;
             $s = -1;
             $subejctArr[$i]['SubjectName'] = $row['SubjectName'];
             $subejctArr[$i]['SubjectID'] = $row['SubjectID'];
             $parent = $row['SubjectID'];
             array_push($studentArr, $parent);
           }


           if($categoryArr[$row['SubjectID']]) {
             $size = sizeof($categoryArr[$row['SubjectID']]);
             $categoryArr[$row['SubjectID']][$size]['categoryId'] = $row['CategoryID'];
             $categoryArr[$row['SubjectID']][$size]['text'] = $row['Text'];
             $categoryArr[$row['SubjectID']][$size]['weight'] = $row['CategoryWeight'];
             $categoryArr[$row['SubjectID']][$size]['sumitemweight'] = $row['SumItemWeight'];
           } else {
             $categoryArr[$row['SubjectID']][0]['categoryId'] = $row['CategoryID'];
             $categoryArr[$row['SubjectID']][0]['text'] = $row['Text'];
             $categoryArr[$row['SubjectID']][0]['weight'] = $row['CategoryWeight'];
             $categoryArr[$row['SubjectID']][0]['sumitemweight'] = $row['SumItemWeight'];
           }


        }

        $final  = array();
        $final2 = array();

        foreach($categoryArr as $key => $value){
          foreach ($categoryArr[$key] as $key2 => $value2) {
            if ( ! in_array($value2, $final[$key])) {
                $final[$key][] = $value2;
            }
          }
        }


        foreach($subejctArr as $current){
            if ( ! in_array($current, $final2)) {
                $final2[] = $current;
            }
        }

        $cate = $this->getCategoryData($response);
        $item = $this->getCategoryItemData($response);

        return array_merge(array('SubjectList' => $final2, 'CategoryList' => array_unique($final, SORT_REGULAR)),$cate, $item);
       } else {
         return NULL;
       }
     $stmt->close();
   }

   public function getCourseOptionsListV2($SemesterID, $TeacherID) {
     $query = $this->getSql('course-category-categoryitems-list');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $query = str_replace('{TeacherID}', $TeacherID, $query);
     $stmt = $this->db->prepare($query);

     if ($stmt->execute()) {
        $response = array();
        $subejctArr = array();
        $categoryArr = array();
        $studentArr = array();
        $parent = '';
        $parent2 = '';
        $i = -1;
        $s = -1;
        while ($row = $stmt->fetch()) {
          $response[] = $row;
          if($row['SubjectID'] !== $parent) {
            $i++;
            $s = -1;
            $subejctArr[$i]['SubjectName'] = $row['SubjectName'];
            $subejctArr[$i]['SubjectID'] = $row['SubjectID'];
            $parent = $row['SubjectID'];
            array_push($studentArr, $parent);
          }


          if($categoryArr[$row['SubjectID']]) {
            $size = sizeof($categoryArr[$row['SubjectID']]);
            $categoryArr[$row['SubjectID']][$size]['categoryId'] = $row['CategoryID'];
            $categoryArr[$row['SubjectID']][$size]['text'] = $row['Text'];
            $categoryArr[$row['SubjectID']][$size]['weight'] = $row['CategoryWeight'];
          } else {
            $categoryArr[$row['SubjectID']][0]['categoryId'] = $row['CategoryID'];
            $categoryArr[$row['SubjectID']][0]['text'] = $row['Text'];
            $categoryArr[$row['SubjectID']][0]['weight'] = $row['CategoryWeight'];
          }

       }
       $final  = array();
       $final2 = array();

       foreach($categoryArr as $key => $value){
         foreach ($categoryArr[$key] as $key2 => $value2) {
           if ( ! in_array($value2, $final[$key])) {
               $final[$key][] = $value2;
           }
         }
       }


       foreach($subejctArr as $current){
           if ( ! in_array($current, $final2)) {
               $final2[] = $current;
           }
       }


        $categoryArr = array_unique($final, SORT_REGULAR);
        $student = $this->getStudentListData($studentArr);
        $cate = $this->getCategoryData($response);
        $item = $this->getCategoryItemData($response);
        $termItem = $this->getTermItems($SemesterID, $TeacherID);
        $termInfo = $this->getTermInfo($SemesterID);
        return array_merge(array('SubjectList' => $final2, 'CategoryList' => $categoryArr, 'termItem' => $termItem, 'termInfo' => $termInfo, 'studentArr' => $studentArr),$cate, $item, $student);
       } else {
         return NULL;
       }
     $stmt->close();
   }

   function getStudentListBySubject($SubjectID) {
     $query = $this->getSql('student-list-bysubject');
     if(strpos($SubjectID, ',') !== false){
       $SubjectID = implode(', ', $SubjectID);
      } else{
        $SubjectID = $SubjectID;
      }
     $query = str_replace('{SubjectID}', $SubjectID, $query);

     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $row = $stmt->fetchAll();
        return $row;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   function getStudentListData($array) {
       $map = array();
       $count = count($array);
       if($count > 0) {
           foreach($array as $row) {
               $map[$row] = $this->getStudentListBySubject($row);
           }
       }
       return array(
           'studentMap' => $map
       );
   }

   function getCategoryData($array) {
       $map = array();
       $map2 = array();
       $count = count($array);
       $categoryId = null;
       if($count > 0) {
           foreach($array as $row) {
               $map[$row['SubjectID']][$row['CategoryID']] = $row;
               $map2[$row['SubjectID']][$row['CategoryID']][] = $row;
           }
       }
       return array(
           'categoryCount' => $count,
           'categoryArray' => $array,
           'categoryArrayBySubjectID' => $map2,
           'categoryMap' => $map
       );
   }

   function getCategoryItemData($array) {
       $map = array();
       $count = count($array);
       $itemId = null;
       $categoryItemArray = array();
       $categoryItemMap = array();
       if($count > 0) {
           foreach($array as $row) {
               $itemId = $row['CategoryItemID'];
               $map[$itemId] = $row;
               $categoryId = $row['CategoryID'];
               $subjectId = $row['SubjectID'];
               $categoryItemArray[$categoryId][] = $row;
               $categoryItemMap[$subjectId][$categoryId][$itemId] = $row;
           }
           // foreach($categoryItemArray as $categoryId => $items) {
           //     foreach($items['array'] as $row) {
           //         $itemId = $row['CategoryItemID'];
           //         break;
           //     }
           //     if($itemId) break;
           // }
       }
       return array(
           'itemCount' => $count,
           'itemArray' => $array,
           'itemMap' => $map,
           'categoryItemArray' => $categoryItemArray,
           'categoryItemMap' => $categoryItemMap,
       );
   }

   public function SaveEnterGradeRecord($data, $subjobject){
     $realQuery = '';
     for($i=0; $i<count($data); $i++){
       $gradeId = $data[$i]['gradeId'];
       if($gradeId == 0 || $gradeId == ''){
         $query = $this->getSql('insert-enter-grade');
       } else {
         $query = $this->getSql('update-enter-grade');
       }
       $Overridden = 0;
       $ModifyDate = date("Y-m-d H:i:s");
       $CreateDate = date("Y-m-d H:i:s");
       $UserID = $_SESSION['staffId'];
       $CategoryItemID = $subjobject['item'];
       $SemesterID = $subjobject['term'];

        $query = str_replace('{GradeID}', $data[$i]['gradeId'], $query);
        $query = str_replace('{CategoryItemID}', $CategoryItemID, $query);
        $query = str_replace('{StudSubjID}', $data[$i]['studSubjId'], $query);
        if($data[$i]['score']){
          $query = str_replace('{ScorePoint}', $data[$i]['score'], $query);
        } else {
          $query = str_replace('{ScorePoint}', 'NULL', $query);
        }
        $query = str_replace('{Exempted}', $data[$i]['exempted'], $query);
        $query = str_replace('{Overridden}', $Overridden, $query);
        $query = str_replace('{Comment}', $data[$i]['comment'], $query);
        $query = str_replace('{ModifyDate}', $ModifyDate, $query);
        $query = str_replace('{ModifyUserID}', $UserID, $query);
        $query = str_replace('{CreateDate}', $CreateDate, $query);
        $query = str_replace('{CreateUserID}', $UserID, $query);
        $query = str_replace('{SemesterID}', $SemesterID, $query);
       $realQuery .= $query."\n";
     }
     // return $realQuery;
     $stmt = $this->db->prepare($realQuery);
     if ($stmt->execute()) {
         $response = array();
           $tmp = array();
           $tmp['result'] = 1;
           $tmp['query'] = $realQuery;
           array_push($response, $tmp);
        return $response;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   function getGradeListByCourse($SemesterID, $courseId) {
     $query = $this->getSql('student-grade-list-v3');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $query = str_replace('{courseId}', $courseId, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $row = $stmt->fetchAll();
        return $row;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   function getTermItems($SemesterID, $TeacherID) {
     $query = $this->getSql('term-items');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $query = str_replace('{TeacherID}', $TeacherID, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $row = $stmt->fetchAll();
        return $row;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   function getTermInfo($SemesterID) {
     $query = $this->getSql('term-info');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $row = $stmt->fetchAll();

        $today = date('Y-m-d');
        if ($today < $row[0]['StartDate']){
          $txt = "Term Not Started";
        } elseif ($today >= $row[0]['StartDate'] && $today < $row[0]['MidCutOffDate']) {
          $txt = "Midterm In Progress";
        } elseif ($today >= $row[0]['MidCutOffDate'] && $today <= $row[0]['EndDate']) {
          $txt = "Final In Progress";
        } else {
          $txt = "Term Ended";
        }
        $row[0]['txt'] = $txt;
        return $row;
       } else {
         return NULL;
       }
     $stmt->close();
   }

   public function getOverViewGrade($data,$courseId) {
     $grade = $this->getGradeListByCourse($data['termInfo'][0]['SemesterID'], $courseId);
     $gradeData = getGradeDataV3($data['termInfo'][0]['SemesterID'], $data['termInfo'][0]['MidCutOffDate'], $courseId, $grade,
      $data['categoryMap'], $data['categoryItemMap'], $data['studentMap'], $data['termItemArray'], $data['categoryArrayBySubjectID']);

     return $gradeData;
   }

   public function getCourseSchedule($SemesterID,$TeacherID){
     $query = $this->getSql('entire-term-items-schedule');
     $query = str_replace('{SemesterID}', $SemesterID, $query);
     $query = str_replace('{TeacherID}', $TeacherID, $query);
     $stmt = $this->db->prepare($query);
     if ($stmt->execute()) {
        $response = array();
        $row = $stmt->fetchAll();
        $response['termItem'] = $row;
     }
     // return $response;
     // $termItem = $this->getTermItems($SemesterID, $TeacherID);
     $termInfo = $this->getTermInfo($SemesterID);
     return array_merge(array('termInfo' => $termInfo),$response);
   }

  public function UpdateCourseCalendarEvent($subjectId, $categoryId, $categoryItemId, $assignDate){
    $UserID = $_SESSION['staffId'];
    $ModifyDate = date("Y-m-d H:i:s");
    $realQuery = '';
    // for($i=0; $i<count($data); $i++){
      $query = $this->getSql('update-course-calendar-event');
      $query = str_replace('{AssignDate}', $assignDate, $query);
      $query = str_replace('{CategoryID}', $categoryId, $query);
      $query = str_replace('{CategoryItemID}', $categoryItemId, $query);
      $query = str_replace('{SubjectID}', $subjectId, $query);
      $query = str_replace('{ModifyDate}', $ModifyDate, $query);
      $query = str_replace('{ModifyUserID}', $UserID, $query);
      $realQuery .= $query."\n";
    // }
    // return $realQuery;
    $stmt = $this->db->prepare($realQuery);
    if ($stmt->execute()) {
        $response = array();
          $tmp = array();
          $tmp['result'] = 1;
          array_push($response, $tmp);
        return $response;
      } else {
        return NULL;
      }
    $stmt->close();
  }

  public function getWeeklyAssignment($SemesterID, $SubjectID,$from, $to) {
    $query = $this->getSql('weekly-assignment-list');
    $SubjectID = implode(', ', $SubjectID);
    $query = str_replace('{SemesterID}', $SemesterID, $query);
    $query = str_replace('{SubjectID}', $SubjectID, $query);
    $query = str_replace('{From}', $from, $query);
    $query = str_replace('{To}', $to, $query);
    $stmt = $this->db->prepare($query);
    if ($stmt->execute()) {
       $response = array();
        while ($row = $stmt->fetch()) {
          $response[$row['StudentID']][$row['Seq']]=$row;
       }
       return $response;
      } else {
        return NULL;
      }
    $stmt->close();
  }

  public function saveWeeklyAssignment($arr, $date) {
    $tQuery = '';
    $today = date("Y-m-d H:i:s");
    $UserID = $_SESSION['staffId'];
    $insert_query = $this->getSql('insert-weekly-assignment');
    $update_query = $this->getSql('update-weekly-assignment');
    for($i=0; $i<count($arr); $i++){
      $query = '';
      $gradeId = $arr[$i]['wa_id'];
      if($gradeId == 0 || $gradeId == ''){
        $query = $insert_query;
      } else {
        $query = $update_query;
      }
      $txt = addslashes($arr[$i]['wa_text']);
      $query = str_replace('{Title}', $txt, $query);
      $query = str_replace('{Status}', $arr[$i]['wa_status'], $query);
      $query = str_replace('{ModifyDate}', $today, $query);
      $query = str_replace('{waID}', $arr[$i]['wa_id'], $query);
      $query = str_replace('{StudentID}', $arr[$i]['studentId'], $query);
      $query = str_replace('{SubjectID}', $arr[$i]['course_id'], $query);
      $query = str_replace('{SemesterID}', $arr[$i]['wa_term'], $query);
      $query = str_replace('{Seq}', $arr[$i]['wa_seq'], $query);
      $query = str_replace('{AssignDate}', $date, $query);
      $query = str_replace('{ModifyUserID}', $UserID, $query);
      $query = str_replace('{CreateUserID}', $UserID, $query);


      $tQuery .= $query."\n";
    }
    // return $tQuery;
    $stmt = $this->db->prepare($tQuery);
    if ($stmt->execute()) {
        $response = array();
          $tmp = array();
          $tmp['result'] = 1;
          $tmp['query'] = $tQuery;
          array_push($response, $tmp);
       return $response;
      } else {
        return NULL;
      }
    $stmt->close();
  }

}
?>
