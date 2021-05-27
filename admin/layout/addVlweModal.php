<!-- Modal for School Activity Detail(on Browse School Activities) -->
<div class="modal fade modal-primary" id="addVlweModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Add Volunteer & Work Experience Hours</h4>
                        <label class="addVlweMdl-term">
                            <?=$_SESSION["SemesterName"]?></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="addVlweMdlValidation" action="" method="">
                            <table id="addVlweMdl-table" class="table modal-table" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>Student</td>
                                        <td class="row">
                                            <div class="col-md-5 col-sm-12" style="padding:0px;">
                                                <input type="text" class="form-control" id="addVlweMdl-student"
                                                    name="student">
                                            </div>
                                            <div class="col-md-7 col-sm-12" style="padding:0px;">
                                                <div>
                                                    <button type="button"
                                                        class="btn btn-fill btn-info btn-sm material-icons"
                                                        id="vlwe-search-stu-btn" data-toggle="modal">
                                                        search
                                                    </button>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student ID</td>
                                        <td>
                                            <input type="text" class="form-control" id="addVlweMdl-studentId"
                                                name="studentId" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Title</td>
                                        <td>
                                            <input type="text" class="form-control" id="addVlweMdl-title" name="title">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            <textarea id="addVlweMdl-description" name="description" rows="5"
                                                class="md-textarea form-control"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>VLWE</td>
                                    </tr>
                                    <tr>
                                        <td>VLWE</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="row custom-row">
                                                    <div class="form-check-radio col-md-2">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input addVlweMdl-vlwe" type="radio"
                                                                name="vlwe-vlwe-by-staff" id="" value="1"
                                                                autocomplete="off" checked="true" disabled>
                                                            <div class="radio-label">Yes</div>
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check-radio col-md-2">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input addVlweMdl-vlwe" type="radio"
                                                                name="vlwe-vlwe-by-staff" id="" value="0"
                                                                autocomplete="off" disabled>
                                                            <div class="radio-label">No</div>
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td>
                                            <input type="text" class="form-control" id="addVlweMdl-location"
                                                name="location">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>
                                            <input type="text" class="form-control datetimepicker"
                                                data-date-format="YYYY-MM-DD hh:mm A" name="date" id="addVlweMdl-date">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hours</td>
                                        <td>
                                            <input type="number" class="form-control" id="addVlweMdl-hours" name="hours"
                                                step=".1" min="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>VLWE Supervisor</td>
                                        <td>
                                            <input type="text" class="form-control" id="addVlweMdl-supervisor"
                                                name="supervisor">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Approver Staff</td>
                                        <td>
                                            <select id="addVlweMdl-apprStaff" class="form-control" name="staff1">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Comment</td>
                                        <td>
                                            <textarea id="addVlweMdl-comment" name="comment" rows="5"
                                                class="md-textarea form-control"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-right addVlweMdl-btn-group">
                                    <button type="button" class="btn btn-fill btn-info btn-sm"
                                        id="addVlweMdl-add-btn">Add</button>
                                    <button type="button" class="btn btn-fill btn-default btn-sm"
                                        id="addVlweMdl-cancel-btn">Close</button>
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
        ajaxtoApprovalList('#addVlweMdl-apprStaff');
    });
</script>