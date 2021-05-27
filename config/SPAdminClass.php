<?php

session_start();

require_once 'sql.php';
require_once 'sendEmailClass.php';

class SPAdminClass extends DBController {
    function getSql($name) {
        global $_SQL;
        return $_SQL[$name];
    }

    public function showenroll(){
      $query = $this->getSql('total-enrollments');

      $param = $_SESSION['SemesterID'];
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $param);

      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["lastName"] = $row["lastName"];
            $tmp["firstName"] = $row["firstName"];
            $tmp["englishName"] = $row["englishName"];
            $tmp["actualStartDate"] = $row["actualStartDate"];
            $tmp["actualHours"] = $row["actualHours"];
            $tmp["titleAlt"] = $row["titleAlt"];
            $tmp["self"] = "no";
            $tmp["category"] = $row["categoryTitle"];
            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function showActivities($from,$to,$staffid){
      if($staffid == 'all') {
        $query = $this->getSql('school-activity-list');
      } else {
        $query = $this->getSql('school-activity-list-by-staffId');
      }
      $termId = $_SESSION['SemesterID'];
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $from);
      $stmt->bindParam(2, $to);
      $stmt->bindParam(3, $staffid);
      $stmt->bindParam(4, $termId);

      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["activityId"] = $row["activityId"];
            $tmp["categoryDescription"] = $row["categoryDescription"];
            $tmp["staffName"] = $row["staffName"];
            $tmp["startDate"] = $row["startDate"];
            $tmp["endDate"] = $row["endDate"];
            $tmp["baseHours"] = $row["baseHours"];
            $tmp["EnrollType"] = $row["EnrollType"];
            $tmp["categoryTitle"] = $row["categoryTitle"];
            $tmp["title"] = $row["title"];
            $tmp["ActivityCategory"] = $row["ActivityCategory"];
            $tmp["workExp"] = $row["workExp"];
            $tmp["maxEnroll"] = $row["maxEnroll"];
            $tmp["curEnroll"] = $row["curEnroll"];
            $tmp["penEnroll"] = $row["penEnroll"];
            $tmp["MeetingPlace"] = $row["MeetingPlace"];
            $tmp["description"] = $row["description"];
            $tmp["location"] = $row["location"];
            $tmp["ENROLLMENTSTATUS"] = $row["overdue"];
            $tmp["ModifyDate"] = $row["ModifyDate"];
            $tmp["ModifyUserID"] = $row["ModifyUserID"];
            $tmp["CreateDate"] = $row["CreateDate"];
            $tmp["CreateUserID"] = $row["CreateUserID"];
            $tmp["ModifyUserName"] = $row["ModifyUserName"];
            $tmp["CreateUserName"] = $row["CreateUserName"];
            $tmp["SemesterName"] = $row["SemesterName"];
            $tmp["staffId"] = $row["staffId"];
            $tmp["staffId2"] = $row["staffId2"];
            $tmp["termId"] = $row["termId"];
            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function currentterm(){
      $query = $this->getSql('term-list');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["SemesterID"] = $row["SemesterID"];
            $today = date('Y-m-d');


            if($row['CurrentSemester'] == 'Y') {
                $_SESSION["SemesterID"] = $row["SemesterID"];
                $_SESSION["SemesterName"] = $row["SemesterName"];
                $_SESSION["StartDate"] = $row["StartDate"];
                $_SESSION["NextStartDate"] = $row["NextStartDate"];
                $startDate = $row["StartDate"];
                $midCutoffDate = $row["MidCutOffDate"];
                $endDate = $row["EndDate"];
                if ($today < $startDate){
                  $txt = "Term Not Started";
                } elseif ($today >= $startDate && $today < $midCutoffDate) {
                  $txt = "First half of term in progress";
                } elseif ($today >= $midCutoffDate && $today <= $endDate) {
                  $txt = "Second half of term in progress";
                } else {
                  $txt = "End of Term";
                }
            }
            $_SESSION['termStatus'] = $txt;
            $tmp["termStatus"] = $txt;
            $tmp["SemesterName"] = $row["SemesterName"];
            $tmp["StartDate"] = $row["StartDate"];
            $tmp["EndDate"] = $row["EndDate"];
            $tmp["MidCutOffDate"] = $row["MidCutOffDate"];
            $tmp["FExam1"] = $row["FExam1"];
            $tmp["FExam2"] = $row["FExam2"];
            $tmp["NextStartDate"] = $row["NextStartDate"];

            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function showMyProfile(){
      $query = $this->getSql('get-staff-info');
      $stmt = $this->db->prepare($query);
      $param = $_SESSION['staffId'];
      $stmt->bindParam(1, $param);

      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["StaffID"] = $row["StaffID"];
            $tmp["Username"] = $row["Username"];
            // $tmp["Email3"] = $row["Email3"];
            // $tmp["JoinDate"] = $row["JoinDate"];
            $tmp["FirstName"] = $row["FirstName"];
            $tmp["LastName"] = $row["LastName"];
            $_SESSION['FullName'] = $row["FirstName"]." ".$row['LastName'];
            $tmp["PositionTitle"] = $row["PositionTitle"];
            $tmp["query"] = $query;

            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }


    public function dashBoard_total_activities(){
      $query = $this->getSql('total-number-activities');
      $stmt = $this->db->prepare($query);
      $current_semester = $_SESSION['SemesterID'];
      $stmt->bindParam(1, $current_semester);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["Title"] = $row["Title"];
            $tmp["NumberOfActivity"] = $row["NumberOfActivity"];
            $tmp["ActivityCategory"] = $row["ActivityCategory"];

            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function dashBoard_my_activities(){
      $query = $this->getSql('my-number-activities');
      $stmt = $this->db->prepare($query);
      $current_semester = $_SESSION['SemesterID'];
      $stmt->bindParam(1, $current_semester);
      $stmt->bindParam(2, $_SESSION['staffId']);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['myActivities'][] = $row;
         }

         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function dashBoard_my_selfsubmit_activities(){
      $query = $this->getSql('my-number-selfsubmit-activities');
      $stmt = $this->db->prepare($query);
      $current_semester = $_SESSION['SemesterID'];
      $StartDate = $_SESSION["StartDate"];
      $NextStartDate = $_SESSION["NextStartDate"];
      $stmt->bindParam(1, $_SESSION['staffId'], PDO::PARAM_STR);
      $stmt->bindParam(2, $StartDate);
      $stmt->bindParam(3, $NextStartDate);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function get_selfsubmit_rows($from,$to,$staffid){
      if($staffid == 'all') {
        $query = $this->getSql('Self-Submit-Hour');
      } else {
        $query = $this->getSql('Self-Submit-Hour-By-StaffId');
      }
      $stmt = $this->db->prepare($query);
      $current_semester = $_SESSION['SemesterID'];
      $source = $_SESSION['source'];
      $stmt->bindParam(1, $from);
      $stmt->bindParam(2, $to);
      $stmt->bindParam(3, $staffid);
      // $stmt->bindParam(4, $current_semester);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            // $response[] = $row;
            $tmp = array();
            $tmp["source"] = $source;
            $tmp["StudentActivityID"] = $row["StudentActivityID"];
            $tmp["StudentID"] = $row["StudentID"];
            $tmp["FirstName"] = $row["FirstName"];
            $tmp["LastName"] = $row["LastName"];
            $tmp["EnglishName"] = $row["EnglishName"];
            $tmp["SchoolEmail"] = $row["SchoolEmail"];
            $tmp["Title"] = $row["Title"];
            $tmp["ApproverComment1"] = $row["ApproverComment1"];
            $tmp["SELFComment1"] = $row["SELFComment1"];
            $tmp["SELFComment2"] = $row["SELFComment2"];
            $tmp["SELFComment3"] = $row["SELFComment3"];
            $tmp["VLWE"] = $row["VLWE"];
            $tmp["Body"] = $row["Body"];
            $tmp["Location"] = $row["Location"];
            $tmp["ActivityCategory"] = $row["ActivityCategory"];
            $tmp["SelfSubmitWitness"] = $row["SelfSubmitWitness"];
            $tmp["SDate"] = $row["SDate"];
            $tmp["EDate"] = $row["EDate"];
            $tmp["Hours"] = $row["Hours"];
            $tmp["ApproverStaffID"] = $row["ApproverStaffID"];
            $tmp["ActivityStatus"] = $row["ActivityStatus"];
            $tmp["StaffFullName"] = $row["StaffFullName"];
            $tmp["SemesterName"] = $row["SemesterName"];
            $tmp["SemesterID"] = $row["SemesterID"];
            $tmp["ModifyDate"] = $row["ModifyDate"];
            $tmp["ModifyUserID"] = $row["ModifyUserID"];
            $tmp["CreateDate"] = $row["CreateDate"];
            $tmp["CreateUserID"] = $row["CreateUserID"];
            $tmp["ProgramSource"] = $row["ProgramSource"];
            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function get_selfsubmit_rows_sate($from,$to,$staffid) {
        if ($staffid == 'all') {
          $query = $this->getSql('Self-Submit-Hour-rolebogs');
        }else{
          $query = $this->getSql('Self-Submit-Hour-rolebogs-byStaffId');
        }
        $stmt = $this->db->prepare($query);
        $current_semester = $_SESSION['SemesterID'];
        $source = $_SESSION['source'];
        $rolebogs = 50;
        $stmt->bindValue(":from", $from);
        $stmt->bindValue(":to", $to);
        if ($staffid != 'all') {
          $stmt->bindValue(":staffid", $staffid);
        }
        $stmt->bindValue(":rolebogs", $rolebogs);

        if ($stmt->execute()) {
            $response = array();
            while ($row = $stmt->fetch()) {
              // $response[] = $row;
              $tmp = array();
              $tmp["source"] = $source;
              $tmp["StudentActivityID"] = $row["StudentActivityID"];
              $tmp["StudentID"] = $row["StudentID"];
              $tmp["FirstName"] = $row["FirstName"];
              $tmp["LastName"] = $row["LastName"];
              $tmp["EnglishName"] = $row["EnglishName"];
              $tmp["SchoolEmail"] = $row["SchoolEmail"];
              $tmp["Title"] = $row["Title"];
              $tmp["ApproverComment1"] = $row["ApproverComment1"];
              $tmp["SELFComment1"] = $row["SELFComment1"];
              $tmp["SELFComment2"] = $row["SELFComment2"];
              $tmp["SELFComment3"] = $row["SELFComment3"];
              $tmp["VLWE"] = $row["VLWE"];
              $tmp["Body"] = $row["Body"];
              $tmp["Location"] = $row["Location"];
              $tmp["ActivityCategory"] = $row["ActivityCategory"];
              $tmp["SelfSubmitWitness"] = $row["SelfSubmitWitness"];
              $tmp["SDate"] = $row["SDate"];
              $tmp["EDate"] = $row["EDate"];
              $tmp["Hours"] = $row["Hours"];
              $tmp["ApproverStaffID"] = $row["ApproverStaffID"];
              $tmp["ActivityStatus"] = $row["ActivityStatus"];
              $tmp["StaffFullName"] = $row["StaffFullName"];
              $tmp["SemesterName"] = $row["SemesterName"];
              $tmp["SemesterID"] = $row["SemesterID"];
              $tmp["ModifyDate"] = $row["ModifyDate"];
              $tmp["ModifyUserID"] = $row["ModifyUserID"];
              $tmp["CreateDate"] = $row["CreateDate"];
              $tmp["CreateUserID"] = $row["CreateUserID"];
              $tmp["ProgramSource"] = $row["ProgramSource"];
              array_push($response, $tmp);
           }
           return $response;
        } else {
            return NULL;
        }
        $stmt->close();
      }

    public function update_selfsubmit_status($studentActivityId,$studentId,$info,$type){
      $query = $this->getSql('Update-selfsubmit-status');
      if($type == 0){
        $activityStatus = "80";
      } else {
        $activityStatus = "90";
      }

      $today = date("Y-m-d H:i:s");

      $query = str_replace('{activityStatus}', $activityStatus, $query);
      $query = str_replace('{ModifyDate}', $today, $query);
      $query = str_replace('{ModifyUserID}', $_SESSION['staffId'], $query);
      $query = str_replace('{activityIdList}', implode(',', $studentActivityId), $query);
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            // $sendEmail = $this->sendMassEmailFromAjax($info,$activityStatus);
            array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function AddActivityRecords($activityStudentId, $activityName,$activityCategory,$activityLocation,$activitySDate,$activityEDate,$activityHours,$activityVLWE,$activityApprover,$activityComment1,$activityComment2,$activityComment3){
      $query = $this->getSql('insert-activity-record');
      // $SemesterID = $_SESSION['SemesterID'];
      $ActivityStatus = 80;
      $ActivityID = 1000000;
      $ProgramSource = 'SELF';
      $AllDay = 0;
      $DPA = 0;
      $activitySDate = date("Y-m-d", strtotime($activitySDate));
      $activityEDate = date("Y-m-d", strtotime($activityEDate));

      $SemesterID = $this->getSemesterIDFromSDate($activitySDate);
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":SemesterId", $SemesterID);
      $stmt->bindValue(":ActivityStatus", $ActivityStatus);
      $stmt->bindValue(":studentid", $activityStudentId);
      $stmt->bindValue(":ActivityID", $ActivityID);
      $stmt->bindValue(":ProgramSource", $ProgramSource);
      $stmt->bindValue(":ActivityCategory", $activityCategory);
      $stmt->bindValue(":Title", $activityName);
      // $stmt->bindValue(":Body", $Body);
      $stmt->bindValue(":Location", $activityLocation);
      $stmt->bindValue(":SDate", $activitySDate);
      $stmt->bindValue(":EDate", $activityEDate);
      $stmt->bindValue(":Hours", $activityHours);
      $stmt->bindValue(":AllDay", $AllDay);
      $stmt->bindValue(":DPA", $DPA);
      $stmt->bindValue(":VLWE", $activityVLWE);
      $stmt->bindValue(":ApproverStaffID", $activityApprover);
      $stmt->bindValue(":CreateUserID", $activityApprover);
      $stmt->bindValue(":ModifyUserID", $activityApprover);
      // $stmt->bindValue(":Witness", $activityWit);
      $stmt->bindValue(":SELFComment1", $activityComment1);
      $stmt->bindValue(":SELFComment2", $activityComment2);
      $stmt->bindValue(":SELFComment3", $activityComment3);

      if ($stmt->execute()) {
          $response = array();
          $tmp = array();
          $tmp['result'] = 1;
          // $sendEmail = $this->sendEmailFromAjax($activityStudentId, 'test', $activityComment);
          // $sendEmail = $this->sendEmailFromAjax($activityStudentId,'Y', $ActivityStatus, $activityComment);
          array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getDetailofActivity($ActivityId) {
      $query = $this->getSql('detail-school-activity');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $ActivityId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function searchStudentByName($param){
      $query = $this->getSql('search-student');
      $stmt = $this->db->prepare($query);
      $param = addslashes($param);
      $param = '%'.$param.'%';
      $stmt->bindParam(1, $param, PDO::PARAM_STR);
      $stmt->bindParam(2, $param, PDO::PARAM_STR);
      $stmt->bindParam(3, $param, PDO::PARAM_STR);
      $stmt->bindParam(4, $param, PDO::PARAM_STR);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function searchStudentByNameInReport($param){
      $query = $this->getSql('search-student-report');
      $stmt = $this->db->prepare($query);
      $param = addslashes($param);
      $param = '%'.$param.'%';
      $stmt->bindParam(1, $param, PDO::PARAM_STR);
      $stmt->bindParam(2, $param, PDO::PARAM_STR);
      $stmt->bindParam(3, $param, PDO::PARAM_STR);
      $stmt->bindParam(4, $param, PDO::PARAM_STR);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function searchStudentByNameInCareer($param){
      $query = $this->getSql('search-student-career');
      $param = addslashes($param);
      $param = '%'.$param.'%';
      $semesterId = $_SESSION['SemesterID'];
      $query = str_replace('{semesterID}', $semesterId, $query);
      $query = str_replace('{param}', $param, $query);
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetApprovalList(){
      $query = $this->getSql('approval-list');
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetApprovalListRolebogs() {
      $query = $this->getSql('approval-list-rolebogs');
      $stmt = $this->db->prepare($query);
      $rolebogs = 50;
      $stmt->bindParam(1, $rolebogs);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetEnrollMemberByActivityId($SemesterID, $ActivityId){
      $query = $this->getSql('activity-enroll-member');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $ActivityId);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function editSchoolActivityDetail($activityId, $name, $staffList, $staffList2, $start, $end, $actMdlvlwe, $activityCategory, $description, $enrollmentType, $hours, $location, $place, $maxEnroll){
      $start = date("Y-m-d H:i:s", strtotime($start));
      $end = date("Y-m-d H:i:s", strtotime($end));
      $today = date("Y-m-d H:i:s");
      $ModifyUserID = $_SESSION['staffId'];
      $query = $this->getSql('update-activity-detail');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":Title", $name);
      $stmt->bindValue(":StaffID", $staffList);
      $stmt->bindValue(":StaffID2", $staffList2);
      $stmt->bindValue(":Body", $description);
      $stmt->bindValue(":ActivityCategory", $activityCategory);
      $stmt->bindValue(":ActivityType", $enrollmentType);
      $stmt->bindValue(":VLWE", $actMdlvlwe);
      $stmt->bindValue(":Location", $location);
      $stmt->bindValue(":MeetingPlace", $place);
      $stmt->bindValue(":StartDate", $start);
      $stmt->bindValue(":EndDate", $end);
      $stmt->bindValue(":BaseHours", $hours);
      $stmt->bindValue(":MaxEnrolment", $maxEnroll);
      $stmt->bindValue(":ModifyUserID", $ModifyUserID);
      $stmt->bindValue(":ModifyDate", $today);
      $stmt->bindValue(":ActivityID", $activityId);
      if ($stmt->execute()) {
       $response = array();
       $tmp = array();
       $tmp['result'] = 1;
       array_push($response, $tmp);
       $this->updateStudentActivityTable($name, $description, $activityCategory, $staffList, $actMdlvlwe, $location, $activityId, $start, $end, $hours);
       return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }


    public function updateStudentActivityStatus($studentActivityId, $type){
      $query = $this->getSql('Update-activity-student-status');
      if($type == 0){
        $activityStatus = "20";
      } elseif ($type == 1) {
        $activityStatus = "80";
      } else {
        $activityStatus = "90";
      }

      $query = str_replace('{activityStatus}', $activityStatus, $query);
      $query = str_replace('{activityIdList}', implode(',', $studentActivityId), $query);
      $stmt = $this->db->prepare($query);
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

    public function insertActivityRecordByStaff($studentId, $activityId){
      $activityStatus = 20;
      $ApproverStaffID = $_SESSION['staffId'];
      $CreateUserID = $_SESSION['staffId'];
      $ModifyUserID = $_SESSION['staffId'];
      $query = $this->getSql('insert-activity-record-byStaff');
      $query=str_replace('{ActivityStatus}', $activityStatus,$query);
      $query=str_replace('{StudentID}', $studentId,$query);
      $query=str_replace('{ApproverStaffID}', $ApproverStaffID,$query);
      $query=str_replace('{CreateUserID}', $CreateUserID,$query);
      $query=str_replace('{ModifyUserID}', $ModifyUserID,$query);
      $query=str_replace('{ActivityID}', $activityId,$query);
      $stmt = $this->db->prepare($query);
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

    function updateStudentActivityTable($name, $description, $activityCategory, $staffList, $actMdlvlwe, $location, $activityId, $start, $end, $hours){
      $query = $this->getSql('update-student-activity-detail');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":Title", $name);
      $stmt->bindValue(":Body", $description);
      $stmt->bindValue(":ActivityCategory", $activityCategory);
      $stmt->bindValue(":ApproverStaffID", $staffList);
      $stmt->bindValue(":VLWE", $actMdlvlwe);
      $stmt->bindValue(":Location", $location);
      // $stmt->bindValue(":MeetingPlace", $place
      $stmt->bindValue(":SDate", $start);
      $stmt->bindValue(":EDate", $end);
      $stmt->bindValue(":Hours", $hours);
      $stmt->bindValue(":ActivityID", $activityId);

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

    public function deleteActivity($ActivityId){
      $query = $this->getSql('delete-activity');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $ActivityId);
      if ($stmt->execute()) {
        $response = array();
        $tmp = array();
        $tmp['result'] = 1;
        array_push($response, $tmp);
        $this->deleteStudentActivty($ActivityId);
        return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function deleteStudentActivty($ActivityId){
      $query = $this->getSql('delete-student-activity');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $ActivityId);
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

    public function addAcitivityByStaff($title, $staff1, $staff2, $description, $category, $enrollType, $Actvlwe, $location, $place, $start, $end, $hours, $maxEnroll) {
      $start = date("Y-m-d H:i:s", strtotime($start));
      $end = date("Y-m-d H:i:s", strtotime($end));
      $allday = 0;
      $dpa = 0;

      $semesterId = $_SESSION['SemesterID'];
      $staffId = $_SESSION['staffId'];
      $query = $this->getSql('insert-school-activity');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":Title", $title);
      $stmt->bindValue(":Body", $description);
      $stmt->bindValue(":ActivityCategory", $category);
      $stmt->bindValue(":ActivityType", $enrollType);
      $stmt->bindValue(":MaxEnrolment", $maxEnroll);
      $stmt->bindValue(":SemesterID", $semesterId);
      $stmt->bindValue(":StaffID", $staff1);
      $stmt->bindValue(":StaffID2", $staff2);
      $stmt->bindValue(":Location", $location);
      $stmt->bindValue(":MeetingPlace", $place);
      $stmt->bindValue(":BaseHours", $hours);
      $stmt->bindValue(":StartDate", $start);
      $stmt->bindValue(":EndDate", $end);
      $stmt->bindValue(":VLWE", $Actvlwe);
      $stmt->bindValue(":ModifyUserID", $staffId);
      $stmt->bindValue(":CreateUserID", $staffId);
      $stmt->bindValue(":AllDay", $allday);
      $stmt->bindValue(":DPA", $dpa);
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

    public function editSelfsubmitByStaff($studentId, $studentActivityId, $category, $comment, $comment1, $comment2, $comment3, $sDate, $eDate, $hours, $status, $location, $vlwe, $staff1, $title, $preStatus, $student, $StaffFullName) {
      $today = date("Y-m-d H:i:s");
      $ModifyUserID = $_SESSION['staffId'];
      $sDate = date("Y-m-d", strtotime($sDate));
      $eDate = date("Y-m-d", strtotime($eDate));
      $query = $this->getSql('update-student-school-activity');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":Title", $title);
      // $stmt->bindValue(":Body", $description);
      $stmt->bindValue(":ActivityCategory", $category);
      $stmt->bindValue(":VLWE", $vlwe);
      $stmt->bindValue(":Location", $location);
      $stmt->bindValue(":SDate", $sDate);
      $stmt->bindValue(":EDate", $eDate);
      $stmt->bindValue(":Hours", $hours);
      $stmt->bindValue(":ActivityStatus", $status);
      // $stmt->bindValue(":SelfSubmitWitness", $witness);
      $stmt->bindValue(":ApproverStaffID", $staff1);
      $stmt->bindValue(":ApproverComment1", $comment);
      $stmt->bindValue(":SELFComment1", $comment1);
      $stmt->bindValue(":SELFComment2", $comment2);
      $stmt->bindValue(":SELFComment3", $comment3);
      $stmt->bindValue(":ModifyUserID", $ModifyUserID);
      $stmt->bindValue(":ModifyDate", $today);
      $stmt->bindValue(":StudentActivityID", $studentActivityId);
      $stmt->bindValue(":StudentID", $studentId);

      if ($stmt->execute()) {
        $response = array();
        $tmp = array();
        $tmp['result'] = 1;
        if($preStatus !== $status){
          $emailBody = makeBody($student, $title, $location, $sDate, $eDate, $hours, $preStatus, $status, $StaffFullName, $comment);
          $sendEmail = $this->sendEmailFromAjax($studentId,'Y', $status, $emailBody);
        }
        array_push($response, $tmp);
        return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetUserName($id, $type){
      if($type == 'student'){
        $query = $this->getSql('get-student-FullName');
      } else {
        $query = $this->getSql('get-staff-FullName');
      }
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $id, PDO::PARAM_STR);
      if ($stmt->execute()) {
        $row = $stmt->fetch();
        $response[] = $row;
        return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function get_vlwe_rows($from,$to,$staffid){
      $query = $this->getSql('get-vlwe-hour');
      $current_semester = $_SESSION['SemesterID'];
      $from = date("Y-m-d H:i:s", strtotime($from));
      $to = date("Y-m-d H:i:s", strtotime($to));
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $from, PDO::PARAM_STR);
      $stmt->bindParam(2, $to, PDO::PARAM_STR);
      $stmt->bindParam(3, $staffid, PDO::PARAM_STR);
      $stmt->bindParam(4, $current_semester);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["StudentActivityID"] = $row["StudentActivityID"];
            $tmp["StudentID"] = $row["StudentID"];
            $tmp["FirstName"] = $row["FirstName"];
            $tmp["LastName"] = $row["LastName"];
            $tmp["EnglishName"] = $row["EnglishName"];
            $tmp["Title"] = $row["Title"];
            $tmp["Comment"] = $row["Comment"];
            $tmp["VLWE"] = $row["VLWE"];
            $tmp["Body"] = $row["Body"];
            $tmp["Location"] = $row["Location"];
            $tmp["ActivityCategory"] = $row["ActivityCategory"];
            $tmp["SDate"] = $row["SDate"];
            $tmp["Hours"] = $row["Hours"];
            $tmp["ApproverStaffID"] = $row["ApproverStaffID"];
            $tmp["ActivityStatus"] = $row["ActivityStatus"];
            $tmp["StaffFullName"] = $row["StaffFullName"];
            $tmp["VLWESupervisor"] = $row["VLWESupervisor"];
            $tmp["SemesterName"] = $row["SemesterName"];
            $tmp["ModifyDate"] = $row["ModifyDate"];
            $tmp["ModifyUserID"] = $row["ModifyUserID"];
            $tmp["CreateDate"] = $row["CreateDate"];
            $tmp["CreateUserID"] = $row["CreateUserID"];
            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function AddVlweRecords($vlweStudentId, $vlweName,$vlweCategory,$vlweLocation,$vlweSDate,$vlweHours,$vlweVLWE,$vlweSupervisor,$vlweApprover,$vlweComment, $Body){
      $today = date("Y-m-d H:i:s");
      $CreateUserID = $_SESSION['staffId'];
      $SemesterID = $_SESSION['SemesterID'];
      $date = date("Y-m-d H:i:s", strtotime($vlweSDate));
      $ActivityStatus = 80;
      $ActivityID = 1000000;
      $ProgramSource = 'VLWE';
      $AllDay = 0;
      $DPA = 0;
      $query = $this->getSql('insert-vlwe-record');
      $stmt = $this->db->prepare($query);

      $stmt->bindValue(":SemesterId", $SemesterID);
      $stmt->bindValue(":ActivityStatus", $ActivityStatus);
      $stmt->bindValue(":studentid", $vlweStudentId);
      $stmt->bindValue(":ActivityID", $ActivityID);
      $stmt->bindValue(":ProgramSource", $ProgramSource);
      $stmt->bindValue(":ActivityCategory", $vlweCategory);
      $stmt->bindValue(":Title", $vlweName);
      $stmt->bindValue(":Body", $Body);
      $stmt->bindValue(":Location", $vlweLocation);
      $stmt->bindValue(":SDate", $date);
      $stmt->bindValue(":EDate", $date);
      $stmt->bindValue(":Hours", $vlweHours);
      $stmt->bindValue(":AllDay", $AllDay);
      $stmt->bindValue(":DPA", $DPA);
      $stmt->bindValue(":VLWE", $vlweVLWE);
      $stmt->bindValue(":ApproverStaffID", $vlweApprover);
      $stmt->bindValue(":CreateUserID", $CreateUserID);
      $stmt->bindValue(":ModifyUserID", $CreateUserID);
      $stmt->bindValue(":supervisor", $vlweSupervisor);
      $stmt->bindValue(":Comment", $vlweComment);

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

    public function updateActivityEnrollMember($ActivityId) {
      $query = $this->getSql('update-activity-enroll-member');
      $numofMember = $this->getActivityEnrollNumber($ActivityId);
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $numofMember['cur']);
      $stmt->bindParam(2, $numofMember['pen']);
      $stmt->bindParam(3, $ActivityId);
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


    public function editVlweByStaff($studentId, $studentActivityId, $category, $comment, $date, $description, $hours, $location, $vlwe, $staff1, $title, $supervisor) {
      $today = date("Y-m-d H:i:s");
      $ModifyUserID = $_SESSION['staffId'];
      $date = date("Y-m-d H:i:s", strtotime($date));


      $query = $this->getSql('update-student-vlwe');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(":Title", $title);
      $stmt->bindParam(":Description", $description);
      $stmt->bindParam(":Category", $category);
      $stmt->bindParam(":VLWE", $vlwe);
      $stmt->bindParam(":Location", $location);
      $stmt->bindParam(":SDate", $date);
      $stmt->bindParam(":EDate", $date);
      $stmt->bindParam(":Hours", $hours);
      $stmt->bindParam(":VLWESupervisor", $supervisor);
      $stmt->bindParam(":ApproverStaffID", $staff1);
      $stmt->bindParam(":Comment", $comment);
      $stmt->bindParam(":ModifyUserID", $ModifyUserID);
      $stmt->bindParam(":ModifyDate", $today);
      $stmt->bindParam(":StudentActivityID", $studentActivityId);
      $stmt->bindParam(":StudentID", $studentId);

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

    function getActivityEnrollNumber($ActivityId) {
      $query = $this->getSql('get-activity-enroll-member');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $ActivityId);
      $cur = 0;
      $pen = 0;

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            if($row['ActivityStatus'] == '10'){
              $pen += $row['num'];
            } elseif ($row['ActivityStatus'] == '20' || $row['ActivityStatus'] == '80') {
              $cur += $row['num'];
            }
         }
         $response['cur'] = $cur;
         $response['pen'] = $pen;
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getStudentEmailbyId($studentId){
      $query = $this->getSql('get-student-FullName');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $studentId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getMyStudentList($name) {
      $query = $this->getSql('my-student-list-by-boarding');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $name);
      $stmt->bindParam(2, $name);
      $source = $_SESSION['source'];

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['source'] = $source;
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getCurrentStudentList() {
      $query = $this->getSql('current-student-list');
      $query = str_replace('{semesterId}', $_SESSION["SemesterID"], $query);
      $stmt = $this->db->prepare($query);

      $source = $_SESSION['source'];

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['source'] = $source;
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getCurrentStudentListG8G9($from, $to) {
      $query = $this->getSql('current-student-list-G8-G9');
      $query = str_replace('{from}', $from, $query);
      $query = str_replace('{to}', $to, $query);
      $stmt = $this->db->prepare($query);
      // return $query;
      $source = $_SESSION['source'];

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['source'] = $source;
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getUserAuth($studentId) {
      $query = $this->getSql('get-user-auth-student');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $studentId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
            $response[0]['staffId'] = $_SESSION['staffId'];
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getSemesterIDFromSDate($sDate) {
      $query = $this->getSql('find-semesterid-date');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $sDate);
      $stmt->bindValue(2, $sDate);
      if ($stmt->execute()) {
        $row = $stmt->fetch();
        return $row['SemesterID'];
      } else {
        return '999';
      }
      $stmt->close();
    }

    public function getVLWEReport($studentid) {
      $query = $this->getSql('get-vlwe-report');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $studentid);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getSelfSubmitRowsByStudent($studentid) {
      $query = $this->getSql('get-selfsubmit-by-student');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $studentid);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getCareerStaffList($SemesterID){
      $query = $this->getSql('career-life-staff-list');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $SemesterID);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getCareerRecordList($TeacherID){
      if($TeacherID == 'all') {
        $query = $this->getSql('career-life-record-list');
      } else {
        $query = $this->getSql('career-life-record-list-by-staffId');
      }
      $source = $_SESSION['source'];
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(1, $TeacherID);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['source'] = $source;
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }



    function getListCareerSubject($SemesterID) {
      $query = $this->getSql('get-list-career-subject');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $SemesterID);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['data'][] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function update_career_status($projectId,$studentId,$info,$type){
      $query = $this->getSql('Update-career-status');
      $today = date("Y-m-d H:i:s");

      if($type == 0){
        $ApprovalStatus = "70";
        $ApprovalDate = $today;
      } elseif ($type == 1) {
        $ApprovalStatus = "80";
        $ApprovalDate = $today;
      } else {
        $ApprovalStatus = "90";
        $ApprovalDate = NULL;
      }



      $query = str_replace('{ApprovalStatus}', $ApprovalStatus, $query);
      $query = str_replace('{ApprovalDate}', $ApprovalDate, $query);
      $query = str_replace('{ModifyDate}', $today, $query);
      $query = str_replace('{ModifyUserID}', $_SESSION['staffId'], $query);
      $query = str_replace('{ProjectIdList}', implode(',', $projectId), $query);
      $stmt = $this->db->prepare($query);
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


    public function UpdateCareerLife($projectId,$course,$subjectName,$teacherID,$topic,$category,$firstName,$lastName,$email,$phone,$position,$description,$status,$preStatus,$studentName, $staffName,$tComment){
      $query = $this->getSql('update-career-life');

      $ModifyUserID = $_SESSION['staffId'];
      $today = date("Y-m-d H:i:s");

      $stmt = $this->db->prepare($query);

      $stmt->bindValue(":ProjectID", $projectId);
      $stmt->bindValue(":SubjectID", $course);
      $stmt->bindValue(":SubjectName", $subjectName);
      $stmt->bindValue(":TeacherID", $teacherID);
      $stmt->bindValue(":ProjectTopic", $topic);
      $stmt->bindValue(":ProjectCategory", $category);
      $stmt->bindValue(":MentorFName", $firstName);
      $stmt->bindValue(":MentorLName", $lastName);
      $stmt->bindValue(":MentorEmail", $email);
      $stmt->bindValue(":MentorPhone", $phone);
      $stmt->bindValue(":MentorDesc", $position);
      $stmt->bindValue(":ProjectDesc", $description);
      $stmt->bindValue(":ModifyUserID", $ModifyUserID);
      $stmt->bindValue(":ModifyDate", $today);
      $stmt->bindValue(":ApprovalStatus", $status);
      $stmt->bindValue(":TeacherComment", $tComment);
      $mentorName = $firstName.' '.$lastName;

      if ($stmt->execute()) {
          $response = array();
            $tmp = array();

            if($preStatus !== $status){
              $emailBody = makeBodyCareer($subjectName, $studentName, $topic, $mentorName, $staffName, $preStatus, $status, $tComment);
              $sendEmail = $this->sendEmailFromAjax2($studentId,'C', $status, $emailBody, $teacherID);
            }

            $tmp['result'] = 1;
            // $tmp['emailresult'] = $emailresult;
            array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
    }

    function getStaffEmailbyId($staffId){
      $query = $this->getSql('get-staff-email-by-id');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $staffId);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function AddCareerLife($studentId,$course,$category,$topic,$firstName,$lastName,$email,$phone,$position,$description, $semesterId) {
      $query = $this->getSql('insert-career-record');
      $stmt = $this->db->prepare($query);
      $SemesterID = $semesterId;
      $CreateUserID = $_SESSION['staffId'];
      $status = 70;
      $subjectInfo = $this->GetSubjectInfo($course, $SemesterID, $studentId);
      $today = date("Y-m-d H:i:s");

      $studentCourseId = $subjectInfo[0]['studentCourseId'];
      $courseName = $subjectInfo[0]['courseName'];
      $TeacherID = $subjectInfo[0]['TeacherID'];
      $CourseCd = $subjectInfo[0]['CourseCd'];
      $staffFName = $subjectInfo[0]['staffFName'];
      $staffLName = $subjectInfo[0]['staffLName'];
      $stmt->bindValue(":StudSubjID", $studentCourseId);
      $stmt->bindValue(":StudentID", $studentId);
      $stmt->bindValue(":SubjectID",$course);
      $stmt->bindValue(":SubjectName", $courseName);
      $stmt->bindValue(":TeacherID", $TeacherID);
      $stmt->bindValue(":CourseCd", $CourseCd);
      $stmt->bindValue(":SemesterID", $SemesterID);
      $stmt->bindValue(":ProjectTopic", $topic);
      $stmt->bindValue(":MentorFName", $firstName);
      $stmt->bindValue(":MentorLName", $lastName);
      $stmt->bindValue(":MentorDesc", $position);
      $stmt->bindValue(":MentorEmail", $email);
      $stmt->bindValue(":MentorPhone", $phone);
      $stmt->bindValue(":ProjectDesc", $description);
      $stmt->bindValue(":ProjectCategory", $category);
      $stmt->bindValue(":ApprovalDate", $today);

      $stmt->bindValue(":StudentComment", "");
      $stmt->bindValue(":TeacherComment", "");
      $stmt->bindValue(":ApprovalStatus", $status);
      $stmt->bindValue(":ModifyUserID", $CreateUserID);
      $stmt->bindValue(":CreateUserID", $CreateUserID);


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

    function GetSubjectInfo($course, $SemesterID, $studentid) {
      $query = $this->getSql('get-subject-info');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $studentid);
      $stmt->bindParam(3, $course);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetMyCourses($studentid){
      $query = $this->getSql('course-list');
      $stmt = $this->db->prepare($query);
      $SemesterID = $_SESSION['SemesterID'];
      $stmt->bindParam(1, $SemesterID);
      $stmt->bindParam(2, $studentid);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response['courses'][] = $row;
            $studentCourseId[] = $row['studentCourseId'];
          }

          // $c = new SPAdminClass();
          $absenselateResponse = $this->GetMyAbsenseLate($studentCourseId);
          $response_final = array_merge($response,$absenselateResponse);
         return $response_final;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function GetMyAbsenseLate($studentCourseId){
      if($studentCourseId) {
          $courseList = array();
          foreach($studentCourseId as $courseId) {
              $courseList[] = "'{$courseId}'";
          }
          $query = $this->getSql('absent-list-by-courselist');
          $query = str_replace('{studentCourseList}', implode(',', $courseList), $query);
          $stmt = $this->db->prepare($query);
          if ($stmt->execute()) {
            $response['Absense'][] = '';
            while ($row = $stmt->fetch()) {
              $response['Absense'][] = $row;
            }
             return $response;
          } else {
              return NULL;
          }
          $stmt->close();

      } else {
          return array();
      }
    }

    public function studentInfo($studentid){
      $query = $this->getSql('student-info');
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(1, $studentid);
      $stmt->bindParam(2, $_SESSION['SemesterID']);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
            // $response[0]['imgsrc'] = image_view1('https://asset.bodwell.edu/OB4mpVPg/student/bhs'.$studentid.'.jpg');
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetMyGrades($studentid){
        // $query = $this->getSql('course-grade-list');
        // $studentid = $_SESSION['studentId'];
        $SemesterID = $_SESSION['SemesterID'];
        $sql = $this->getSql('course-grade-list');
        $sql = str_replace('{termId}', $SemesterID, $sql);
        $sql = str_replace('{studentId}', $studentid, $sql);

        $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
              $tmp = array();
              $response[] = $row;
            }
           return $response;
        } else {
            return NULL;
        }
        $stmt->close();
    }

    public function getWeeklyAssignmentData($from,$to,$term,$studentId){
        $sql = $this->getSql('weekly-assignment-list');
        $sql = str_replace('{from}', $from, $sql);
        $sql = str_replace('{to}', $to, $sql);
        $sql = str_replace('{term}', $term, $sql);
        $sql = str_replace('{studentId}', $studentId, $sql);
        // return $sql;
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
              $response[] = $row;
            }
           return $response;
        } else {
            return NULL;
        }
        $stmt->close();
    }

    public function getStudentLeaveRequest($from,$to) {
      $sql = $this->getSql('get-student-leave-request');
      $to = $to. ' 23:59:59.999';
      $from = $from. ' 00:00:00.000';
      $sql = str_replace('{from}', $from, $sql);
      $sql = str_replace('{to}', $to, $sql);
      $stmt = $this->db->prepare($sql);

      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function editLeaveRequest($LeaveID, $staff1, $Reason, $ToDo, $comment, $stfcomment, $sDate, $eDate, $status, $InDate, $OutDate) {
      $sql = $this->getSql('edit-student-leave-request');
      $ModifyUserID = $_SESSION['staffId'];
      $date = date('Y-m-d h:i:s');

      $comment = str_replace("'","''",$comment);
      $stfcomment = str_replace("'","''",$stfcomment);
      $ToDo = str_replace("'","''",$ToDo);
      $Reason = str_replace("'","''",$Reason);

      $sql = str_replace('{SDate}', $sDate, $sql);
      $sql = str_replace('{EDate}', $eDate, $sql);
      $sql = str_replace('{ToDo}', $ToDo, $sql);
      $sql = str_replace('{Reason}', $Reason, $sql);
      $sql = str_replace('{Comment}', $comment, $sql);
      $sql = str_replace('{StaffComment}', $stfcomment, $sql);
      $sql = str_replace('{ApprovalStaff}', $staff1, $sql);
      $sql = str_replace('{LeaveStatus}', $status, $sql);
      $sql = str_replace('{InDate}', $InDate, $sql);
      $sql = str_replace('{OutDate}', $OutDate, $sql);
      $sql = str_replace('{ModifyUserID}', $ModifyUserID, $sql);
      $sql = str_replace('{ModifyDate}', $date, $sql);
      $sql = str_replace('{LeaveID}', $LeaveID, $sql);
      // return $sql;
      $stmt = $this->db->prepare($sql);

      if ($stmt->execute()) {
        $response = array();
        $response['result'] = 1;
       return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function saveStudentLeaveBan($studentId, $sDate, $eDate, $comment) {
      $today = date("Y-m-d H:i:s");
      $comment = str_replace("'","''",$comment);
      $sql = $this->getSql('insert-student-leave-ban');
      $sql = str_replace('{CreateUserID}', $_SESSION['staffId'], $sql);
      $sql = str_replace('{StudentID}', $studentId, $sql);
      $sql = str_replace('{FromDate}', $sDate, $sql);
      $sql = str_replace('{ToDate}', $eDate, $sql);
      $sql = str_replace('{Comment}', $comment, $sql);
      $sql = str_replace('{ModifyUserID}', $_SESSION['staffId'], $sql);

      $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
           return $response;
        } else {
            return NULL;
        }
    }

    public function editLeaveBan($BanID, $sDate, $eDate, $studentID, $status, $comment) {
      $today = date("Y-m-d H:i:s");
      $sql = $this->getSql('edit-student-leave-ban');
      $sql = str_replace('{BanID}', $BanID, $sql);
      $sql = str_replace('{StudentID}', $studentID, $sql);
      $sql = str_replace('{FromDate}', $sDate, $sql);
      $sql = str_replace('{ToDate}', $eDate, $sql);
      $sql = str_replace('{Comment}', $comment, $sql);
      $sql = str_replace('{Status}', $status, $sql);
      $sql = str_replace('{ModifyUserID}', $_SESSION['staffId'], $sql);
      $sql = str_replace('{ModifyDate}', $today, $sql);
      $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {
            $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
           return $response;
        } else {
            return NULL;
        }

    }

    function getSelfAssessments($term) {
      $query = $this->getSql('self-assessments');
      $stmt = $this->db->prepare($query);
      if($term) {
        $param = $term;
      } else {
        $param = $_SESSION['SemesterID'];
      }
      $stmt->bindValue(':term', $param);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getStudentLeaveBan() {
      $query = $this->getSql('student-leave-ban');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    function getTranscriptRequest() {
      $query = $this->getSql('get-transcript-request');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $response[] = $row;
          }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function saveTranscriptRequest($RequestID, $paid, $status, $prestatus) {
      $today = date("Y-m-d H:i:s");
      $sql = $this->getSql('save-transcript-request');
      $stmt = $this->db->prepare($sql);

      $stmt->bindValue(':Paid', $paid);
      $stmt->bindValue(':Status', $status);
      $stmt->bindValue(':RequestID', $RequestID);
      $stmt->bindValue(':ModifyDate', $today);
      $stmt->bindValue(':ModifyUserID', $_SESSION['staffId']);

        if ($stmt->execute()) {
            $response = array();
            $tmp = array();
            $tmp['result'] = 1;
            array_push($response, $tmp);
           return $response;
        } else {
            return NULL;
        }
    }

    function sendEmailFromAjax($studentId, $first, $status, $body) {
        $from = array('email' => 'helpdesk@bodwell.edu', 'name' => 'BHS IT Help Desk');
        $studentinfo = $this->getStudentEmailbyId($studentId);

        $email = $studentinfo[0]['SchoolEmail'];
        // $email = 'mike.doe@student.bodwell.edu';

        $FullName = $studentinfo[0]['FullName'];
        $EnglishName = $studentinfo[0]['EnglishName'];
        $cc = array();

        if($first == 'Y'){
          if($status == '80') {
            $subject = 'Self-submitted hours - Hours Approved';
          } elseif ($status == '60') {
            $subject = 'Self-submitted hours - Pending Approval';
          } else {
            $subject = 'Self-submitted hours - Rejected';
          }
        } else {
          $subject = 'Error';
        }
        $to = array(
            array('email' => $email, 'name' => "{$FullName}")
        );

        $res = sendEmail($from, $to, $cc, $subject, $body);
    }


    function sendEmailFromAjax2($studentId, $first, $status, $body, $staffId) {
        $from = array('email' => 'helpdesk@bodwell.edu', 'name' => 'BHS IT Help Desk');
        $studentinfo = $this->getStudentEmailbyId($studentId);

        $staffinfo = $this->getStaffEmailbyId($staffId);
        $staffemail = $staffinfo[0]['Email3'];
        $sfirstName = $staffinfo[0]['FirstName'];
        $slastName = $staffinfo[0]['LastName'];
        $sFullName = $sfirstName.' '.$slastName;
        $email = $studentinfo[0]['SchoolEmail'];
        // $email = 'mike.doe@student.bodwell.edu';

        $FullName = $studentinfo[0]['FullName'];
        $EnglishName = $studentinfo[0]['EnglishName'];
        if($status == '80') {
          $subject = 'Career Life Pathway - Approved';
        } elseif ($status == '60') {
          $subject = 'Career Life Pathway - Pending Approval';
        } elseif ($status == '70') {
          $subject = 'Career Life Pathway - In Progress';
        } else {
          $subject = 'Career Life Pathway - Rejected';
        }
        // $cc = array(
        //   array('email' => 'soraya.rajan@bodwell.edu', 'name' => 'Soraya Rajan'),
        //   array('email' => 'daniella.gentile@bodwell.edu', 'name' => 'Daniella Gentile')
        // );
        $cc = array();
        // $cc = array(
        //   array('email' => $staffemail, 'name' => $sFullName),
        //   array('email' => 'daniella.gentile@bodwell.edu', 'name' => 'Daniella Gentile')
        // );

        $to = array(
            array('email' => $email, 'name' => "{$FullName}")
        );

        $res = sendEmail($from, $to, $cc, $subject, $body);
    }

}
?>
