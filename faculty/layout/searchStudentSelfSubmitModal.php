<!-- Modal for School Activity Detail(on Browse School Activities) -->
<div class="modal fade modal-primary" id="sStudentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Edit Self-Submit Hours (by Staff)</h4>
                        <label class="sStudentMdl-term"></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="sStudentMdlValidation" action="" method="">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sStudentMdl-student-img">Student Picture</label><br />
                                        <div class="text-center">
                                            <img src="../img/user.png" alt="student-img" id="sStudentMdl-student-img"
                                                onerror="this.src='../img/user.png'" class="img-m">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sStudentMdl-studentId">Student ID</label>
                                        <input type="text" class="form-control" id="sStudentMdl-studentId"
                                            name="studentId" disabled>
                                        <input type="hidden" id="sStudentMdl-studentId-hidden" name="studentId"
                                            value="">
                                        <input type="hidden" id="sStudentMdl-studentActivityId-hidden"
                                            name="studentActivityId" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="sStudentMdl-student-name">Student</label>
                                        <input type="text" class="form-control" id="sStudentMdl-student-name"
                                            name="student" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sStudentMdl-approverPic">Approver Picture</label><br />
                                        <div class="text-center">
                                            <img src="../img/user.png" alt="approverPic" id="sStudentMdl-approverPic"
                                                onerror="this.src='../img/user.png'" class="img-m">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sStudentMdl-apprStaff">Approver Staff<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <select id="sStudentMdl-apprStaff" class="form-control select-self-advisiorList"
                                            name="staff1" onchange="getFullStaffName('sStudentMdl-apprStaff')">

                                        </select>
                                        <input type="hidden" id="sStudentMdl-apprStaff-FullName" name="StaffFullName"
                                            value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="sStudentMdl-status">Status</label>
                                        <input type="hidden" id="sStudentMdl-preStatus-hidden" name="preStatus"
                                            value="">
                                        <select id="sStudentMdl-status" class="form-control" name="status"></select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="sStudentMdl-title">Activity Name<span
                                        class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" id="sStudentMdl-title" name="title">
                            </div>

                            <div class="form-group">
                                <label for="sStudentMdl-category">Activity Category
                                    <span class="color-red mg-lr-5">*</span></label>
                                <select id="sStudentMdl-category" class="form-control" name="category">
                                    <!-- <option value="10">PORE</option>
                                    <option value="11">AISD</option>
                                    <option value="12">CILE</option>
                                    <option value="13">ACLE</option> -->
                                    <!-- <option value="21">VLWE</option> -->
                                </select>
                            </div>

                            <div class="form-group dispVLWERadio">
                                <label>Qualifies for Career Exploration hours?<span
                                        class="color-red mg-lr-5">*</span></label>
                                <div class="row custom-row">
                                    <div class="form-check-radio col-md-2">
                                        <label class="form-check-label">
                                            <input id="sStudentMdl-vlwe-y" class="form-check-input sStudentMdl-vlwe"
                                                type="radio" name="vlwe" id="" value="1" autocomplete="off">
                                            <div class="radio-label">Yes</div>
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio col-md-2">
                                        <label class="form-check-label">
                                            <input id="sStudentMdl-vlwe-n" class="form-check-input sStudentMdl-vlwe"
                                                type="radio" name="vlwe" id="" value="0" autocomplete="off">
                                            <div class="radio-label">No</div>
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sStudentMdl-location">Location (e.g. Heywood Park, Genesis Gym, etc.)
                                    <span class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" id="sStudentMdl-location" name="location">
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sStudentMdl-date">Start Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker sStudentMdl-sDate maxWidth-250" data-date-format="YYYY-MM-DD"
                                            name="sDate" id="sStudentMdl-sDate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sStudentMdl-date">End Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker sStudentMdl-sDate maxWidth-250" data-date-format="YYYY-MM-DD"
                                            name="eDate" id="sStudentMdl-eDate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sStudentMdl-hours">Hours<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <!-- <input type="number" class="form-control" id="sStudentMdl-hours" name="hours"
                                            step=".5" min="0"> -->
                                        <select name="hours" id="sStudentMdl-hours" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-stuComment1">Student Comment</label>
                                        <textarea id="sStudentMdl-stuComment1" name="comment1" rows="5"
                                            class="md-textarea form-control" style="height: 100px;" placeholder=""
                                            maxlength="1000"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="sStudentMdl-stuComment2" name="comment2" rows="5"
                                            class="md-textarea form-control" style="height: 100px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="sStudentMdl-stuComment3" name="comment3" rows="5"
                                            class="md-textarea form-control" style="height: 100px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sStudentMdl-aprComment">Approver Comment<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <textarea id="sStudentMdl-aprComment" name="comment" rows="5"
                                            class="md-textarea form-control" style="height: 336px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right sStudentMdl-btn-group">
                                    <button type="button" class="btn btn-fill btn-info btn-sm"
                                        id="sStudentMdl-edit-btn">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-fill btn-danger btn-sm"
                                        id="sStudentMdl-cancel-btn">Cancel</button>
                                </div>
                                <!-- <div class="col-md-12 text-center">
                                    <div class="text-left" style="display:inline-block;">
                                        <label id="sStudentMdl-modifiedBy"></label><br />
                                        <label id="sStudentMdl-createdBy"></label>
                                    </div>
                                </div> -->
                            </div>
                            <div class="text-center">
                                <div class="text-left" style="display:inline-block;">
                                    <label style="width:100px">Last modified at </label><label
                                        id="sStudentMdl-modifiedBy"></label><br />
                                    <label style="width:100px">Created at </label><label
                                        id="sStudentMdl-createdBy"></label>
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
<?php
  include_once('layout/spinner.html');
?>
<script>
    $(document).ready(function () {
        ajaxtoApprovalList('.select-self-advisiorList');
        generateSelector('#sStudentMdl-category', activityCategory, activityCategoryVal, 'none', '');
        generateSelector('#sStudentMdl-status', activityStatus, activityStatusVal, 10, '');

        var comment = "Enter comment when hours are rejected"
        $('#sStudentMdl-comment').prop('placeholder', comment);

        var comment1 = "Describe in detail what you did on this activity or your duties\n" +
            "(e.g., I helped to dig holes in the ground and plant trees at the park, I performed my upper body exercise circuit, etc.)";
        $('#sStudentMdl-comment1').prop('placeholder', comment1);

        var comment2 =
            "Describe what skills you practiced or learned, and how you can use these skills in the future.";
        $('#sStudentMdl-comment2').prop('placeholder', comment2);

        var comment3 = "Your event supervisor name and contact info.\n" +
            "(if this does not apply, write ???N/A???)";
        $('#sStudentMdl-comment3').prop('placeholder', comment3);

        var hoursOpt = "<option value=''>Select..</option>";
        var num;
        for (let i = 0.5; i <= 24; i += 0.5) {
            num = i.toFixed(1)
            hoursOpt += "<option value=" + num + ">" + num + "</option>"
        }
        $('#sStudentMdl-hours').append(hoursOpt);
    });
</script>