<div class="modal fade modal-primary" id="waPopulateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="card card-plain">
        <div class="modal-header justify-content-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="modal-close-icon">&times;</span>
          </button>

          <div class="header header-primary text-center">
            <h4>Enter Assignment title</h4>
          </div>
        </div>
        <div class="modal-body">
          <div class="row flexContentCenter">
            <div class="col-md-6">
              <label>Assignment Title</label>
              <input type="text" id="waTitle" name="" value="" class="form-control custom-form">
            </div>
            <div class="col-md-3">
              <label>Assignment #</label>
              <select class="seq-title form-control custom-form" name="">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
          </div>
          <div class="modal-footer text-center">
            <button type="button" id="waSave" name="button" class="btn btn-fill btn-info btn-sm">SAVE</button>
            <button type="button" id="waPopulateModal-close-btn" class="btn btn-fill btn-default btn-sm">CLOSE</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $("#waSave").click(function () {
      var title = $('#waTitle').val();
      var seq = $('.seq-title').val();
      $('.wa-check-'+seq).prop('checked', true);

      jQuery("input[name=wAssignment"+seq+"]").val('');
      jQuery("input[name=wAssignment"+seq+"]").val(title);
      changeBtnClass("#btn-bogs-wassignment-save", "btn-info", "btn-primary");
      $('#waPopulateModal').modal('toggle');
    });
  });
</script>
