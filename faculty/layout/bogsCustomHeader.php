<div class="main-panel">
  <div class="row maxWidth-100per">
    <div class="col-md-6 col-sm-12">
      <nav class="navbar navbar-transparent">
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
            <div class="page-title"></div>
          </div>
          <div class="collapse navbar-collapse">
          </div>
        </div>
      </nav>
    </div>
    <div class="col-md-6 col-sm-12 bogs-select">
      <div class="row-eq-height flexEnd width-100per pd-r-15 bogs-select-children">
        <div class="row-eq-height">
          <div class="form-group bogs-select-term">
            <label class="color-18acbc font-12 text-bold">Term</label>
            <select name="termList"
              class="form-control custom-form termList width-auto" disabled>
              <option value="<?=$_SESSION['bogsSemester']?>"><?=$_SESSION['bogsSemesterText']?></option>
            </select>
          </div>
          <div class="form-group bogs-select-course">
            <label class="color-18acbc font-12 text-bold">Course</label>
            <select name="courseList"
              class="form-control custom-form courseList width-auto">
            </select>
          </div>
        </div>
        <div class="row-eq-height bogs-select-group2">
          <div class="form-group">
            <label class="color-18acbc font-12 text-bold">Categories</label>
            <select name="courseList"
              class="form-control custom-form categoryList width-auto">
            </select>
          </div>
          <div class="form-group bogs-select-item">
            <label class="color-18acbc font-12 text-bold">Category Items</label>
            <select name="courseList"
              class="form-control custom-form itemList width-auto">
            </select>
          </div>
        </div>
        <div class="row-eq-height pd-r-20 bogs-viewBtn">
            <button class="btn btn-fill btn-info btn-sm btn-bogs-view">VIEW</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    // $(document).ready(function() {
    //   showCurrentTerm();
    //   generateTermListV2(".termList", globalSemesterList, <?=$_SESSION['bogsSemester']?>);
    // });
  </script>
