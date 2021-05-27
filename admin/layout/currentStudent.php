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
        <div class="page-title">Current Students</div>
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
                  <i class="material-icons-outlined">person_pin</i> Current Students
                </h4>
                <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
              </div>


              <div class="material-datatables">
                <table id="datatables-entireStudentList" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>STUDENT</th>
                      <th>SP</th>
                      <th>MC</th>
                      <th>Email</th>
                      <th>ORIGIN</th>
                      <th>Gender</th>
                      <th>Age</th>
                      <th>Grade</th>
                      <!-- <th>EnrollmentDate</th> -->
                      <th>Enrolled</th>
                      <th># of Terms</th>
                      <th>Counselor</th>
                      <th>Mentor</th>
                      <th>Living<BR />Location</th>
                      <th>House</th>
                      <th>Hall</th>
                      <th>Room</th>
                      <th>Hall Advisor 1</th>
                      <th>Hall Advisor 2</th>
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


<?php include_once('studentpicFrame.html'); ?>


<script type="text/javascript">
  $(document).ready(function () {
    createEntireCurrentStudentListTable();

  });
</script>
