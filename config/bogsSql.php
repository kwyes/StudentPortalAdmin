<?php
$_SQL = array(
    'get-my-courselist' => "SELECT S.SemesterID, S.SubjectID, S.CSubjectID, S.SubjectName, S.PName, S.CourseCd, S.RoomNo, S.Cap, S.Spa, S.Credit, S.Type, COUNT(T.StudSubjID) AS Num
    FROM tblBHSSubject S
	LEFT JOIN tblBHSStudentSubject T ON T.SubjectID = S.SubjectID
    WHERE S.SemesterID = ? AND S.TeacherID = ? AND S.Type != 'O'
	GROUP BY S.SemesterID, S.SubjectID, S.CSubjectID, S.SubjectName, S.PName, S.CourseCd, S.RoomNo, S.Cap, S.Spa, S.Credit, S.Type
    ORDER BY S.SubjectName ASC",

    'get-category-course' => "SELECT Text, CategoryID, SubjectID, CategoryCode, CategoryWeight, COUNT(CategoryItemID) AS ItemCount, SUM(smallsum) AS EachCategoryWeight
	  FROM (
	  SELECT C.Text, C.CategoryID, O.CategoryItemID, C.SubjectID, C.CategoryCode, C.CategoryWeight, SUM(O.ItemWeight) AS smallsum
	  FROM tblBHSOGSCategoryItems AS O
	  RIGHT JOIN tblBHSOGSCourseCategory AS C ON C.SubjectID = O.SubjectID
	  AND C.SemesterID = O.SemesterID AND C.CategoryID = O.CategoryID
	  WHERE C.SubjectID = '{courseId}' GROUP BY C.Text, C.CategoryID, O.CategoryItemID, C.SubjectID, C.CategoryCode, C.CategoryWeight)
	  T GROUP BY Text, CategoryID, SubjectID, CategoryCode, CategoryWeight
	  ORDER BY ItemCount DESC",

    'get-categoryItems-course' => "SELECT O.*, CONVERT(char(10), O.AssignDate, 126) as AssignDate, C.Text FROM tblBHSOGSCategoryItems AS O
    LEFT JOIN tblBHSOGSCourseCategory AS C ON C.SubjectID = O.SubjectID AND C.SemesterID = O.SemesterID AND C.CategoryID = O.CategoryID
    WHERE O.SubjectID = ?
    ORDER BY O.AssignDate ASC, O.CategoryID ASC",

    'insert-bogs-category' => "INSERT INTO tblBHSOGSCourseCategory
            (Text, CategoryCode, SubjectID, SemesterID, CategoryWeight, RunningTotal, ModifyUserID, CreateUserID)
            VALUES
              (:Text, :CategoryCode, :SubjectID, :SemesterID, :CategoryWeight, :RunningTotal, :ModifyUserID, :CreateUserID)
            ",

    'insert-bogs-category-items' => "INSERT INTO tblBHSOGSCategoryItems
            (CategoryID, SubjectID, SemesterID, Title, MaxValue, ScoreType, ItemWeight, ModifyUserID, CreateUserID, AssignDate, DueDate, Body)
            VALUES
              ('{CategoryID}', '{SubjectID}', '{SemesterID}', '{Title}', '{MaxValue}', '{ScoreType}', '{ItemWeight}', '{ModifyUserID}', '{CreateUserID}', '', '', '')
            ",

    'update-bogs-category' => "UPDATE tblBHSOGSCourseCategory SET Text = '{Text}', CategoryWeight = '{CategoryWeight}', ModifyDate = '{ModifyDate}' WHERE CategoryID = '{CategoryID}' ",

    'update-bogs-category-items' => "UPDATE tblBHSOGSCategoryItems SET Title = '{Title}', AssignDate = '{AssignDate}', ItemWeight = '{ItemWeight}', MaxValue = '{MaxValue}', ModifyDate = '{ModifyDate}' WHERE CategoryItemID = '{CategoryItemID}'",

    'delete-bogs-grade-items-byCategoryID' => "DELETE G FROM tblBHSOGSGrades G
    LEFT JOIN tblBHSOGSCategoryItems I ON I.CategoryItemID = G.CategoryItemID
    LEFT JOIN tblBHSOGSCourseCategory C ON C.CategoryID = I.CategoryID
    WHERE C.CategoryID = '{CategoryID}'",

    'delete-bogs-grade-items' => "DELETE FROM tblBHSOGSGrades WHERE CategoryItemID IN ({CategoryItemID})",

    'delete-bogs-category' => "DELETE FROM tblBHSOGSCourseCategory WHERE CategoryID = '{CategoryID}'",

    'delete-bogs-category-items-byCategoryID' => "DELETE FROM tblBHSOGSCategoryItems WHERE CategoryID = '{CategoryID}'",

    'delete-bogs-category-items' => "DELETE FROM tblBHSOGSCategoryItems WHERE CategoryItemID = '{CategoryItemID}'",

    'update-calculated-itemweight' => "UPDATE tblBHSOGSCategoryItems
    SET tblBHSOGSCategoryItems.ItemWeight= B.NewItemWeight
    FROM (SELECT CategoryItemID,
      NewItemWeight = MaxValue / (SELECT SUM(MaxValue) FROM tblBHSOGSCategoryItems WHERE CategoryID = '{CategoryID}')
      FROM tblBHSOGSCategoryItems
      where CategoryID = '{CategoryID}') B
      WHERE tblBHSOGSCategoryItems.CategoryItemID = B.CategoryItemID",

    'student-grade-list' => "SELECT a.StudNum StudentID, s.FirstName, s.LastName, s.EnglishName, a.StudSubjID,
     d.SubjectID, CategoryID, CategoryItemID, ISNULL(GradeID, '') GradeID, ScorePoint, MaxValue, ISNULL(Exempted,'') Exempted, Overridden, ISNULL(Comment,'') Comment
                    FROM tblBHSStudentSubject a
                    LEFT outer JOIN
					(
						SELECT i.SubjectID, i.CategoryID, i.CategoryItemID, g.SemesterID, i.AssignDate,
                    g.GradeID, g.ScorePoint, i.MaxValue, g.Exempted, g.Overridden, g.Comment, g.StudSubjID
					FROM tblBHSOGSGrades g LEFT JOIN tblBHSOGSCategoryItems i ON i.CategoryItemID = g.CategoryItemID
					WHERE i.CategoryID={CategoryID} AND i.CategoryItemID = {CategoryItemID}
					) d
					ON a.StudSubjID = d.StudSubjID
					LEFT JOIN tblBHSStudent s on s.StudentID = a.StudNum
					WHERE a.SubjectID={SubjectID} AND s.CurrentStudent = 'Y'
                    ORDER BY a.StudNum ASC",

      'student-grade-list-v2' => "SELECT a.StudNum StudentID, s.FirstName, s.LastName, s.EnglishName, a.StudSubjID,
       d.SubjectID, CategoryID, CategoryItemID, ISNULL(GradeID, '') GradeID, ScorePoint, MaxValue, ISNULL(Exempted,'') Exempted, Overridden, ISNULL(Comment,'') Comment
                      FROM tblBHSStudentSubject a
                      LEFT outer JOIN
    				(
    					SELECT i.SubjectID, i.CategoryID, i.CategoryItemID, g.SemesterID, i.AssignDate,
                      g.GradeID, g.ScorePoint, i.MaxValue, g.Exempted, g.Overridden, g.Comment, g.StudSubjID
    				FROM tblBHSOGSGrades g LEFT JOIN tblBHSOGSCategoryItems i ON i.CategoryItemID = g.CategoryItemID
    				WHERE i.CategoryID={CategoryID}
    				) d
    				ON a.StudSubjID = d.StudSubjID
    				LEFT JOIN tblBHSStudent s on s.StudentID = a.StudNum
    				WHERE a.SubjectID={SubjectID} AND s.CurrentStudent = 'Y'
                      ORDER BY a.StudNum ASC",

    'course-category-categoryitems-list' => "
    SELECT S.SubjectName, O.*, CONVERT(char(10), O.AssignDate, 126) as AssignDate, C.Text, C.CategoryWeight
    , SumItemWeight = (SELECT SUM(P.ItemWeight) FROM tblBHSOGSCategoryItems AS P WHERE P.CategoryID = O.CategoryID) FROM tblBHSOGSCategoryItems AS O
    LEFT JOIN tblBHSOGSCourseCategory AS C ON C.SubjectID = O.SubjectID AND C.SemesterID = O.SemesterID AND C.CategoryID = O.CategoryID
	LEFT JOIN tblBHSSubject AS S ON S.SubjectID = O.SubjectID AND S.SemesterID = O.SemesterID
    WHERE S.TeacherID = '{TeacherID}' AND S.SemesterID = '{SemesterID}'
    ORDER BY O.AssignDate ASC, O.CategoryID DESC",

    'insert-enter-grade' => "INSERT INTO tblBHSOGSGrades
            (CategoryItemID,StudSubjID,ScorePoint,Exempted,Overridden,Comment,ModifyDate,ModifyUserID,CreateDate,CreateUserID,SemesterID)
            VALUES
              ({CategoryItemID},{StudSubjID},{ScorePoint},{Exempted},{Overridden},'{Comment}','{ModifyDate}','{ModifyUserID}','{CreateDate}','{CreateUserID}',{SemesterID})
            ",

    'update-enter-grade' => "UPDATE tblBHSOGSGrades SET ScorePoint = {ScorePoint},
   Exempted = {Exempted}, Comment = '{Comment}', ModifyDate = '{ModifyDate}', ModifyUserID = '{ModifyUserID}'
    WHERE GradeID = {GradeID} AND CategoryItemID = {CategoryItemID} AND StudSubjID = {StudSubjID}",

    'student-list-bysubject' => "SELECT a.StudSubjID, s.StudentID, s.FirstName, s.LastName, s.EnglishName, s.SchoolEmail, s.Counselor, a.SubjectID
                    FROM tblBHSStudentSubject a
                    LEFT JOIN tblBHSStudent s ON s.StudentID = a.StudNum
                    WHERE a.SubjectID IN ({SubjectID}) --AND CurrentStudent='Y'
                    ORDER BY s.LastName ASC, s.FirstName ASC, s.EnglishName ASC, s.StudentID ASC",

    'student-grade-list-v3' => "SELECT a.StudNum StudentID, a.StudSubjID, i.SubjectID, i.CategoryID, i.CategoryItemID,
                    g.GradeID, g.ScorePoint, i.MaxValue, g.Exempted, g.Overridden, g.Comment, i.AssignDate
                    FROM tblBHSStudentSubject a
		                LEFT JOIN tblBHSSubject s ON a.SubjectID = s.SubjectID
                    LEFT JOIN tblBHSOGSGrades g ON a.StudSubjID = g.StudSubjID
                    LEFT JOIN tblBHSOGSCategoryItems i ON i.CategoryItemID = g.CategoryItemID
                    WHERE g.SemesterID={SemesterID} AND i.SubjectID = '{courseId}'
                    ORDER BY a.StudNum ASC, i.AssignDate ASC",

    'term-items' => "SELECT CategoryItemID, SubjectID, CategoryID, Title, MaxValue, ScoreType, AssignDate, DueDate, ItemWeight, Body, CCategoryItemID FROM tblBHSOGSCategoryItems
    WHERE SemesterID={SemesterID} AND SubjectID IN (SELECT SubjectID FROM tblBHSSubject WHERE SemesterID={SemesterID} AND TeacherID='{TeacherID}')
    ORDER BY SubjectID ASC, AssignDate ASC, CategoryID ASC",

    'term-info' => "SELECT * FROM tblBHSSemester WHERE SemesterID = {SemesterID}",

    'entire-term-items-schedule' => "SELECT O.SubjectID, C.CategoryID, O.CategoryItemID, S.SubjectName, CONVERT(char(10), O.AssignDate, 126) as AssignDate, C.Text, O.Title
     FROM tblBHSOGSCategoryItems AS O
    LEFT JOIN tblBHSOGSCourseCategory AS C ON C.SubjectID = O.SubjectID AND C.SemesterID = O.SemesterID AND C.CategoryID = O.CategoryID
	  LEFT JOIN tblBHSSubject AS S ON S.SubjectID = O.SubjectID AND S.SemesterID = O.SemesterID
    WHERE S.TeacherID = '{TeacherID}' AND S.SemesterID = '{SemesterID}'
    ORDER BY O.CategoryID ASC",

    'update-course-calendar-event' => "UPDATE tblBHSOGSCategoryItems SET AssignDate = '{AssignDate}', ModifyDate = '{ModifyDate}', ModifyUserID = '{ModifyUserID}' WHERE CategoryItemID = '{CategoryItemID}' AND CategoryID = '{CategoryID}' AND SubjectID = '{SubjectID}'",

    'weekly-assignment-list' => "SELECT * FROM tblBHSOGSWeeklyAssignment
    WHERE SemesterID = '{SemesterID}' AND SubjectID IN ({SubjectID}) AND AssignDate BETWEEN '{From}' AND '{To}' ",

    'update-weekly-assignment' => "UPDATE tblBHSOGSWeeklyAssignment
    SET Title = '{Title}', Status = '{Status}', ModifyDate = '{ModifyDate}'
    WHERE waID ='{waID}' ",

    'insert-weekly-assignment' => "INSERT INTO tblBHSOGSWeeklyAssignment (StudentID, SubjectID, SemesterID, Seq, Title, Status, AssignDate, ModifyUserID, CreateUserID)
    VALUES
      ('{StudentID}','{SubjectID}','{SemesterID}','{Seq}','{Title}','{Status}','{AssignDate}','{ModifyUserID}','{CreateUserID}')",

    );
?>
