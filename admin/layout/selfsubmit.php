<?php
$toDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $_SESSION["NextStartDate"] ) ) . "-1 day" ) );
$fromDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $_SESSION["StartDate"] ) ) . "-10 day" ) );
// $fromDate = '2018-01-01';

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
        <div class="page-title">Self-submitted Hours</div>
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
                <div class="row">
                  <div class="col-md-4">
                    <h4 class="card-title">
                      <i class="material-icons-outlined">description</i>Browse Self-Submitted Hours I'm
                      Approving
                    </h4>
                    <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
                  </div>
                  <div class="col-md-8 text-right">
                    <div>
                      <button id="btn-self-approve" type="button"
                        class="btn btn-fill btn-info approve-selected-btn btn-sm">Approve
                        Selected</button>
                      <button id="btn-self-cancel" type="button"
                        class="btn btn-fill btn-danger cancel-selected-btn btn-sm">Reject
                        Hrs Selected</button>
                      <button type="button" class="btn btn-fill btn-info add-sSubmit-btn btn-sm" data-toggle="modal">Add
                        Self-Submit Hrs</button>
                    </div>

                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12 selfsubmit-filter-group">
                  <!-- <label class="custom-form-label">
                    Categories :
                    <div id="activity-cateSelect"></div>
                  </label> -->
                  <label class="mg-r-10">
                    Approving Staff :
                    <div class="select-container">
                      <select name="staffLeader" id="sSubmit-stfLeader-select"
                        class="form-control custom-form mg-lr-7 width-200 ApprovalList">
                        <option value="">Select..</option>
                        <option value="all">All</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Term :
                    <div class="semester_filter">
                      <select id="sSubmit-term-select" class="select-term form-control custom-form">
                      </select>

                    </div>
                  </label>
                  <label class="mg-r-10">
                    Category :
                    <select id="sSubmit-category-select" class="select-category form-control custom-form">
                      <option value="">All</option>
                      <option value="10">PORE</option>
                      <option value="11">AISD</option>
                      <option value="12">CILE</option>
                      <option value="13">ACLE</option>
                    </select>
                  </label>

                  <label class="mg-r-10">
                    Status :
                    <select id="sSubmit-status-select" class="select-category form-control custom-form">
                      <option value="">All</option>
                      <option value="60">Pending Approval</option>
                      <option value="80">Hours Approved</option>
                      <option value="90">Rejected</option>
                    </select>
                  </label>

                  <label>
                    Date :
                    <input id="self-date-from" data-id="self-date" type="text" placeholder="From"
                      class="form-control datepicker selfsubmit-dateFrom custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$fromDate?>"> ~
                    <input id="self-date-to" data-id="self-date" type="text" placeholder="To"
                      class="form-control datepicker selfsubmit-dateTo custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$toDate?>">
                  </label>
                  <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button>
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-selfsubmit" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="selectAll"></th>
                      <th>DATE</th>
                      <th>STUDENT NAME</th>
                      <th>ACTIVITY</th>
                      <th>SOURCE</th>
                      <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                      <div class='mg-b-5'><label><i class='material-icons-outlined mg-r-10'>directions_bike</i>
                      Physical, Outdoor & Recreation Education</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>school</i> Academic, Interest & Skill Development</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>language</i> Citizenship, Interaction & Leadership Experience</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>palette</i> Arts, Culture & Local Exploration</label></div>
                    </div>">CATEGORY</span></th>
                      <th>test</th>
                      <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                      <label>Qualifies for Career Exploration Hours</label>
                    </div>">CREX</span></th>
                      <th>HOURS</th>
                      <th>APPROVER</th>
                      <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                      <!-- <label><i class='material-icons-outlined mg-r-10'>date_range</i>
                        Registered</label> -->
                      <label><i class='material-icons-outlined mg-r-10'>hourglass_empty</i> Pending
                        Approval</label>
                      <label><i class='material-icons-outlined mg-r-10'>done_outline</i> Hours
                        Approved</label>
                      <label><i class='material-icons-outlined mg-r-10'>link_off</i> Rejected</label>
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
  include_once('layout/selfSubmitModal.php');
  include_once('layout/addSelfSubmitModal.php');
  include_once('layout/studentpicFrame.html');
  // include_once('layout/spinner.html');
?>
<script type="text/javascript">
  $(document).ready(function () {
    ajaxtoApprovalList('.ApprovalList');
    $("#sSubmit-stfLeader-select").val("<?=$selectStaffId?>").change();
    get_selfsubmit_rows();
    dateTimePicker();
    showCurrentTerm();
    pagerNumResize();
    selectAllCheckbox("#datatables-selfsubmit");

    $('#btn-self-approve, #btn-self-cancel').click(function (event) {
      var elem = $(this);
      var elemId = elem.attr('id');
      var chk;

      var allActivityId = [];
      var fullname = [];
      var email = [];
      var info = [];
      var studentActivityId = [];
      var studentId = [];
      var notApprovedStu = [];
      var targetStatus;
      var fullnameTxt;
      var breakpoint = 'break';

      if (elemId == 'btn-self-approve') {
        targetStatus = 80;
      } else {
        targetStatus = 90;
      }
      var index = 0;
      $('.self-submit-chk:checked').each(function (i) {
        allActivityId[i] = $(this).val();
        for (let j = 0; j < selfsubmitResponse.length; j++) {
          if (allActivityId[i] == selfsubmitResponse[j].StudentActivityID &&
            selfsubmitResponse[j].ActivityStatus != targetStatus) {
            if (selfsubmitResponse[j].EnglishName == "") {
              fullnameTxt = selfsubmitResponse[j].FirstName + " " + selfsubmitResponse[j].LastName
            } else {
              fullnameTxt = selfsubmitResponse[j].FirstName + " (" + selfsubmitResponse[j].EnglishName +
                ") " +
                selfsubmitResponse[j].LastName
            }
            studentActivityId[index] = selfsubmitResponse[j].StudentActivityID;
            studentId[index] = selfsubmitResponse[j].StudentID;
            info.push({
              "fullName": fullnameTxt,
              "email": selfsubmitResponse[j].SchoolEmail
            })
            index++;
          }
        }
        breakpoint = 'ok';
      });
      notApprovedStu.push({
        "studentActivityId": studentActivityId,
        "studentId": studentId,
        "info": info
      });

      if (breakpoint == 'ok') {
        swal({
          title: 'Are you sure?',
          text: "This would update " + studentActivityId.length + " out of " + allActivityId.length +
            " record!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonClass: 'btn btn-info',
          cancelButtonClass: 'btn btn-danger',
          confirmButtonText: 'OK',
          buttonsStyling: false
        }).then(function (confirm) {
          if (confirm) {
            if (elemId == 'btn-self-approve') {
              chk = 0;
            } else {
              chk = 1;
            }
            updateSelfSubmitHours(notApprovedStu, chk);
          }
        }).catch(swal.noop);
      } else {
        showSwal('error', 'You need to check at least one');
      }
    });

    $('#sSubmit-stfLeader-select').on('change', function () {
      get_selfsubmit_rows();
    });

  });
  // $(document).on("mouseover", ".hoverShowPic", function(event) {
  //   $("figure.studentImageFrame").css("left", $(this).offset().left + 315);
  //   });
</script>
