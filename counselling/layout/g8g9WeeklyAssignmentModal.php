<div class="modal fade modal-primary" id="weeklyAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px">
    <div class="modal-content">
      <div class="card card-plain">
        <div class="modal-header justify-content-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="modal-close-icon">&times;</span>
          </button>

          <div class="header header-primary text-center">
            <h4>Course & Grade</h4>
          </div>
        </div>
        <div class="modal-body">
          <div class="card-body scroll">
            <div class="table-responsive">
              <table id="wa-mycourses" class="table table-hover" width="100%">
                <thead class="text-warning text-center">
                  <tr>
                    <th>Course</th>
                    <th>WA</th>
                    <th><span class="material-icons">done</span></th>
                    <th><span class="material-icons">clear</span></th>
                    <th><span class="material-icons">not_interested</span></th>
                    <th>Percent Grade</th>
                    <th>Letter Grade</th>
                    <th>Credit</th>
                    <th>Teacher</th>
                    <th>Room</th>
                    <th>Late</th>
                    <th>Absence</th>
                  </tr>
                </thead>
                <tbody class="text-center">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer text-center">
          <button type="button" class="btn btn-fill btn-default btn-sm" id="waModal-close-btn">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click",".waDetailLink",function (event) {
      var target = $(event.target);
      var dataid = target.attr("data-id");
      $('#waDetailModal-subjId').val(dataid);
    });
</script>
