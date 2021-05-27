<div class="modal fade modal-primary" id="courseCalendarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="card card-plain">
        <div class="modal-header justify-content-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="modal-close-icon">&times;</span>
          </button>

          <div class="header header-primary text-center">
            <h4>Course Calendar</h4>
            <div class="row-eq-height flexEnd">
              <div class="form-group text-left">
                <label class="color-18acbc font-12 text-bold">Course</label>
                <select name="courseList" class="form-control custom-form courseList-calendar width-auto"></select>
              </div>
              <div class="form-group text-left">
                <label class="color-18acbc font-12 text-bold">Categories</label>
                <select name="courseList" class="form-control custom-form categoryList-calendar width-auto"></select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
        <!-- <div class="text-center calendar-updateText">Calendar has been updated!</div> -->
          <!-- <div class="card-body"> -->
            <div class="card card-calendar">
              <div class="card-body ">
                <div id="fullCalendar"></div>
              </div>
            </div>
          <!-- </div> -->
          <div class="modal-footer text-center"></div>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
  });
</script>