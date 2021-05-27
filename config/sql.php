<?php
$_SQL = array(
    'term-list' => "SELECT SemesterID,SemesterName
          ,CONVERT(char(10), StartDate, 126) as StartDate
          ,CONVERT(char(10), EndDate, 126) as EndDate
          ,CONVERT(char(10), MidCutOffDate, 126) as MidCutOffDate
          ,CurrentSemester
          ,FExam1
          ,FExam2
          ,CONVERT(char(10), NextStartDate, 126) as NextStartDate
    FROM tblBHSSemester
    WHERE SemesterID BETWEEN 70 AND (SELECT SemesterID FROM tblBHSSemester WHERE CurrentSemester = 'Y')
    ORDER BY SemesterID DESC",
      'total-number-activities' => "SELECT COUNT(t.ActivityID) AS NumberOfActivity, t.ActivityCategory, c.Title
      FROM tblBHSSPActivity AS t
      LEFT JOIN tblBHSSPActivityConfig as c ON  t.ActivityCategory = c.ActivityCategory
      WHERE t.SemesterID = ?
      GROUP BY t.ActivityCategory, c.Title
      ORDER BY ActivityCategory ASC",
      'my-number-activities' => "SELECT  c.Title, t.ActivityCategory, COUNT(t.ActivityID) AS NumberOfActivity
      FROM tblBHSSPActivity AS t
      LEFT JOIN tblBHSSPActivityConfig as c ON  t.ActivityCategory = c.ActivityCategory
      WHERE t.SemesterID = ? AND StaffID = ?
      GROUP BY t.ActivityCategory, c.Title
      ORDER BY ActivityCategory ASC",
      'my-number-selfsubmit-activities' => "SELECT
      A.ActivityCategory,
      C.Title,
      SUM(CASE WHEN ActivityStatus!='' THEN 1 ELSE 0 END) AS TOTAL,
      SUM(CASE WHEN ActivityStatus='60' THEN 1 ELSE 0 END) AS PENDING,
      SUM(CASE WHEN ActivityStatus='80' THEN 1 ELSE 0 END) AS APPROVE,
      SUM(CASE WHEN ActivityStatus='90' THEN 1 ELSE 0 END) AS REJECT
       FROM tblBHSSPStudentActivities AS A
       LEFT JOIN tblBHSSPActivityConfig AS C ON C.ActivityCategory = A.ActivityCategory
      WHERE A.ProgramSource = 'SELF' AND A.ApproverStaffID = ? AND A.SDate BETWEEN ? AND ?
      GROUP BY A.ActivityCategory, C.Title",
      'get-staff-info' => "SELECT * FROM tblStaff WHERE StaffID = ?",
      'total-enrollments' => "SELECT
            studentActivity.StudentActivityID studentActivityId,
            studentActivity.ActivityStatus activityStatus,
            studentActivity.StudentID studentId,
            studentActivity.Title titleAlt,
            studentActivity.Body descriptionAlt,
            studentActivity.Location actualLocation,
            CONVERT(char(10), studentActivity.SDate, 126) as actualStartDate,
            -- studentActivity.SDate actualStartDate,
            studentActivity.EDate actualEndDate,
            studentActivity.Hours actualHours,
            studentActivity.AllDay actualAllDay,
            studentActivity.DPA actualDpa,
            studentActivity.VLWE actualWorkExp,
            studentActivity.ApproverStaffID approverId,
            studentActivity.SelfSubmitWitness witness,
            category.ActivityCategory category,
            category.Title categoryTitle,
            category.Body categoryDescription,
            activity.SemesterID termId,
            activity.ActivityID activityId,
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
            activity.MaxEnrolment maxEnroll,
                student.FirstName firstName,
                student.LastName lastName,
                student.EnglishName englishName,
                student.SchoolEmail schoolEmail
              FROM tblBHSSPStudentActivities studentActivity
                LEFT JOIN tblBHSSPActivity activity ON activity.ActivityID = studentActivity.ActivityID
                LEFT JOIN tblBHSSPActivityConfig category ON studentActivity.ActivityCategory = category.ActivityCategory
                LEFT JOIN tblBHSStudent student ON studentActivity.StudentID = student.StudentID
                LEFT JOIN tblStaff staff ON activity.StaffID = staff.StaffID
                LEFT JOIN tblStaff staff2 ON activity.StaffID2 = staff2.StaffID
              WHERE studentActivity.SemesterID=?
              ORDER BY
                actualStartDate ASC,
                studentActivity.Title ASC,
                student.LastName ASC,
                student.FirstName ASC,
                student.EnglishName ASC",
      'school-activity-list-by-staffId' => "SELECT
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
                    WHERE activity.StartDate BETWEEN ? AND ? AND activity.StaffID = ? AND activity.SemesterID=?
                    ORDER BY
                      activity.StartDate ASC,
                      activity.Title ASC",

        'school-activity-list' => "SELECT
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
                      WHERE activity.StartDate BETWEEN ? AND ? AND activity.StaffID != ? AND activity.SemesterID=?
                      ORDER BY
                        activity.StartDate ASC,
                        activity.Title ASC",

        'Self-Submit-Hour-By-StaffId' => "SELECT p.StudentActivityID, p.StudentID, t.FirstName, t.LastName,
         t.EnglishName, p.Title,p.ApproverComment1,
         t.SchoolEmail,
         p.SELFComment1,p.SELFComment2,
         p.SELFComment3, p.VLWE, p.Body,
         p.Location, p.ActivityCategory,
         p.SelfSubmitWitness,
         p.SDate,
         p.EDate,
         p.Hours, p.ApproverStaffID, p.ActivityStatus,
         CONCAT(s.FirstName, ' ', s.LastName) AS StaffFullName,
         m.SemesterName, p.SemesterID,
         CONVERT(varchar, p.ModifyDate, 120) ModifyDate, p.ModifyUserID, CONVERT(varchar, p.CreateDate, 120) CreateDate, p.CreateUserID, p.ProgramSource
        FROM tblBHSSPStudentActivities p
        LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
        LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
        LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
         WHERE p.ProgramSource = 'SELF' AND p.SDate BETWEEN ? AND ? AND p.ApproverStaffID = ?
         ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc ",

        'Self-Submit-Hour' => "SELECT p.StudentActivityID, p.StudentID, t.FirstName, t.LastName,
         t.EnglishName, p.Title,p.ApproverComment1,
         t.SchoolEmail,
         p.SELFComment1,p.SELFComment2,
         p.SELFComment3, p.VLWE, p.Body,
         p.Location, p.ActivityCategory,
         p.SelfSubmitWitness,
         p.SDate,
         p.EDate,
         p.Hours, p.ApproverStaffID, p.ActivityStatus,
         CONCAT(s.FirstName, ' ', s.LastName) AS StaffFullName,
         m.SemesterName, p.SemesterID,
         CONVERT(varchar, p.ModifyDate, 120) ModifyDate, p.ModifyUserID, CONVERT(varchar, p.CreateDate, 120) CreateDate, p.CreateUserID, p.ProgramSource
        FROM tblBHSSPStudentActivities p
        LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
        LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
        LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
         WHERE p.ProgramSource = 'SELF' AND p.SDate BETWEEN ? AND ? AND p.ApproverStaffID != ?
         ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc ",

         'Self-Submit-Hour-rolebogs' => "SELECT p.StudentActivityID, p.StudentID, t.FirstName, t.LastName,
          t.EnglishName, p.Title,p.ApproverComment1,
          t.SchoolEmail,
          p.SELFComment1,p.SELFComment2,
          p.SELFComment3, p.VLWE, p.Body,
          p.Location, p.ActivityCategory,
          p.SelfSubmitWitness,
          p.SDate,
          p.EDate,
          p.Hours, p.ApproverStaffID, p.ActivityStatus,
          CONCAT(s.FirstName, ' ', s.LastName) AS StaffFullName,
          m.SemesterName, p.SemesterID,
          CONVERT(varchar, p.ModifyDate, 120) ModifyDate, p.ModifyUserID, CONVERT(varchar, p.CreateDate, 120) CreateDate, p.CreateUserID, p.ProgramSource
         FROM tblBHSSPStudentActivities p
         LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
         LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
         LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
          WHERE p.ProgramSource = 'SELF' AND p.SDate BETWEEN :from AND :to AND s.RoleBOGS = :rolebogs
          ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc ",

          'Self-Submit-Hour-rolebogs-byStaffId' => "SELECT p.StudentActivityID, p.StudentID, t.FirstName, t.LastName,
          t.EnglishName, p.Title,p.ApproverComment1,
          t.SchoolEmail,
          p.SELFComment1,p.SELFComment2,
          p.SELFComment3, p.VLWE, p.Body,
          p.Location, p.ActivityCategory,
          p.SelfSubmitWitness,
          p.SDate,
          p.EDate,
          p.Hours, p.ApproverStaffID, p.ActivityStatus,
          CONCAT(s.FirstName, ' ', s.LastName) AS StaffFullName,
          m.SemesterName, p.SemesterID,
          CONVERT(varchar, p.ModifyDate, 120) ModifyDate, p.ModifyUserID, CONVERT(varchar, p.CreateDate, 120) CreateDate, p.CreateUserID, p.ProgramSource
          FROM tblBHSSPStudentActivities p
          LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
          LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
          LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
          WHERE p.ProgramSource = 'SELF' AND p.SDate BETWEEN :from AND :to AND p.ApproverStaffID = :staffid AND s.RoleBOGS = :rolebogs
          ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc ",


        'Update-selfsubmit-status' => "UPDATE tblBHSSPStudentActivities SET ActivityStatus = {activityStatus}, ModifyDate = '{ModifyDate}', ModifyUserID = '{ModifyUserID}'
          WHERE StudentActivityID IN ({activityIdList})",

        'search-student' => "SELECT StudentID,
        -- CONCAT(FirstName, ' ' , LastName) AS FullName,
        FirstName,
        LastName,
        EnglishName
        FROM tblBHSStudent
        WHERE (replace(LastName,' ','')  LIKE ? OR replace(FirstName,' ','')
        LIKE ? OR EnglishName LIKE ? OR replace(StudentID,' ','')  LIKE ?)
    	  AND CurrentStudent = 'Y' AND SchoolID = 'BHS' AND StudentID >= 201500001
  	    ORDER BY CurrentStudent DESC, FirstName ASC",

        'search-student-report' => "SELECT StudentID,
        FirstName,
        LastName,
        EnglishName,
        CurrentStudent,
    		CASE
    			WHEN CurrentStudent = 'Y' THEN 'Current'
    			WHEN CurrentStudent = 'N' THEN 'Not Current'
    			ELSE 'Error'
  	    END as 'CurrentStatus'
        FROM tblBHSStudent
        WHERE (replace(LastName,' ','')  LIKE ? OR replace(FirstName,' ','')
        LIKE ? OR EnglishName LIKE ? OR replace(StudentID,' ','')  LIKE ?)
    	  AND CurrentStudent IN ('Y','N') AND SchoolID = 'BHS' AND StudentID >= 201500001
  	    ORDER BY CurrentStudent DESC, FirstName ASC",

        'insert-activity-record' => "INSERT INTO tblBHSSPStudentActivities
                (SemesterID, ActivityStatus,StudentID,ActivityID,ProgramSource,ActivityCategory, Title, Location, SDate,EDate,Hours,AllDay,DPA,VLWE,ApproverStaffID,CreateUserID,ModifyUserID, SELFComment1, SELFComment2, SELFComment3)
                VALUES
                  (:SemesterId, :ActivityStatus, :studentid, :ActivityID, :ProgramSource, :ActivityCategory, :Title, :Location, :SDate, :EDate, :Hours, :AllDay, :DPA, :VLWE, :ApproverStaffID, :CreateUserID, :ModifyUserID, :SELFComment1, :SELFComment2, :SELFComment3)
                ",

        'approval-list' => "SELECT StaffID, CONCAT(FirstName, ' ' ,LastName) AS FullName, PositionTitle2, Sex
        FROM tblStaff
        WHERE RoleBOGS IN ('10','20','21','30','31','32','40','50') AND (CurrentStaff = 'Y' OR LeftDate >= DATEADD(month,-3,GETDATE())) ORDER BY FirstName ASC",

        'approval-list-rolebogs' => "SELECT StaffID, CONCAT(FirstName, ' ' ,LastName) AS FullName, PositionTitle2, Sex
        FROM tblStaff
        WHERE RoleBOGS IN ('50') AND CurrentStaff = 'Y' ORDER BY FirstName ASC",

        'activity-enroll-member' => "SELECT
        studentActivity.StudentActivityID studentActivityId,
        studentActivity.ActivityStatus activityStatus,
        studentActivity.StudentID studentId,
        activity.ActivityID activityId,
  			student.FirstName,
  			student.LastName,
  			student.EnglishName
        FROM tblBHSSPStudentActivities studentActivity
          LEFT JOIN tblBHSSPActivity activity ON activity.ActivityID = studentActivity.ActivityID
          LEFT JOIN tblBHSStudent student ON studentActivity.StudentID = student.StudentID
        WHERE studentActivity.SemesterID=? and studentActivity.ActivityID = ?
        ORDER BY
          studentActivity.ActivityStatus ASC,
          student.LastName ASC,
          student.FirstName ASC,
          student.EnglishName ASC",




      'update-activity-detail' => "UPDATE tblBHSSPActivity SET Title = :Title, StaffID = :StaffID, StaffID2 = :StaffID2, Body = :Body, ActivityCategory = :ActivityCategory, ActivityType = :ActivityType, VLWE = :VLWE, Location = :Location,
      MeetingPlace = :MeetingPlace, StartDate = :StartDate, EndDate = :EndDate, BaseHours = :BaseHours, MaxEnrolment = :MaxEnrolment, ModifyUserID = :ModifyUserID, ModifyDate = :ModifyDate
      WHERE ActivityID = :ActivityID",

      'Update-activity-student-status' => "UPDATE tblBHSSPStudentActivities SET ActivityStatus = {activityStatus}
        WHERE StudentActivityID IN ({activityIdList})",

      'insert-activity-record-byStaff' => "INSERT INTO tblBHSSPStudentActivities
            (SemesterID, ActivityStatus,StudentID,ActivityID,ProgramSource,ActivityCategory, Title, Body,
				Location, SDate,EDate,Hours,AllDay,DPA,VLWE,ApproverStaffID,CreateUserID,
				ModifyUserID)
                        SELECT S.SemesterID, {ActivityStatus}, {StudentID}, S.ActivityID, C.Title, S.ActivityCategory, S.Title, S.Body, S.Location, S.StartDate, S.EndDate, S.BaseHours, S.AllDay, S.DPA, S.VLWE, '{ApproverStaffID}' ,'{CreateUserID}' ,'{ModifyUserID}'
        FROM tblBHSSPActivity S
        LEFT JOIN tblBHSSPActivityConfig C ON S.ActivityCategory = C.ActivityCategory
        WHERE S.ActivityID = {ActivityID}",
      'update-student-activity-detail' => "UPDATE tblBHSSPStudentActivities
      SET Title = :Title, Body = :Body, ActivityCategory = :ActivityCategory, ProgramSource = 'BORD', ApproverStaffID = :ApproverStaffID, VLWE = :VLWE, Location = :Location, SDate = :SDate, EDate = :EDate, Hours = :Hours
      WHERE ActivityID = :ActivityID",

      'delete-activity' => "DELETE FROM tblBHSSPActivity WHERE ActivityID = ?",

      'delete-student-activity' => "DELETE FROM tblBHSSPStudentActivities WHERE ActivityID = ?",

      'insert-school-activity' => "INSERT INTO tblBHSSPActivity (Title, Body, ActivityCategory, ActivityType, MaxEnrolment, SemesterID, StaffID, StaffID2, Location, MeetingPlace, BaseHours, StartDate, EndDate, VLWE, ModifyUserID, CreateUserID, AllDay, DPA)
      VALUES(:Title, :Body, :ActivityCategory, :ActivityType, :MaxEnrolment, :SemesterID, :StaffID, :StaffID2, :Location, :MeetingPlace, :BaseHours, :StartDate, :EndDate, :VLWE, :ModifyUserID, :CreateUserID, :AllDay, :DPA)",
      'update-student-school-activity' => "UPDATE tblBHSSPStudentActivities
      SET Title = :Title, ActivityCategory = :ActivityCategory, VLWE = :VLWE, ActivityStatus = :ActivityStatus, Location = :Location, SDate = :SDate, EDate = :EDate, Hours = :Hours, ApproverStaffID = :ApproverStaffID, ApproverComment1 = :ApproverComment1, SELFComment1 = :SELFComment1, SELFComment2 = :SELFComment2, SELFComment3 = :SELFComment3, ModifyUserID = :ModifyUserID, ModifyDate = :ModifyDate
      WHERE StudentActivityID = :StudentActivityID AND StudentID = :StudentID",

      'get-staff-FullName' => "SELECT CONCAT(FirstName, ' ', LastName) FullName FROM tblStaff WHERE StaffID = ?",

      'get-student-FullName' => "SELECT CONCAT(FirstName, ' ' , LastName) AS FullName, SchoolEmail, EnglishName FROM tblBHSStudent WHERE StudentID = ?",

      'get-vlwe-hour' => "SELECT p.StudentActivityID, p.StudentID, t.FirstName, t.LastName, t.EnglishName, p.Title,p.Comment, p.VLWE, p.Body, p.Location, p.ActivityCategory, p.SDate, p.Hours, p.ApproverStaffID, p.ActivityStatus, CONCAT(s.FirstName, ' ', s.LastName) AS StaffFullName, p.VLWESupervisor, m.SemesterName, p.ModifyDate, p.ModifyUserID, p.CreateDate, p.CreateUserID
         FROM tblBHSSPStudentActivities p
         LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
         LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
         LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
          WHERE p.SDate BETWEEN ? AND ? AND p.ProgramSource = 'VLWE' AND p.ApproverStaffID = ? AND p.SemesterID = ? AND p.VLWE = 1
          ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc ",

      'insert-vlwe-record' => "INSERT INTO tblBHSSPStudentActivities
      (SemesterID, ActivityStatus,StudentID,ActivityID,ProgramSource,ActivityCategory, Title, Body, Location, SDate,EDate,Hours,AllDay,DPA,VLWE,ApproverStaffID,CreateUserID,ModifyUserID, VLWESupervisor, Comment)
      VALUES
        (:SemesterId,:ActivityStatus, :studentid, :ActivityID, :ProgramSource, :ActivityCategory, :Title, :Body, :Location, :SDate, :EDate, :Hours, :AllDay, :DPA, :VLWE, :ApproverStaffID, :CreateUserID, :ModifyUserID, :supervisor, :Comment)
      ",

      'update-student-vlwe' => "UPDATE tblBHSSPStudentActivities
      SET Title = :Title, Body = :Description, ActivityCategory = :Category, VLWE = :VLWE, Location = :Location, SDate = :SDate, EDate = :EDate, Hours = :Hours, VLWESupervisor = :VLWESupervisor, ApproverStaffID = :ApproverStaffID, Comment = :Comment, ModifyUserID = :ModifyUserID, ModifyDate = :ModifyDate
      WHERE StudentActivityID = :StudentActivityID AND StudentID = :StudentID",

      'get-activity-enroll-member' => "SELECT COUNT(StudentActivityID) as num,
      ActivityStatus
      FROM tblBHSSPStudentActivities
      WHERE ActivityID = ?
      GROUP BY ActivityStatus",

      'update-activity-enroll-member' => "UPDATE tblBHSSPActivity SET CurrentEnrolment = ?, PendingEnrolment = ?
        WHERE ActivityID = ?",

      'my-student-list-by-boarding'  => "SELECT
      A.FirstName
      ,A.EnglishName
      ,A.LastName
      ,LOWER(A.Origin) flag
      ,B.CName as 'Origin'
      ,CASE
			WHEN C.Residence = 'Y' AND C.Homestay = 'N' THEN 'Boarding'
			WHEN C.Residence = 'Y' AND C.Homestay = 'Y' THEN 'Boarding/Homestay'
			WHEN C.Residence = 'N' AND C.Homestay = 'Y' THEN 'Homestay'
			WHEN C.Residence = 'N' AND C.Homestay = 'N' THEN 'Day Program'
			ELSE 'Error'
	    END as 'Boarding'
      ,C.RoomNo as 'RoomNo'
      ,C.Halls as 'Hall'
      ,A.Houses as 'House'
      ,C.Hadvisor as 'HallAdvisor'
      ,C.Hadvisor2 as 'HallAdvisor2'
      ,C.Tutor
      ,C.Troom as 'TutorRoom'
      ,C.FOBID as 'FOBID'
      ,A.StudentID
      ,CONVERT(char(10), A.EnrolmentDate, 126) 'EnrolledSince'
      ,A.Counselor as 'Counsellor'
      ,A.Mentor as 'MentorTeacher'
      FROM
          tblBHSStudent as A
          left join tblCountry as B ON A.Origin=B.CID
      left join tblBHSHomestay as C ON A.StudentID=C.StudentID
      WHERE
      A.CurrentStudent = 'Y'
      and (C.Hadvisor = ? OR C.Hadvisor2 = ?)
      ORDER BY
      A.FirstName asc, A.LastName asc",

      'current-student-list'  => "SELECT
      A.FirstName
      ,A.EnglishName
      ,A.LastName
	  ,LOWER(A.Origin) flag
	  ,A.SchoolEmail
      ,B.CName as 'Origin'
	  ,COUNT(DISTINCT J.SemesterID) numTerms
      ,CASE
			WHEN C.Residence = 'Y' AND C.Homestay = 'N' THEN 'Boarding'
			WHEN C.Residence = 'Y' AND C.Homestay = 'Y' THEN 'Boarding/Homestay'
			WHEN C.Residence = 'N' AND C.Homestay = 'Y' THEN 'Homestay'
			WHEN C.Residence = 'N' AND C.Homestay = 'N' THEN 'Day Program'
			ELSE 'Error'
	    END as 'Boarding'
      ,C.RoomNo as 'RoomNo'
      ,C.Halls as 'Hall'
      ,A.Houses as 'House'
      ,C.Hadvisor as 'HallAdvisor'
      ,C.Hadvisor2 as 'HallAdvisor2'
      ,A.StudentID
	  ,A.DOB
	  ,A.Sex
	  ,A.CurrentGrade
      ,CONVERT(char(10), A.EnrolmentDate, 126) 'EnrolledSince'
	  ,(SELECT TOP 1 M.SemesterName FROM tblBHSSemester AS M WHERE A.EnrolmentDate BETWEEN M.StartDate AND M.EndDate) AS EnrolledIn
      ,A.Counselor as 'Counsellor'
      ,A.Mentor as 'MentorTeacher'
      FROM
          tblBHSStudent as A
	    LEFT JOIN tblCountry as B ON A.Origin=B.CID
		LEFT JOIN tblBHSHomestay as C ON A.StudentID=C.StudentID
		LEFT JOIN tblBHSStudentSubject S ON A.StudentID = S.StudNum
		LEFT JOIN tblBHSSubject J ON S.SubjectID = J.SubjectID
      WHERE
      A.CurrentStudent = 'Y' AND J.SemesterID <= '{semesterId}'
	  GROUP BY
	  A.FirstName
	  ,A.SchoolEmail
	  ,C.Residence
	  ,C.Homestay
      ,A.EnglishName
      ,A.LastName
	  ,A.Origin
      ,B.CName
	  ,C.RoomNo
	   ,C.Halls
	   ,A.Houses
	   ,C.Hadvisor
	   ,C.Hadvisor2
	   ,A.StudentID
	   ,A.DOB
	  ,A.Sex
	  ,A.CurrentGrade
	  ,A.EnrolmentDate
	  ,A.Counselor
	  ,A.Mentor
      ORDER BY
      A.FirstName asc, A.LastName asc",

      'get-user-auth-student' => "SELECT LoginID, UserID, LoginIDParent, PW1, PW2, PW3 FROM tblBHSUserAuth WHERE UserID = ?",
      'find-semesterid-date' => "SELECT TOP 1 SemesterID, SemesterName,StartDate, NextStartDate
      FROM tblBHSSemester
      WHERE ? >= StartDate AND ? < NextStartDate",

      'get-vlwe-report' => "SELECT
      CONVERT(char(10), p.SDate, 126) SDate,
      p.Title, p.ProgramSource,
      p.ActivityCategory,
      p.VLWE,
      p.Hours,
      p.CreateUserID,
      CASE
      WHEN
        ISNUMERIC(LEFT(p.CreateUserID,1)) = 0
      THEN
        CONCAT(s.FirstName, ' ', s.LastName)
      ELSE
        CONCAT(t.FirstName, ' ', t.LastName)
      END AS CreateUserName,
      p.ApproverStaffID,
      CONCAT(s.FirstName, ' ', s.LastName) ApproverStaffName,
      p.VLWESupervisor,
      p.ActivityStatus,
      p.SemesterID
         FROM tblBHSSPStudentActivities p
         LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
         LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
         LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
          WHERE p.StudentID = ? AND p.VLWE = 1
          ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc",

      'get-selfsubmit-by-student' => "SELECT
      p.StudentActivityID,
      p.StudentID,
      t.FirstName,
      t.LastName,
      t.EnglishName,
      p.ApproverComment1,
      p.SELFComment1,
      p.SELFComment2,
      p.SELFComment3,
      t.SchoolEmail,
      p.Body,
      p.Location,
      p.SelfSubmitWitness,
      CONVERT(char(10), p.SDate, 126) SDate,
      CONVERT(char(10), p.EDate, 126) EDate,
      p.Title, p.ProgramSource,
      p.ActivityCategory,
      p.VLWE,
      p.Hours,
      p.CreateUserID,
      CASE
      WHEN
        ISNUMERIC(LEFT(p.CreateUserID,1)) = 0
      THEN
        CONCAT(s.FirstName, ' ', s.LastName)
      ELSE
        CONCAT(t.FirstName, ' ', t.LastName)
      END AS CreateUserName,
      p.ApproverStaffID,
      CONCAT(s.FirstName, ' ', s.LastName) ApproverStaffName,
      p.VLWESupervisor,
      p.ActivityStatus,
      p.SemesterID,
      m.SemesterName,
      CONVERT(varchar, p.ModifyDate, 120) ModifyDate,
      p.ModifyUserID,
      CONVERT(varchar, p.CreateDate, 120) CreateDate,
      p.CreateUserID
         FROM tblBHSSPStudentActivities p
         LEFT JOIN tblBHSStudent t on t.StudentID = p.StudentID
         LEFT JOIN tblStaff s on p.ApproverStaffID = s.StaffID
         LEFT JOIN tblBHSSemester m on p.SemesterID = m.SemesterID
          WHERE p.StudentID = ?
          ORDER BY p.StudentActivityID ASC, p.ActivityStatus desc",

      'career-life-staff-list' => "SELECT DISTINCT TeacherID, CONCAT(B.FirstName,' ',B.LastName) AS FullName FROM
            tblBHSSubject as A
        left join tblStaff as B ON A.TeacherID = B.StaffID
        WHERE
        A.SemesterID = ?
        AND CourseCd IN ('CLE','CLC')
	      ORDER BY FullName ASC",

      'career-life-record-list-by-staffId' => "SELECT P.*,
                                                      CONVERT(char(10), P.ApprovalDate, 126) ApprovalDate,
                                                      CONVERT(char(10), P.CreateDate, 126) CreateDateV,
                                                      S.FirstName,
                                                      S.LastName,
                                                      B.FirstName SFirstName,
                                                      B.EnglishName SEnglishName,
                                                      B.LastName SLastName,
                                                      B.SchoolEmail,
                                                      P.ApprovalStatus,
                                                      CASE
                                                        WHEN
                                                          ISNUMERIC(LEFT(P.CreateUserID,1)) = 0
                                                        THEN
                                                          CONCAT(S.FirstName, ' ', S.LastName)
                                                        ELSE
                                                          CONCAT(B.FirstName, ' ', B.LastName)
                                                        END AS CreateUserName,
                                                        CASE
                                                          WHEN
                                                            ISNUMERIC(LEFT(P.ModifyUserID,1)) = 0
                                                          THEN
                                                            CONCAT(S.FirstName, ' ', S.LastName)
                                                          ELSE
                                                            CONCAT(B.FirstName, ' ', B.LastName)
                                                          END AS ModifyUserName
                                                 FROM tblBHSStudentCareerLifePathway P
                                                LEFT JOIN tblStaff S ON P.TeacherID = S.StaffID
                                                LEFT JOIN tblBHSStudent B ON P.StudentID = B.StudentID
                                                WHERE P.TeacherID = ?",

      'career-life-record-list' => "SELECT P.*, CONVERT(char(10), ApprovalDate, 126) ApprovalDate,
                                           CONVERT(char(10), P.CreateDate, 126) CreateDateV,
                                           S.FirstName,
                                           S.LastName,
                                           B.FirstName SFirstName,
                                           B.EnglishName SEnglishName,
                                           B.LastName SLastName,
                                           B.SchoolEmail,
                                           P.ApprovalStatus,
                                           CASE
                                            WHEN
                                              ISNUMERIC(LEFT(P.CreateUserID,1)) = 0
                                            THEN
                                              CONCAT(S.FirstName, ' ', S.LastName)
                                            ELSE
                                              CONCAT(B.FirstName, ' ', B.LastName)
                                            END AS CreateUserName,
                                          CASE
                                            WHEN
                                              ISNUMERIC(LEFT(P.ModifyUserID,1)) = 0
                                            THEN
                                              CONCAT(S.FirstName, ' ', S.LastName)
                                            ELSE
                                              CONCAT(B.FirstName, ' ', B.LastName)
                                            END AS ModifyUserName
                                      FROM tblBHSStudentCareerLifePathway P
                                 LEFT JOIN tblStaff S ON P.TeacherID = S.StaffID
                                 LEFT JOIN tblBHSStudent B ON P.StudentID = B.StudentID",

      'get-list-career-subject' => "SELECT SubjectID, SubjectName, PName, TeacherID, CONCAT(B.FirstName,' ',B.LastName) AS FullName, Credit, RoomNo FROM
      tblBHSSubject as A
      left join tblStaff as B ON A.TeacherID = B.StaffID
      WHERE
      A.SemesterID = ?
      AND CourseCd IN ('CLE','CLC')",

      'Update-career-status' => "UPDATE tblBHSStudentCareerLifePathway
                                        SET ApprovalStatus = {ApprovalStatus}, ApprovalDate = '{ApprovalDate}', ModifyDate = '{ModifyDate}', ModifyUserID = '{ModifyUserID}'
                                      WHERE ProjectID IN ({ProjectIdList})",

      'update-career-life' => "UPDATE tblBHSStudentCareerLifePathway
                                  SET SubjectID = :SubjectID, SubjectName = :SubjectName, TeacherID = :TeacherID, ProjectTopic= :ProjectTopic,
                                   MentorFName = :MentorFName, MentorLName = :MentorLName, MentorEmail = :MentorEmail, MentorPhone = :MentorPhone,
                                    MentorDesc = :MentorDesc, ProjectDesc = :ProjectDesc, ModifyUserID = :ModifyUserID, ModifyDate = :ModifyDate,
                                     ApprovalStatus = :ApprovalStatus, TeacherComment = :TeacherComment, ProjectCategory = :ProjectCategory
                                WHERE ProjectID = :ProjectID",

      'get-staff-email-by-id' => "SELECT StaffID
                                        ,FirstName
                                        ,LastName
                                        ,Email3
                                      FROM tblStaff
                                      WHERE CurrentStaff = 'Y' AND StaffID = ?",

      'get-subject-info' => "SELECT
                                    course.SemesterID termId,
                                    studentCourse.StudSubjID studentCourseId,
                                    studentCourse.StudNum studentId,
                                    studentCourse.SubjectID courseId,
                                    course.SubjectName courseName,
                                    course.TeacherID,
                                    course.CourseCd,
                                    staff.FirstName staffFName,
                                    staff.LastName staffLName
                              FROM tblBHSStudentSubject studentCourse
                              JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
                              JOIN tblStaff staff ON course.TeacherID = staff.StaffID
                              WHERE course.SemesterID=? AND studentCourse.StudNum=? AND studentCourse.SubjectID = ?",

      'insert-career-record' => "INSERT INTO tblBHSStudentCareerLifePathway
                                            (StudSubjID,StudentID,SubjectID,SubjectName,TeacherID,CourseCd,SemesterID,ProjectTopic,MentorFName,MentorLName,MentorDesc,MentorEmail,MentorPhone,ProjectDesc,ProjectCategory,StudentComment,TeacherComment,ApprovalStatus,ApprovalDate,ModifyUserID,CreateUserID)
                                      VALUES
                                            (:StudSubjID,:StudentID,:SubjectID,:SubjectName,:TeacherID,:CourseCd,:SemesterID,:ProjectTopic,:MentorFName,:MentorLName,:MentorDesc,:MentorEmail,:MentorPhone,:ProjectDesc,:ProjectCategory,:StudentComment,:TeacherComment,:ApprovalStatus,:ApprovalDate,:ModifyUserID,:CreateUserID)",

      'search-student-career' => "SELECT t.StudentID,
      t.FirstName,
      t.LastName,
      t.EnglishName,
      t.CurrentStudent,
      ISNULL(s.courseId,'') courseId,
      ISNULL(s.courseName,'') courseName
        FROM tblBHSStudent as t
  	  LEFT JOIN
  	  (
  		SELECT
  			studentCourse.StudNum,
  			studentCourse.SubjectID courseId,
  			course.SubjectName courseName
  		FROM tblBHSStudentSubject studentCourse
  			JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
  		WHERE course.SemesterID = '{semesterID}' AND course.CourseCd IN ('CLE','CLC')
  	  ) s ON t.StudentID = s.StudNum
        WHERE (replace(t.LastName,' ','')  LIKE '{param}' OR replace(t.FirstName,' ','')
        LIKE '{param}' OR t.EnglishName LIKE '{param}' OR replace(t.StudentID,' ','')  LIKE '{param}')
        AND t.CurrentStudent = 'Y'
        ORDER BY t.FirstName ASC",


      'course-list' => "SELECT
          course.SemesterID termId,
          studentCourse.StudSubjID studentCourseId,
          studentCourse.StudNum studentId,
          studentCourse.SubjectID courseId,
          course.SubjectName courseName,
          staff.StaffID teacherId,
          CONCAT(staff.FirstName, ' ', staff.LastName) teacherName,
          staff.FirstName teacherFirstName,
          staff.LastName teacherLastName,
          course.PName provincialName,
          course.CourseCd courseCode,
          course.RoomNo roomNo,
          course.Cap cap,
          course.Spa spa,
          course.Credit credit,
          course.Type courseType,
          course.CourseCd,
		  count(case when W.Status = 3 then 1 end) as comp_count,
		  count(case when W.Status = 2 then 1 end) as part_count,
		  count(case when W.Status = 1 then 1 end) as incomp_count
      FROM tblBHSStudentSubject studentCourse
      JOIN tblBHSSubject course ON studentCourse.SubjectID = course.SubjectID
      JOIN tblStaff staff ON course.TeacherID = staff.StaffID
	  LEFT JOIN tblBHSOGSWeeklyAssignment W ON W.SubjectID = studentCourse.SubjectID AND studentCourse.StudNum = W.StudentID
      WHERE course.SemesterID=? AND studentCourse.StudNum=? AND course.SubjectName NOT LIKE 'YYY%'
	  GROUP BY
	  course.SemesterID,
          studentCourse.StudSubjID,
          studentCourse.StudNum,
          studentCourse.SubjectID,
          course.SubjectName,
          staff.StaffID,
          CONCAT(staff.FirstName, ' ', staff.LastName),
          staff.FirstName,
          staff.LastName,
          course.PName,
          course.CourseCd,
          course.RoomNo,
          course.Cap,
          course.Spa,
          course.Credit,
          course.Type,
          course.CourseCd
      ORDER BY
          course.Credit DESC,
          course.SubjectName ASC",

      'absent-list-by-courselist'  => "SELECT StudSubjID studentCourseId, SUM(AbsencePeriod) absenceCount, SUM(LatePeriod) lateCount
      FROM tblBHSAttendance
      WHERE StudSubjID IN ({studentCourseList}) AND Excuse = '0'
      GROUP BY StudSubjID",

      'student-info' => "SELECT
    COUNT(DISTINCT c.SemesterID) numTerms,
    COUNT(DISTINCT (Case when c.SubjectName LIKE 'AEP%' then c.SemesterID end)) numOfAepTerm,
	  student.StudentID studentId,
    student.PEN pen,
    student.FirstName firstName,
    student.LastName lastName,
    student.EnglishName englishName,
    student.SchoolEmail schoolEmail,
    student.CurrentGrade currentGrade,
	  student.Counselor counsellor,
    student.Mentor mentor,
    student.Houses houses,
    homestay.Homestay homestay,
    homestay.Residence residence,
    homestay.Halls halls,
    homestay.RoomNo roomNo,
    homestay.Hadvisor youthAdvisor,
    homestay.Hadvisor2 youthAdvisor2,
    homestay.Tutor tutor,
    student.EnrolmentDate EnrollmentDate
	  FROM tblBHSStudent student
    LEFT JOIN tblBHSHomestay homestay ON student.StudentID = homestay.StudentID
	  LEFT JOIN tblBHSStudentSubject b ON student.StudentID = b.StudNum
    LEFT JOIN tblBHSSubject c ON b.SubjectID = c.SubjectID
    LEFT JOIN tblBHSSemester d ON c.SemesterID = d.SemesterID
    WHERE student.StudentID=? AND student.CurrentStudent='Y' AND d.SemesterID<=?
	GROUP BY
	student.StudentID,
	student.PEN,
  student.FirstName,
  student.LastName,
  student.EnglishName,
  student.SchoolEmail,
  student.CurrentGrade,
	student.Counselor,
  student.Mentor,
  student.Houses,
  homestay.Homestay,
  homestay.Residence,
  homestay.Halls,
  homestay.RoomNo,
  homestay.Hadvisor,
  homestay.Hadvisor2,
  homestay.Tutor,
  student.EnrolmentDate",

  'course-grade-list' => "SELECT
    studentId,
    courseId,
    COUNT(categoryId) categoryCount,
    SUM(categoryWeight) categoryWeightTotal,
    SUM(categoryRateScaled * categoryWeight) courseRateOrigin,
    SUM(categoryRateScaled * categoryWeight) * (1 / SUM(categoryWeight)) courseRateScaled
  FROM (
    SELECT
      student.StudentID studentId,
      course.SubjectID courseId,
      category.CategoryID categoryId,
      category.CategoryWeight categoryWeight,
      SUM((grade.ScorePoint / item.MaxValue) * item.ItemWeight) * (1 / SUM(item.ItemWeight)) categoryRateScaled
    FROM tblBHSOGSGrades grade
      JOIN tblBHSOGSCategoryItems item ON grade.CategoryItemID = item.CategoryItemID
      JOIN tblBHSOGSCourseCategory category ON item.CategoryID = category.CategoryID
      JOIN tblBHSSubject course ON category.SubjectID = course.SubjectID
      JOIN tblBHSStudentSubject studentSubject ON grade.StudSubjID = studentSubject.StudSubjID
      JOIN tblBHSStudent student ON studentSubject.StudNum = StudentID
    WHERE student.StudentID='{studentId}' AND grade.SemesterID='{termId}' AND grade.ScorePoint IS NOT NULL AND grade.Exempted <> 1
    GROUP BY student.StudentID, course.SubjectID, category.CategoryID, category.CategoryWeight
  ) categoryGrade
  GROUP BY studentId, courseId",

  'weekly-assignment-list' => "SELECT wa.*, sb.SubjectName, s.FirstName, s.LastName
                               FROM tblBHSOGSWeeklyAssignment wa
                               LEFT JOIN tblBHSSubject sb ON wa.SubjectID = sb.SubjectID
                               LEFT JOIN tblStaff s ON  sb.TeacherID = s.StaffID
                               WHERE wa.AssignDate BETWEEN '{from}' AND '{to}' AND wa.SemesterID = '{term}' AND wa.StudentID = '{studentId}' ",

  'current-student-list-G8-G9' => "SELECT
  count(case when D.Status = 3 then 1 end) as comp_count,
  count(case when D.Status = 2 then 1 end) as part_count,
  count(case when D.Status = 1 then 1 end) as incomp_count,
  A.FirstName
  ,A.EnglishName
  ,A.LastName
,LOWER(A.Origin) flag
,A.SchoolEmail
  ,B.CName as 'Origin'
  ,CASE
  WHEN C.Residence = 'Y' AND C.Homestay = 'N' THEN 'Boarding'
  WHEN C.Residence = 'Y' AND C.Homestay = 'Y' THEN 'Boarding/Homestay'
  WHEN C.Residence = 'N' AND C.Homestay = 'Y' THEN 'Homestay'
  WHEN C.Residence = 'N' AND C.Homestay = 'N' THEN 'Day Program'
  ELSE 'Error'
  END as 'Boarding'
  ,C.RoomNo as 'RoomNo'
  ,C.Halls as 'Hall'
  ,A.Houses as 'House'
  ,C.Hadvisor as 'HallAdvisor'
  ,C.Hadvisor2 as 'HallAdvisor2'
  ,A.StudentID
,A.DOB
,A.Sex
,A.CurrentGrade
  ,A.Counselor as 'Counsellor'
  ,A.Mentor as 'MentorTeacher'

  FROM
      tblBHSStudent as A
LEFT JOIN tblCountry as B ON A.Origin=B.CID
LEFT JOIN tblBHSHomestay as C ON A.StudentID=C.StudentID
LEFT JOIN tblBHSOGSWeeklyAssignment as D ON A.StudentID = D.StudentID AND D.AssignDate BETWEEN '{from}' AND '{to}'
  WHERE
  A.CurrentStudent = 'Y'
  AND A.CurrentGrade IN ('Grade 8', 'Grade 9')
GROUP BY
A.FirstName
,A.SchoolEmail
,C.Residence
,C.Homestay
  ,A.EnglishName
  ,A.LastName
,A.Origin
  ,B.CName
,C.RoomNo
 ,C.Halls
 ,A.Houses
 ,C.Hadvisor
 ,C.Hadvisor2
 ,A.StudentID
 ,A.DOB
,A.Sex
,A.CurrentGrade
,A.EnrolmentDate
,A.Counselor
,A.Mentor
  ORDER BY
  A.FirstName asc, A.LastName asc",

  'get-student-leave-request' => "SELECT L.LeaveID,L.LeaveType, CONCAT(T.FirstName, ' ', CONCAT(T.LastName, ' ', T.EnglishName)) StudentFullName, CONVERT(VARCHAR, L.SDate, 120) SDate, CONVERT(VARCHAR, L.EDate, 120) EDate, CONVERT(VARCHAR, L.CreateDate, 120) CreateDate, CONVERT(VARCHAR, L.ModifyDate, 120) ModifyDate, L.Reason, L.LeaveStatus, CONCAT(S.FirstName, ' ', S.LastName) AS StaffFullName,
   L.ApprovalStaff, L.StudentID, L.CreateUserID, L.ModifyUserID, L.Comment, L.StaffComment, L.ToDo,
   CASE WHEN L.InDate = '1900-01-01 00:00:00.000' THEN ''
		ELSE CONVERT(VARCHAR, L.InDate, 120)
		END AS InDate,
		CASE WHEN L.OutDate = '1900-01-01 00:00:00.000' THEN ''
		ELSE CONVERT(VARCHAR, L.OutDate, 120)
		END AS OutDate
    FROM tblBHSStudentLeaveRequest L
  LEFT JOIN tblStaff S ON L.ApprovalStaff = S.StaffID
  LEFT JOIN tblBHSStudent T ON T.StudentID = L.StudentID
  WHERE L.SDate BETWEEN '{from}' AND '{to}'
  ORDER BY L.SDate DESC",

  'edit-student-leave-request' => "UPDATE tblBHSStudentLeaveRequest
  SET SDate = '{SDate}', EDate = '{EDate}', ToDo = '{ToDo}',
  Reason = '{Reason}', Comment = '{Comment}', StaffComment = '{StaffComment}', ApprovalStaff = '{ApprovalStaff}', LeaveStatus = '{LeaveStatus}',
  InDate = '{InDate}', OutDate = '{OutDate}', ModifyUserID = '{ModifyUserID}', ModifyDate = '{ModifyDate}'
  WHERE LeaveID = '{LeaveID}' ",

  'self-assessments' => "SELECT s.AssessmentID,
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
  WHERE a.SemesterID = :term",

  'insert-student-leave-ban' => "INSERT INTO tblBHSStudentLeaveBan
           (StudentID
           ,FromDate
           ,ToDate
           ,Comment
           ,Status
           ,ModifyUserID
           ,CreateUserID
           )
           VALUES (
             '{StudentID}'
             ,'{FromDate}'
             ,'{ToDate}'
             ,'{Comment}'
             ,'A'
             ,'{ModifyUserID}'
             ,'{CreateUserID}'
           ) ",

  'student-leave-ban' => "SELECT A.*, S.FirstName, S.LastName, S.EnglishName, CONCAT(F.FirstName, ' ' , F.LastName) AS staffName FROM tblBHSStudentLeaveBan A LEFT JOIN tblBHSStudent S ON S.StudentID = A.StudentID
LEFT JOIN tblStaff F ON F.StaffID = A.CreateUserID",

'edit-student-leave-ban' => "UPDATE tblBHSStudentLeaveBan SET StudentID = '{StudentID}',
 FromDate = '{FromDate}', ToDate = '{ToDate}', Comment = '{Comment}', Status = '{Status}', ModifyUserID = '{ModifyUserID}', ModifyDate = '{ModifyDate}'
  WHERE BanID = '{BanID}'",

  'get-transcript-request' => "SELECT T.*,
  CONVERT(char(10), T.Deadline, 126) as Deadline,
  CONVERT(char(10), T.RequestDate, 126) as RequestDate,
  S.FirstName, S.LastName, S.EnglishName FROM tblBHSTranscriptRequest T
  LEFT JOIN tblBHSStudent S ON S.StudentID = T.CreateUserID
  ORDER BY T.RequestDate DESC",

  'save-transcript-request' => "
  UPDATE tblBHSTranscriptRequest
  SET Paid = :Paid, Status = :Status, ModifyDate = :ModifyDate, ModifyUserID = :ModifyUserID
  WHERE RequestID = :RequestID
  ",


    );
?>
