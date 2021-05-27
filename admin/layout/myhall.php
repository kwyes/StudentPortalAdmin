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
        <div class="page-title">My Hall</div>
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
                  <i class="material-icons-outlined">domain</i> Students in My Hall
                </h4>
                <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
              </div>


              <div class="material-datatables">
                <table id="datatables-myStudentList" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>STUDENT</th>
                      <th>SP</th>
                      <th>MC</th>
                      <th>Email</th>
                      <th>ORIGIN</th>
                      <th>RESIDENCE</th>
                      <th>ROOM</th>
                      <th>HALL</th>
                      <th>HOUSE</th>
                      <th>HALL<br />ADVISOR</th>
                      <th>HALL<br />ADVISOR2</th>
                      <th>TUTOR</th>
                      <th>TUTOR<BR />ROOM</th>
                      <th>FOB ID</th>
                      <th>STUDENT ID</th>
                      <th>ENROLLED<br />SINCE</th>
                      <th>COUNSELLOR</th>
                      <th>MENTOR<br />TEACHER</th>
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
    createStudentListTable('<?=$_SESSION['stfFullName']?>');

  });

</script>
