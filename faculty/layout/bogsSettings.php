<div class="content bogs-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-right">
        <button id="btn-viewCalendar" type="button"
                            class="btn btn-fill btn-info btn-sm" data-toggle="modal" data-target="#courseCalendarModal">View Course Calendar</button>
        </div>
        <div class="col-md-12">
          <!-- Total Activities -->
          <div class="card">
            <div class="card-content">
              <div class="row row-eq-height">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4 class="card-title"><i class="material-icons-outlined">settings</i>Categories</h4>
                  <p class="card-category"><?php echo $_SESSION['bogsSemesterText'].' - '?><span class="course-info"></span></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                  <?php if($_SESSION['SemesterID'] == $_SESSION['bogsSemester']) { ?>

                  <button id="btn-bogs-category-save" type="button"
                        class="btn btn-fill btn-info btn-sm">Save</button>
                  <button id="btn-bogs-category-cansel" type="button"
                        class="btn btn-fill btn-info btn-sm">Cancel</button>
                  <button id="btn-bogs-category-add" type="button"
                        class="btn btn-fill btn-info btn-sm" data-target= "#bogsCategoryModal" data-toggle="modal">Add Category</button>
                  <button id="btn-bogs-category-delete" type="button"
                        class="btn btn-fill btn-info delete-selected-btn btn-sm">Delete Selected</button>
                  <div><label><i class="material-icons-outlined font-16 mg-r-5">error_outline</i>Category Weight Total: 100%</label></div>
                  <!-- <div><label><i class="material-icons-outlined font-16 mg-r-5">error_outline</i><span class="categoryErrorSpan"></span></label></div> -->
                  <?php } ?>
                </div>
              </div>

              <div class="material-datatables mg-t-20">
                <table id="datatables-bogs-category" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="selectAll"></th>
                      <th>CATEGORY ID</th>
                      <th>CATEGORY NAME</th>
                      <th colspan="2">CATEGORY WEIGHT(%)</th>
                      <th>ITEM COUNT</th>
                      <th>ITEM WEIGHT TOTAL(%)</th>
                    </tr>
                  </thead>
                  <tbody>


                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-content">
              <div class="row row-eq-height">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4 class="card-title"><i class="material-icons-outlined">settings</i>Category Items</h4>
                  <p class="card-category"><?php echo $_SESSION['bogsSemesterText'].' - '?><span class="course-info"></span></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                  <?php if($_SESSION['SemesterID'] == $_SESSION['bogsSemester']) { ?>
                  <button id="btn-bogs-categoryItem-save" type="button"
                        class="btn btn-fill btn-info btn-sm">Save</button>
                  <button id="btn-bogs-categoryItem-cansel" type="button"
                        class="btn btn-fill btn-info btn-sm">Cancel</button>
                  <button id="btn-bogs-categoryItem-add" type="button"
                        class="btn btn-fill btn-info btn-sm" data-target= "#bogsCategoryItemModal" data-toggle="modal">Add Item(s)</button>
                  <button id="btn-bogs-categoryItem-delete" type="button"
                        class="btn btn-fill btn-info btn-sm">Delete Selected</button>
                  <?php } ?>
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-bogs-categoryItem" class="table dataTable table-striped table-hover display"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" class="selectAll"></th>
                      <th>ITEM ID</th>
                      <th>CATEGORY</th>
                      <th>TITLE</th>
                      <th>ASSIGNED DATE</th>
                      <th>ITEM WEIGHT(%)</th>
                      <th>OUT OF(pt)</th>
                      <th>DESCRIPTION</th>
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
<input type="hidden" class="bogsStaffId" name="" value="<?=$_SESSION['staffId']?>">
<script src="js/f_bogs_modalControl.js?ver=<?=$settings['bversion']?>" charset="utf-8"></script>
<script src="js/f_bogs_settings.js?ver=<?=$settings['bversion']?>" charset="utf-8"></script>
<?php
  include_once('layout/spinner.html');
  include_once('layout/bogsCategoryModal.html');
  include_once('layout/bogsCategoryItemModal.html');
  include_once('courseCalendarModal.php');
  include_once('courseCalendarEventModal.php');
?>
<script type="text/javascript">
$(document).ready(function () {
  selectAllCheckbox("#datatables-bogs-category");
  selectAllCheckbox("#datatables-bogs-categoryItem");
  // showCurrentTerm();
  // generateTermListV2(".termList", globalSemesterList);
  var selectedTerm = $('.termList').val();
  getMyCourseList(selectedTerm,'<?=$_SESSION['staffId']?>');
  var selectedCourse = $('.courseList').val();
  var selectedCourseText = $('.courseList option:selected').text()
  $('.course-info').html(selectedCourseText);
  getCategory(selectedCourse);
  getCategoryItems(selectedCourse);
  if (globalCategoryList) {
    calculateNumandPercentage(globalCategoryList, globalCategoryItemsList);
  }
  displayErr(errorArr);
});
</script>
