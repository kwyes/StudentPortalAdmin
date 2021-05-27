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
        <div class="page-title">Reports</div>
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
          <a href="?page=reports&menu=VLWEReport">Volunteer & Work Experience Hours Report</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    createStudentListTable('<?=$_SESSION['stfFullName']?>');
  });
</script>
