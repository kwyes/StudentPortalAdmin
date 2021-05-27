<?php

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
        <div class="page-title">Trasncript Request</div>
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
                      <i class="material-icons-outlined">note</i>Transcript Request
                    </h4>
                    <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
                  </div>
                  <div class="col-md-8 text-right">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 selfAssessments-filter-group">
                  <label class="mg-r-10">
                    Status :
                    <div class="select-container">
                      <select name="status" id="transcriptRequest-status-select"
                        class="form-control custom-form mg-lr-7 width-200">
                        <option value="">All</option>
                        <option value="P">Pending</option>
                        <option value="C">Canceled</option>
                        <option value="D">Done</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Paid :
                    <div class="semester_filter">
                      <select id="transcriptRequest-paid-select" class="form-control custom-form mg-lr-7 width-200">
                        <option value="">All</option>
                        <option value="P">Paid</option>
                        <option value="N">No</option>
                      </select>

                    </div>
                  </label>

                  <!-- <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button> -->
                </div>
              </div>



              <div class="material-datatables">
                <table id="datatables-transcriptRequest" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="text-align:left">StudentID</th>
                      <th style="text-align:left">Name</th>
                      <th style="text-align:left">RequestDate</th>
                      <th style="text-align:left">DeadLine</th>
                      <th style="text-align:left">Paid</th>
                      <th>Status</th>
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
  include_once('layout/transcriptRequestModal.php');
?>
<script type="text/javascript">
  $(document).ready(function () {
    getTranscriptRequest();

  });
</script>
