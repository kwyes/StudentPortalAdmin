<?php
  $StaffName = $_SESSION['FullName'];
?>
<div class="main-panel">
  <nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-minimize">
        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
          <i class="material-icons visible-on-sidebar-regular">more_vert</i>
          <i class="material-icons visible-on-sidebar-mini">view_list</i>
        </button>
      </div>
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="page-title">Grade 8/9 Weekly Assignments</div>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="separator hidden-lg hidden-md"></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="content">
    <!-- <div class="term-filter">
      <select class="term-select form-control custom-form" id="selfsubmit-selectTerm" disabled>
      </select>
    </div> -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <h4 class="card-title">
                  <i class="material-icons-outlined">date_range</i> Grade 8/9 Weekly Assignments
                </h4>
                <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
              </div>
              <div class="row container-fluid">
                <div class="col-md-12 selfsubmit-filter-group">
                  <!-- <label class="mg-r-10">
                    Term :
                    <div class="select-container">
                      <select id="sSubmit-term-select" class="select-term form-control custom-form mg-lr-7">
                      </select>

                    </div>
                  </label>

                  <label class="mg-r-10">
                    Teacher :
                    <div class="select-container">
                      <select name="staffLeader"
                        class="form-control custom-form mg-lr-7 width-200 ApprovalList">
                        <option value="">Select..</option>
                        <option value="all">All</option>
                      </select>
                    </div>
                  </label> -->

                  <!-- <label class="mg-r-10">
                    Course :
                    <div class="select-container">
                      <select name="courseList" class="form-control custom-form courseList mg-lr-7">
                      </select>
                    </div>
                  </label> -->


                  <label class="mg-r-10">
                    Week :
                    <div class="select-container">
                      <input type='text' id='weeklyDatePicker' class="form-control custom-form mg-lr-7 maxWidth-none datepicker" data-date-format="YYYY-MM-DD" placeholder="Select Week" />
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Counsellor :
                    <div class="select-container" id="wa-counsellor">
                      <select class="form-control custom-form mg-lr-7 wa-counsellor-list"></select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Grade :
                    <div class="select-container" id="wa-grade">
                      <select class="form-control custom-form mg-lr-7 wa-grade-list">
                        <option value="">All</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Country :
                    <div class="select-container" id="wa-country">
                      <select class="form-control custom-form mg-lr-7 wa-country-list"></select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Gender :
                    <div class="select-container" id="wa-gender">
                      <select class="form-control custom-form mg-lr-7 wa-gender-list">
                        <option value="">All</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                      </select>
                    </div>
                  </label>

                  <!-- <label>
                    Date :
                    <input id="self-date-from" data-id="self-date" type="text" placeholder="From"
                      class="form-control datepicker selfsubmit-dateFrom custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD"> ~
                    <input id="self-date-to" data-id="self-date" type="text" placeholder="To"
                      class="form-control datepicker selfsubmit-dateTo custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD">
                  </label>
                  <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button> -->
                </div>
              </div>


              <div class="material-datatables">
                <table id="datatables-entireStudentList" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>STUDENT</th>
                      <th>SP</th>
                      <th>MC</th>
                      <th>WA</th>
                      <th><span class="material-icons">done</span></th>
                      <th><span class="material-icons">clear</span></th>
                      <th><span class="material-icons">not_interested</span></th>
                      <th>ORIGIN</th>
                      <th>Gender</th>
                      <th>Grade</th>
                      <th>Counselor</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div><!-- end content-->
          </div><!--  end card  -->
        </div> <!-- end col-md-12 -->
      </div> <!-- end row -->
    </div>
  </div>
</div>
<!-- <script src="../js/modalControl.js?ver=<?=$settings['gsversion']?>"></script> -->
<?php include_once('studentpicFrame.html'); ?>
<?php include_once('g8g9WeeklyAssignmentModal.php'); ?>
<?php include_once('g8g9WeeklyAssignmentDetailModal.php'); ?>
<script type="text/javascript">
  $(document).ready(function () {
    dateTimePicker();
    showCurrentTerm();
    pagerNumResize();

    var weekDate = getWeekDate(new Date());
    $("#weeklyDatePicker").val(weekDate);
    setWeekDatePicker("#weeklyDatePicker");
    createG8G9WeeklyAssignmentListTable("<?=$StaffName?>");

    $('#weeklyDatePicker').on('dp.change', function(e){
      createG8G9WeeklyAssignmentListTable("<?=$StaffName?>");
    });
  });

  $(document).on("click",".waLink",function (event) {
      var target = $(event.target);
      var dataid = target.attr("data-id");
      ajaxtoMyCourses(dataid);
      ajaxtostudentinfo(dataid);
    });

</script>
