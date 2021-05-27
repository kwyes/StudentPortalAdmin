<?php
$SemesterID = $_SESSION["SemesterID"];
$staffRole = $_SESSION['staffRole'];
if($staffRole !== '99'){
  $selectStaffId = $_SESSION['staffId'];
} else {
  $selectStaffId = 'all';
}
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
        <div class="page-title">Career Life Pathway</div>
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
      <select class="term-select form-control custom-form" id="careerlife-selectTerm" disabled>
      </select>
    </div> -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <div class="row">
                  <div class="col-md-4">
                    <h4 class="card-title">
                      <i class="material-icons-outlined">flag</i>Career Life Pathway
                    </h4>
                    <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
                  </div>
                  <div class="col-md-8 text-right">
                    <div>
                      <button id="btn-career-approve" type="button"
                        class="btn btn-fill btn-info approve-selected-btn btn-sm">Approve</button>
                      <button id="btn-career-complete" type="button"
                        class="btn btn-fill btn-info complete-selected-btn btn-sm">Complete</button>
                      <button id="btn-career-cancel" type="button"
                        class="btn btn-fill btn-info cancel-selected-btn btn-sm">Cancel</button>
                      <button id="btn-career-submit" type="button"
                        class="btn btn-fill btn-warning submit-capstone-btn btn-sm" data-toggle="modal">SUBMIT</button>
                    </div>

                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12 careerlife-filter-group">
                  <!-- <label class="custom-form-label">
                    Categories :
                    <div id="activity-cateSelect"></div>
                  </label> -->
                  <label class="mg-r-10">
                    Teacher :
                    <div class="select-container">
                      <select name="staffLeader" id="career-stfLeader-select" class="form-control custom-form mg-lr-7">
                        <option value="">Select..</option>
                        <option value="all">All</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Term :
                    <div class="semester_filter">
                      <select id="career-term-select" class="form-control custom-form">
                        <option value="">Select..</option>
                      </select>

                    </div>
                  </label>
                  <label class="mg-r-10">
                    Category :
                    <select id="career-category-select" class="select-category form-control custom-form">
                      <option value="Select..">Select..</option>
                      <option value="">All</option>
                      <option value="CLE">CLE</option>
                      <option value="CLC">CLC</option>
                    </select>
                  </label>

                  <label class="mg-r-10">
                    Status :
                    <select id="career-status-select" class="select-category form-control custom-form">
                      <option value="Select..">Select..</option>
                      <option value="">All</option>
                      <option value="60">Pending Approval</option>
                      <option value="80">Approved</option>
                      <option value="90">Rejected</option>
                    </select>
                  </label>


                  <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button>
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-careerlife" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="selectAll"></th>
                      <th>DATE</th>
                      <th>COURSE</th>
                      <th>TEACHER</th>
                      <th>STUDENT</th>
                      <th>CATEGORY</th>
                      <th>CAPSTONE TOPIC</th>
                      <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                      <!-- <label><i class='material-icons-outlined mg-r-10'>date_range</i>
                        Registered</label> -->
                      <label><i class='material-icons-outlined mg-r-10'>hourglass_empty</i> Pending
                        Approval</label>
                        <label><i class='material-icons-outlined mg-r-10'>play_arrow</i> In Progress</label>
                      <label><i class='material-icons-outlined mg-r-10'>done_outline</i> Completed</label>
                      <label><i class='material-icons-outlined mg-r-10'>link_off</i> Cancelled</label>
                    </div>">STATUS</span></th>
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
<script src="../js/modalControl.js?ver=<?=$settings['gsversion']?>"></script>
<?php
include_once('layout/careerLifeModal.html');
include_once('layout/addCareerLifeModal.php');
include_once('layout/studentpicFrame.html');
?>
<script type="text/javascript">
  $(document).ready(function () {
    showCurrentTerm();
    ajaxToCareerStaffList('#career-stfLeader-select', '<?=$SemesterID?>');
    $("#career-stfLeader-select").val("<?=$selectStaffId?>").change();
    ajaxToCareerRecordList('<?=$SemesterID?>');
    ajaxToGetListCareerSubejct('<?=$SemesterID?>', '#career-course');
    $('#career-stfLeader-select').on('change', function () {
      ajaxToCareerRecordList('<?=$SemesterID?>');
    });
    selectAllCheckbox("#datatables-careerlife");

    $('#btn-career-approve, #btn-career-cancel, #btn-career-complete').click(function (event) {
      var elem = $(this);
      var elemId = elem.attr('id');
      var chk;

      var allProjectId = [];
      var fullname = [];
      var email = [];
      var info = [];
      var projectId = [];
      var studentId = [];
      var notApprovedStu = [];
      var targetStatus;
      var fullnameTxt;
      var breakpoint = 'break';

      if (elemId == 'btn-career-approve') {
        targetStatus = 70;
      } else if (elemId == 'btn-career-complete') {
        targetStatus = 80;
      } else {
        targetStatus = 90;
      }
      var index = 0;
      $('.career-submit-chk:checked').each(function (i) {
        allProjectId[i] = $(this).val();
        for (let j = 0; j < careerObj.length; j++) {
          if (allProjectId[i] == careerObj[j].ProjectID &&
            careerObj[j].ApprovalStatus != targetStatus) {
            if (careerObj[j].SEnglishName == "") {
              fullnameTxt = careerObj[j].SFirstName + " " + careerObj[j].SLastName
            } else {
              fullnameTxt = careerObj[j].SFirstName + " (" + careerObj[j].SEnglishName +
                ") " +
                careerObj[j].SLastName
            }
            projectId[index] = careerObj[j].ProjectID;
            studentId[index] = careerObj[j].StudentID;
            info.push({
              "fullName": fullnameTxt,
              "email": careerObj[j].SchoolEmail
            })
            index++;
          }
        }
        breakpoint = 'ok';
      });
      notApprovedStu.push({
        "projectId": projectId,
        "studentId": studentId,
        "info": info
      });

      if (breakpoint == 'ok') {
        swal({
          title: 'Are you sure?',
          text: "This would update " + projectId.length + " out of " + allProjectId.length +
            " record!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonClass: 'btn btn-info',
          cancelButtonClass: 'btn btn-danger',
          confirmButtonText: 'OK',
          buttonsStyling: false
        }).then(function (confirm) {
          if (confirm) {
            if (elemId == 'btn-career-approve') {
              chk = 0;
            } else if (elemId == 'btn-career-complete') {
              chk = 1;
            } else {
              chk = 2;
            }
            updateCareerLifeStatus(notApprovedStu, chk);
          }
        }).catch(swal.noop);
      } else {
        showSwal('error', 'You need to check at least one');
      }
    });
  });
</script>
