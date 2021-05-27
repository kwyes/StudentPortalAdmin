  <div class="content bogs-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-right">
          <button class="btn btn-fill btn-info btn-sm btn-bogs-overall">View Overall Average</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Total Activities -->
          <div class="card">
            <div class="card-content">
              <div class="row row-eq-height mg-b-20">
                <div class="col-md-8">
                  <h4 class="card-title"><i class="material-icons-outlined">school</i><span class="bogs-grade-title">View Grade</span></h4>
                  <p class="card-category"><span class="course-info"></span></p>
                  <div class="text-bold term-title"></div>
                </div>
                <div class="col-md-4 viewGrade-description">
                  <label><span class="text-bold mg-r-10">ECPP </span>Earned Category Percent Point (max = 100%)</label>
                  <label><span class="text-bold mg-r-10">ECWP </span>Earned Category Weight Point (max = depends on course settings)</label>
                </div>
              </div>


              <div class="viewGrade-table-container">
                <!-- <table id="datatables-bogs-viewGrade" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>

                  </thead>
                  <tbody>

                  </tbody>
                </table> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
  include_once('layout/spinner.html');
  include_once('layout/studentpicFrame.html');
?>
<script src="../js/modalControl.js?ver=<?=$settings['gsversion']?>"></script>
<script src="js/f_bogs_view.js?ver=<?=$settings['bversion']?>" charset="utf-8"></script>
<script type="text/javascript">
  $(document).ready(function () {
    showCurrentTerm();
    // generateTermListV2(".termList", globalSemesterList);
    var selectedTerm = $('.termList').val();
    GetCourseOptionsListV2(selectedTerm,'<?=$_SESSION['staffId']?>');
  })
</script>
