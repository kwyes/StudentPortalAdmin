  <div class="content bogs-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Total Activities -->
          <div class="card">
            <div class="card-content">
              <div class="row row-eq-height mg-b-20">
                <div class="col-md-8">
                  <h4 class="card-title"><i class="material-icons-outlined">create</i><span class="bogs-grade-title">Enter Weekly Assignment</span></h4>
                  <p class="card-category"><?php echo $_SESSION['bogsSemesterText'].' - '?><span class="course-info"></span></p>
                </div>
                <div class="col-md-4 text-right">
                  <button id="btn-bogs-wassignment-save" type="button"
                        class="btn btn-fill btn-info btn-sm">Save Changes</button>
                  <button id="btn-bogs-wassignment-cancel" type="button"
                        class="btn btn-fill btn-info btn-sm">Cancel</button>
                  <button id="btn-bogs-wassignment-test" type="button"
                        class="btn btn-fill btn-info btn-sm">Populate Assignments</button>
                </div>
              </div>
              <label class="mg-r-10">Week :<div class="select-container">
                <input type="text" id="weeklyDatePicker2" class="form-control custom-form mg-lr-7 maxWidth-none datepicker" data-date-format="YYYY-MM-DD" placeholder="Select Week" />
              </div>
            </label>
              <div class="material-datatables">
                <table id="datatables-bogs-weeklyAssignment" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>STUDENT ID</th>
                      <th>FIRST NAME</th>
                      <th>LAST NAME</th>
                      <th>WEEKLY ASSIGNMENT</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
  include_once('layout/spinner.html');
  include_once('layout/studentpicFrame.html');
  include_once('layout/waPopulateModal.php');
?>
<script type="text/javascript">
$(document).ready(function () {

  showCurrentTerm();
  var selectedTerm = $('.termList').val();
  getMyCourseListV2(selectedTerm,'<?=$_SESSION['staffId']?>');
  var selectedCourse = $('.courseList').val();
  var selectedCourseText = $('.courseList option:selected').text()
  $('.course-info').html(selectedCourseText);
  getStudentListBySubject();
  dateTimePicker();
  var weekDate = getWeekDate(new Date());
  $("#weeklyDatePicker2").val(weekDate);
  setWeekDatePicker("#weeklyDatePicker2");
  getWeeklyAssignment();

  $("#btn-bogs-wassignment-test").click(function () {
    $('#waPopulateModal').modal();
  });



})
</script>
<script src="../js/modalControl.js?ver=<?=$settings['gsversion']?>"></script>
<script src="js/f_bogs_weeklyAssignment.js?ver=<?=$settings['bversion']?>" charset="utf-8"></script>
