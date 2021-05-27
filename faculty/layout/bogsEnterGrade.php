<!-- <input type="hidden" class="chosenCourseId" name="" value="<?=$_POST['courseId']?>"> -->
  <div class="content bogs-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Total Activities -->
          <div class="card">
            <div class="card-content">
              <div class="row row-eq-height mg-b-20">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4 class="card-title"><i class="material-icons-outlined">create</i>Enter Grade</h4>
                  <p class="card-category"><?php echo $_SESSION['bogsSemesterText'].' - '?><span class="course-info"></span></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                  <?php if($_SESSION['SemesterID'] == $_SESSION['bogsSemester']) { ?>
                  <button id="btn-bogs-enterGrade-save" type="button"
                        class="btn btn-fill btn-info btn-sm">Save Changes</button>
                  <?php } ?>
                </div>
              </div>

              <div class="row mg-b-20 row-eq-height">
                <div class="col-md-8">
                  <label class="mg-0"><span class="color-18acbc text-bold mg-r-5">Category: </span><span class="text-bold enterGrade-category"> </span>(Category Wight: <span class="text-bold enterGrade-cateWeight"></span>)</label><br/>
                  <label class="mg-0"><span class="color-18acbc text-bold mg-r-5">Category Item: </span><span class="text-bold enterGrade-item"> </span>(Item Wight: <span class="text-bold enterGrade-itemWeight"></span>)</label><br/>
                  <label><span class="color-18acbc text-bold mg-r-5">Assign Date: </span><span class="text-bold enterGrade-assignDate"></span></label>
                  <input type="hidden" class="item-MaxValue" name="" value="">
                </div>
                <div class="col-md-4"></div>
              </div>

              <div class="material-datatables">
                <table id="datatables-bogs-enterGrade" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th>STUDENT ID</th>
                      <th>STUDENT NAME</th>
                      <th>EXEMPTED</th>
                      <th>SCORE</th>
                      <th>OUT OF</th>
                      <th>COMMENT</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
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
<script src="js/f_bogs_enter.js?ver=<?=$settings['bversion']?>" charset="utf-8"></script>
<script type="text/javascript">
  $(document).ready(function () {
    // showCurrentTerm();
    // generateTermListV2(".termList", globalSemesterList);
    var selectedTerm = $('.termList').val();
    GetCourseOptionsList(selectedTerm,'<?=$_SESSION['staffId']?>');
    getEnterGradeRecord();
  });
</script>
