<!-- Modal for School Activity Detail(on Browse School Activities) -->
<div class="modal fade modal-primary" id="addSelfSubmitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Add Self-Submit Hours (by Staff)</h4>
                        <label>
                            <?=$_SESSION["SemesterName"]?> - <?=$_SESSION['termStatus']?></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="addSubmitMdlValidation" action="" method="">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-student">Search Student<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control" id="addSubmitMdl-student"
                                            name="student">
                                    </div>
                                </div>
                                <div class="col-md-1" style="padding:0px;">
                                    <div>
                                        <button type="button" class="btn btn-fill btn-info btn-sm material-icons"
                                            id="submit-search-stu-btn" data-toggle="modal">
                                            search
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label for="addSubmitMdl-studentId">Student ID<span class="color-red mg-lr-5">*</span></label> -->
                            <input type="hidden" class="form-control" id="addSubmitMdl-studentId" name="studentId"
                                readonly>
                            <!-- </div> -->

                            <div class="form-group">
                                <label for="addSubmitMdl-title">Activity Name
                                    (e.g. Volunteering to plant trees, Working out, etc.)<span
                                        class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" id="addSubmitMdl-title" name="title">
                            </div>


                            <div class="form-group">
                                <label for="addSubmitMdl-category">Activity Category<span
                                        class="color-red mg-lr-5">*</span></label>
                                <select id="addSubmitMdl-category" class="form-control" name="category">
                                    <!-- <option value="10">PORE</option>
                                    <option value="11">AISD</option>
                                    <option value="12">CILE</option>
                                    <option value="13">ACLE</option> -->
                                </select>
                            </div>

                            <div class="form-group dispVLWERadio">
                                <label>Qualifies for Career Exploration hours?
                                    (i.e. Volunteer hours)<span class="color-red mg-lr-5">*</span></label>
                                <div class="row custom-row">
                                    <div class="form-check-radio col-md-2">
                                        <label class="form-check-label">
                                            <input class="form-check-input addSubmitMdl-vlwe" type="radio" name="vlwe"
                                                id="" value="1" autocomplete="off">
                                            <div class="radio-label">Yes</div>
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                    <div class="form-check-radio col-md-2">
                                        <label class="form-check-label">
                                            <input class="form-check-input addSubmitMdl-vlwe" type="radio" name="vlwe"
                                                id="" value="0" checked>
                                            <div class="radio-label">No</div>
                                            <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="addSubmitMdl-location">Location (e.g. Heywood Park, Genesis Gym, etc.)<span
                                        class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" id="addSubmitMdl-location" name="location">
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-sDate">Start Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker maxWidth-250" data-date-format="YYYY-MM-DD"
                                            name="sDate" id="addSubmitMdl-sDate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-eDate">End Date<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control datepicker maxWidth-250" data-date-format="YYYY-MM-DD"
                                            name="eDate" id="addSubmitMdl-eDate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-hours">Total number of hours<span
                                                class="color-red mg-lr-5">*</span></label>
                                        <!-- <input type="number" class="form-control" id="addSubmitMdl-hours" name="hours"
                                            step=".5" min="0"> -->
                                        <select name="hours" id="addSubmitMdl-hours" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- <td>Witness</td>
                                <td>
                                    <input type="text" class="form-control" id="addSubmitMdl-witness" name="witness">
                                </td>
                            </tr> -->

                            <div class="form-group">
                                <label for="addSubmitMdl-apprStaff">Approver Staff (Choose the Staff Member who can
                                    best check and approve this submission.)
                                    <span class="color-red mg-lr-5">*</span></label>
                                <select id="addSubmitMdl-apprStaff" class="form-control" name="staff1">
                                    <option value="">Select..</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label for="addSubmitMdl-approverPic">Approver Picture</label><br />
                                    <div class="frame-approverPic text-center">
                                        <img src="../img/user.png" alt="approverPic"
                                            id="addSubmitMdl-approverPic" src="" onerror="this.src='../img/user.png'"
                                            class="img-m">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="addSubmitMdl-comment1">Comment</label>
                                        <textarea id="addSubmitMdl-comment1" name="comment1" rows="5"
                                            class="md-textarea form-control" style="height: 100px;" placeholder=""
                                            maxlength="1000"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="addSubmitMdl-comment2" name="comment2" rows="5"
                                            class="md-textarea form-control" style="height: 100px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="addSubmitMdl-comment3" name="comment3" rows="5"
                                            class="md-textarea form-control" style="height: 100px;"
                                            maxlength="1000"></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 text-right addSubmitMdl-btn-group">
                                    <button type="button" class="btn btn-fill btn-info btn-sm"
                                        id="addSubmitMdl-add-btn">Submit</button>
                                    <button type="button" class="btn btn-fill btn-danger btn-sm"
                                        id="addSubmitMdl-cancel-btn">Cancel</button>
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
  include_once('layout/searchStudentModal.html');
?>
<script>
    $(document).ready(function () {
        ajaxtoApprovalListSATE('#addSubmitMdl-apprStaff');
        generateSelector('#addSubmitMdl-category', activityCategory, activityCategoryVal, 'none', '');
        $('.add-sSubmit-btn').click(function (params) {
            $("#addSubmitMdl-apprStaff").val("<?=$_SESSION['staffId']?>").change(); 
        });

        var comment1 = "Describe in detail what you did on this activity or your duties\n" +
            "(e.g., I helped to dig holes in the ground and plant trees at the park, I performed my upper body exercise circuit, etc.)";
        $('#addSubmitMdl-comment1').prop('placeholder', comment1);

        var comment2 =
            "Describe what skills you practiced or learned, and how you can use these skills in the future.";
        $('#addSubmitMdl-comment2').prop('placeholder', comment2);

        var comment3 = "Your event supervisor name and contact info.\n" +
            "(if this does not apply, write ‘N/A’)";
        $('#addSubmitMdl-comment3').prop('placeholder', comment3);


        // $('#addSubmitMdl-category').change(function (params) {
        //     console.log($('#addSubmitMdl-category').val());
        //     if ($('#addSubmitMdl-category').val() == 12) {
        //         $('.dispVLWERadio').css('display', 'block')
        //     } else {
        //         $('.dispVLWERadio').css('display', 'none');
        //         $("input[name='vlwe'][value='0']").prop("checked", true);
        //     }
        // })

        var hoursOpt = "<option value=''>Select..</option>";
        var num;
        for (let i = 0.5; i <= 24; i += 0.5) {
            num = i.toFixed(1)
            hoursOpt += "<option value=" + num + ">" + num + "</option>"
        }
        $('#addSubmitMdl-hours').append(hoursOpt);
    });
</script>
