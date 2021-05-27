<?php
$toDate = date("Y-m-d", strtotime(" +1 days"));
// $fromDate = date("Y-m-d");
$fromDate = date("2020-01-01");
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
        <div class="page-title">Leave Ban</div>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="separator hidden-lg hidden-md"></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <div class="row">
                  <div class="col-md-4">
                    <h4 class="card-title">
                      <i class="material-icons-outlined">highlight_off</i>Leave Ban List
                    </h4>
                    <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
                  </div>
                  <div class="col-md-8 text-right">
                    <button id="btn-leave-create" type="button" data-toggle="modal"
                      class="btn btn-fill btn-info btn-sm">Create</button>
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12 leave-request-filter-group">
                  <!-- <label class="mg-r-10">
                    Approving Staff :
                    <div class="select-container">
                      <select name="staffLeader" id="leave-request-staff-select"
                        class="form-control custom-form mg-lr-7 width-200 ApprovalList">
                        <option value="">Select..</option>
                        <option value="">All</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Status :
                    <select id="leave-request-status-select" class="select-category form-control custom-form">
                      <option value="">All</option>
                      <option value="P">Pending Approval</option>
                      <option value="A">Hours Approved</option>
                      <option value="R">Rejected</option>
                    </select>
                  </label>

                  <label>
                    Date :
                    <input id="leave-date-from" data-id="leave-date" type="text" placeholder="From"
                      class="form-control datepicker leave-request-dateFrom custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$fromDate?>"> ~
                    <input id="leave-date-to" data-id="leave-date" type="text" placeholder="To"
                      class="form-control datepicker leave-request-dateTo custom-form mg-lr-7"
                      data-date-format="YYYY-MM-DD" value="<?=$toDate?>">
                  </label>
                  <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button> -->
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-leave-ban" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Ban ID</th>
                      <th>Student ID</th>
                      <th>Student Name</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Created on</th>
                      <th>CreateUser</th>

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
  include_once('layout/studentpicFrame.html');
  include_once('layout/leaveBanModal.php');
  include_once('layout/leaveBanCreateModal.php');
?>
<script type="text/javascript">
  $(document).ready(function () {
    getStudentLeaveBan();
    pagerNumResize();
  });
</script>
