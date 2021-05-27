<!-- Modal for School Activity Detail(on Browse School Activities) -->
<div class="modal fade modal-primary" id="leaveRequestMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Leave Request Detail</h4>
                        <label><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="leaveRequestMdlValidation" action="" method="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-student-img">Student Picture</label><br />
                                        <div class="text-center">
                                            <img src="../img/user.png" alt="student-img" id="leaveRequestMdl-student-img"
                                                onerror="this.src='../img/user.png'" class="img-m">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-studentId">Student ID</label>
                                        <input type="text" class="form-control" id="leaveRequestMdl-studentId"
                                            name="studentId" disabled>
                                        <input type="hidden" id="leaveRequestMdl-studentId-hidden" name="studentId" value="">
                                        <input type="hidden" id="leaveRequestMdl-leaveId-hidden"
                                            name="LeaveID" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-student-name">Student</label>
                                        <input type="text" class="form-control" id="leaveRequestMdl-student-name"
                                            name="student" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-approverPic">Approver Picture</label><br />
                                        <div class="text-center">
                                            <img src="../img/user.png" alt="approverPic" id="leaveRequestMdl-approverPic"
                                                onerror="this.src='../img/user.png'" class="img-m">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="leaveRequestMdl-apprStaff">Approver Staff<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <select id="leaveRequestMdl-apprStaff" class="form-control ApprovalList"
                                            name="staff1" onchange="">

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="leaveRequestMdl-status">Status</label>
                                        <select id="leaveRequestMdl-status" class="form-control" name="status">
                                          <option value="P">Pending</option>
                                          <option value="R">Rejected</option>
                                          <option value="A">Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-date">Start Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker leaveRequestMdlDateV2" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                            name="sDate" id="leaveRequestMdl-sDate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-date">End Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker leaveRequestMdlDateV2" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                            name="eDate" id="leaveRequestMdl-eDate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-Reason">Reason</label>
                                        <select id="leaveRequestMdl-Reason" class="form-control" name="Reason">
                                           <option value="Necessary appointments (doctor, bank, counsellor, etc)">Necessary appointments (doctor, bank, counsellor, etc)</option>
                                           <option value="Outdoor exercise (run, bike, walk, etc)">Outdoor exercise (run, bike, walk, etc)</option>
                                           <option value="Essential items  pick-up (medicine, nutritional supplements, etc)">Essential items  pick-up (medicine, nutritional supplements, etc)</option>
                                           <option value="Weekend Pass">Weekend Pass</option>
                                           <option value="Weekday Pass">Weekday Pass</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="leaveRequestMdl-ToDo">Campus leave details</label>
                                        <textarea id="leaveRequestMdl-ToDo" name="ToDo" rows="5"
                                            class="md-textarea form-control" style="height: 257px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leaveRequestMdl-Comment">Student Comment<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <textarea id="leaveRequestMdl-Comment" name="comment" rows="5"
                                            class="md-textarea form-control" style="height: 146px;"
                                            maxlength="1000"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="leaveRequestMdl-stfComment">Staff Comment<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <textarea id="leaveRequestMdl-stfComment" name="stfcomment" rows="5"
                                            class="md-textarea form-control" style="height: 146px;"
                                            maxlength="1000"></textarea>
                                    </div>

                                </div>
                            </div>



                            <div class="row">
                              <div class="col-md-6">
                                <div class="input-group">
                                  <label for="leaveRequestMdl-date">Out Date/Time<span
                                    class="color-red mg-lr-5">*</span></label>
                                    <input type="text" class="form-control leaveRequestMdlDate" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                    name="OutDate" id="leaveRequestMdl-OutDate">
                                    <span class="input-group-addon OutDateToday"><i class="material-icons-outlined">alarm</i></span>

                                  </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label for="leaveRequestMdl-date">In Date/Time<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control leaveRequestMdlDate" data-date-format="YYYY-MM-DD hh:mm:ss a"
                                            name="InDate" id="leaveRequestMdl-InDate">
                                        <span class="input-group-addon InDateToday"><i class="material-icons-outlined">alarm</i></span>

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 text-right leaveRequestMdl-btn-group">
                                    <button type="button" class="btn btn-fill btn-info btn-sm" id="leaveRequestMdl-edit-btn">
                                        Save
                                    </button>
                                    <!-- <button type="button" class="btn btn-fill btn-info"
                                        id="leaveRequestMdl-approve-btn">Approve</button>
                                    <button type="button" class="btn btn-fill btn-danger"
                                        id="leaveRequestMdl-rej-btn">Reject</button> -->
                                    <button type="button" class="btn btn-fill btn-danger btn-sm"
                                        id="leaveRequestMdl-cancel-btn" data-dismiss="modal">Cancel</button>
                                </div>
                                <!-- <div class="col-md-12 text-center">
                                    <div class="text-left" style="display:inline-block;">
                                        <label id="leaveRequestMdl-modifiedBy"></label><br />
                                        <label id="leaveRequestMdl-createdBy"></label>
                                    </div>
                                </div> -->
                            </div>
                            <div class="text-center">
                                <div class="text-left" style="display:inline-block;">
                                    <label style="width:100px">Last modified at </label><label
                                        id="leaveRequestMdl-modifiedBy"></label><br />
                                    <label style="width:100px">Created at </label><label
                                        id="leaveRequestMdl-createdBy"></label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
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




      $('#leaveRequestMdl-OutDate').datetimepicker({
           // defaultDate: moment(),
           // useCurrent:true,
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

       $('#leaveRequestMdl-InDate').datetimepicker({
            // defaultDate: moment(),
            // minDate:moment(),
            // useCurrent:true,
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

         $('.InDateToday').click(function(event) {
            $('#leaveRequestMdl-InDate').val(moment().format('YYYY-MM-DD hh:mm:ss a'));
         });

         $('.OutDateToday').click(function(event) {
           $('#leaveRequestMdl-OutDate').val(moment().format('YYYY-MM-DD hh:mm:ss a'));
         });

       $(".leaveRequestMdlDate").attr("readonly", "readonly");
       $(".leaveRequestMdlDateV2").attr("readonly", "readonly");

        // ajaxtoApprovalList('#leaveRequestMdl-apprStaff');
    });
</script>
<style media="screen">
  .OutDateToday, .InDateToday{
    cursor: pointer;
  }
</style>
