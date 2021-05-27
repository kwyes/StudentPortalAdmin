<?php
// $toDate = date('Y-m-d');
$toDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $_SESSION["NextStartDate"] ) ) . "-1 day" ) );
$fromDate = $_SESSION["StartDate"];

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
        <div class="page-title">School Activities</div>
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
      <select class="term-select form-control custom-form" id="activities-selectTerm" disabled>
      </select>
    </div> -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <h4 class="card-title"><i class="material-icons-outlined">accessibility_new</i>Browse School Activities
                </h4>
              </div>
              <div class="row">
                <div class="col-md-7 activities-filter-group">
                  <label class="custom-form-label">
                    Categories :
                    <div id="activity-cateSelect"></div>
                  </label>
                  <label class="custom-form-label">
                    Staff Leader :
                    <select name="staffLeader" id="act-stfLeader-select"
                      class="form-control custom-form mg-lr-7 ApprovalList">
                      <option value="all">All</option>
                    </select>
                  </label>
                  <label class="custom-form-label">
                    Date :
                    <input id="act-date-from" data-id="act-date" type="text" placeholder="From"
                      class="form-control datepicker selfsubmit-dateFrom custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$fromDate?>"> ~
                    <input id="act-date-to" data-id="act-date" type="text" placeholder="To"
                      class="form-control datepicker selfsubmit-dateTo custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$toDate?>">
                  </label>
                  <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button>
                </div>
                <div class="col-md-5 activities-btn-group">
                  <div class="row">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-fill btn-info add-act-btn btn-sm" data-toggle="modal">Add
                        Activity</button>
                      <!-- <button type="button" class="btn btn-fill btn-info bulk-update-btn btn-sm">Bulk Upload (CSV)</button> -->
                      <!-- <button type="button" class="btn btn-fill btn-info del-selected-btn btn-sm">Delete Selected</button> -->
                      <button type="button" class="btn btn-fill btn-info export-exc-btn btn-sm">Export to Excel</button>
                    </div>
                    <div class="col-md-12">
                      <label class="mg-r-10"><i class="material-icons-outlined font-16 color-3c4858">directions_bike</i> :
                        PORE</label>
                      <label class="mg-r-10"><i class="material-icons-outlined font-16 color-3c4858">school</i> : AISD</label>
                      <label class="mg-r-10"><i class="material-icons-outlined font-16 color-3c4858">language</i> : CILE</label>
                      <label class="mg-r-10"><i class="material-icons-outlined font-16 color-3c4858">palette</i> : ACLE</label>
                    </div>
                  </div>

                </div>
              </div>
              <div class="material-datatables">
                <table id="datatables-activities"
                  class="table table-striped table-no-bordered table-hover table-activities display nowrap ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>ACTIVITIY</th>
                      <th>DATE</th>
                      <th>HOURS</th>
                      <th>STAFF LEADER</th>
                      <th>ENROLLMENT<Br /> TYPE</th>
                      <th class="activity-category">ACTIVITY<br />CATEGORY</th>
                      <th>CREX</th>
                      <th>CURRENT<br /> / MAX</th>
                      <th>ENROLLMENT<br /> STATUS</th>
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
  include_once('layout/schoolActivityModal.html');
  include_once('layout/deleteActivityModal.html');
  include_once('layout/addActivityModal.html');
  include_once('layout/addEnrollModal.html');
?>
<script type="text/javascript">
  $(document).ready(function () {
    ajaxtoApprovalList('.ApprovalList');
    $("#act-stfLeader-select").val("<?=$selectStaffId?>").change();
    show_school_activities();
    dateTimePicker();
    showCurrentTerm();
    pagerNumResize();
    $(document).ready(function () {
      $('#act-stfLeader-select').on('change', function () {
        show_school_activities();
      });
    });
  });
</script>