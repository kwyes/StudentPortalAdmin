<?php
$toDate = date('Y-m-d');
// $fromDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
$fromDate = $_SESSION["StartDate"];

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
        <div class="page-title">Volunteer & Work Experience Hours</div>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="separator hidden-lg hidden-md"></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="term-filter">
      <select class="term-select form-control custom-form" id="vlwe-selectTerm" disabled>
      </select>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <h4 class="card-title"><i class="material-icons-outlined">favorite_border</i>Volunteer & Work Experience
                  Hours</h4>
              </div>
              <div class="row">
                <div class="col-md-7 vlwe-filter-group">
                  <!-- <label class="custom-form-label">
                    Categories :
                    <div id="activity-cateSelect"></div>
                  </label> -->
                  <label class="custom-form-label">
                    Approving Staff :
                    <select name="staffLeader" id="vlwe-stfLeader-select"
                      class="form-control custom-form mg-lr-7 ApprovalList">

                    </select>
                  </label>
                  <label class="custom-form-label">
                    Date :
                    <input id="vlwe-date-from" data-id="vlwe-date" type="text" placeholder="From"
                      class="form-control datepicker vlwe-dateFrom custom-form mg-lr-7" data-date-format="YYYY-MM-DD"
                      value="<?=$fromDate?>"> ~
                    <input id="vlwe-date-to" data-id="vlwe-date" type="text" placeholder="To"
                      class="form-control datepicker vlwe-dateTo custom-form mg-lr-7" data-date-format="YYYY-MM-DD"
                      value="<?=$toDate?>">
                  </label>
                  <button type="button" class="btn btn-fill btn-warning filter-reset-btn btn-sm">Reset</button>
                </div>
                <div class="col-md-5 vlwe-btn-group">
                  <div class="row">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-fill btn-info add-vlwe-btn btn-sm" data-toggle="modal">Add
                        VLWE Hrs</button>
                    </div>
                    <div class="col-md-12">
                      <label class="mg-r-10"><i class="fas fa-pen-alt text-warning"></i> : Pending Registration</label>
                      <label class="mg-r-10"><i class="far fa-handshake text-success"></i> : Registered</label>
                      <label class="mg-r-10"><i class="fas fa-pen-fancy text-warning"></i> : Pending Hours
                        Approval</label>
                      <label class="mg-r-10"><i class="far fa-thumbs-up text-success"></i> : Hours Approved</label>
                      <label class="mg-r-10"><i class="fas fa-ban text-danger"></i> : Rejected</label>
                    </div>
                  </div>

                </div>
              </div>
              <div class="material-datatables">
                <table id="datatables-vlwe" class="table dataTable table-striped table-hover display nowrap"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>STUDENT ID</th>
                      <th>LAST NAME</th>
                      <th>FIRST NAME</th>
                      <th>KNOWN AS</th>
                      <th>TITLE</th>
                      <th>DATE</th>
                      <th>HOURS</th>
                      <th>APPROVER</th>
                      <th>SUPERVISOR</th>
                      <th>STATUS</th>
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
  include_once('layout/vlweModal.php');
  include_once('layout/addvlweModal.php');
?>
<script type="text/javascript">
  $(document).ready(function () {
    ajaxtoApprovalList('.ApprovalList');
    $("#vlwe-stfLeader-select").val("<?=$_SESSION['staffId']?>").change();
    get_vlwe_rows();
    dateTimePicker();
    showCurrentTerm();
    pagerNumResize();

    $('#vlwe-stfLeader-select').on('change', function () {
      get_vlwe_rows();
    });
  });
</script>