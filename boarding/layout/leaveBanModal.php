<div class="modal fade modal-primary" id="LeaveBanDetailMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Leave Ban Detail</h4>
                        <label><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="LeaveBanDetailMdlValidation" action="" method="">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="LeaveBanDetailMdl-student">Student ID</label>
                                        <input type="text" class="form-control resultStudentName" id="LeaveBanDetailMdl-studentName"
                                            name="studentName" readonly>
                                        <label for="LeaveBanDetailMdl-student">Student Name</label>
                                        <input type="text" class="form-control resultStudentId" id="LeaveBanDetailMdl-studentID"
                                            name="studentID" readonly>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="form-control resultBanID" id="LeaveBanDetailMdl-BanID" name="BanID"
                                readonly>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="LeaveBanDetailMdl-sDate">Start Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control leave-date-time" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                            name="sDate" id="LeaveBanDetailMdl-sDate">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="LeaveBanDetailMdl-eDate">End Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control leave-date-time" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                            name="eDate" id="LeaveBanDetailMdl-eDate">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <label for="LeaveBanDetailMdl-status">Status<span
                                              class="color-red mg-lr-5">*</span></label>
                                      <select id="LeaveBanDetailMdl-status" class="form-control" name="status">
                                          <option value="A">Active</option>
                                          <option value="C">Cancel</option>
                                      </select>
                                  </div>
                                </div>

                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="LeaveBanMdl-comment">Comment</label>
                                      <textarea id="LeaveBanMdl-comment" name="comment" rows="5"
                                          class="md-textarea form-control" style="height: 100px;" placeholder=""
                                          maxlength="1000"></textarea>
                                  </div>
                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer text-center">
                      <div class="row">
                          <div class="col-md-12 text-right LeaveBanDetailMdl-btn-group">
                              <button type="button" class="btn btn-fill btn-info btn-sm"
                                  id="LeaveBanDetailMdl-edit-btn">Save</button>
                              <button type="button" class="btn btn-fill btn-danger btn-sm"
                                  id="LeaveBanDetailMdl-cancel-btn" data-dismiss="modal">Cancel</button>
                          </div>
                      </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="mask">
    <div class="spinnerContainer">
        <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30">
            </circle>
        </svg>
    </div>
</div>
<script>
    $(document).ready(function () {
      $('#LeaveBanDetailMdl-sDate').datetimepicker({
           defaultDate: moment(),
           useCurrent:true,
           ignoreReadonly: true,
           icons: {
             time: "fa fa-clock-o",
             date: "fa fa-calendar",
             up: "fa fa-chevron-up",
             down: "fa fa-chevron-down",
             previous: "fa fa-chevron-left",
             next: "fa fa-chevron-right",
             today: "fa fa-screenshot",
             clear: "fa fa-trash",
             close: "fa fa-remove",
           },
       });

       $('#LeaveBanDetailMdl-eDate').datetimepicker({
            defaultDate: moment(),
            useCurrent:true,
            ignoreReadonly: true,
            icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down",
              previous: "fa fa-chevron-left",
              next: "fa fa-chevron-right",
              today: "fa fa-screenshot",
              clear: "fa fa-trash",
              close: "fa fa-remove",
            },
        });
       $(".leave-date-time").attr("readonly", "readonly");
    });
</script>
