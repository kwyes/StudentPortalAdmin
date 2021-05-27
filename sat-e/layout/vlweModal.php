<!-- Modal for School Activity Detail(on Browse School Activities) -->
<div class="modal fade modal-primary" id="vlweModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Self-Submit Hours Detail</h4>
                        <label class="vlweMdl-term"></label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="vlweMdlValidation" action="" method="">
                            <table id="vlweMdl-table" class="table modal-table" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>Student</td>
                                        <td>
                                            <img src="../img/user.png" alt="student-img" id="vlweMdl-student-img"
                                                onerror="this.src='../img/user.png'">
                                            <div id="vlweMdl-student-name">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student ID</td>
                                        <td>
                                            <span id="vlweMdl-studentId"></span>
                                            <input type="hidden" id="vlweMdl-studentId-hidden" name="studentId"
                                                value="">
                                            <input type="hidden" id="vlweMdl-studentActivityId-hidden"
                                                name="studentActivityId" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Title</td>
                                        <td>
                                            <input type="text" class="form-control" id="vlweMdl-title" name="title">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            <textarea id="vlweMdl-description" name="description" rows="5"
                                                class="md-textarea form-control"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td name="category">VLWE</td>
                                    </tr>
                                    <tr>
                                        <td>VLWE</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="row custom-row">
                                                    <div class="form-check-radio col-md-2">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input vlweMdl-vlwe" type="radio"
                                                                name="vlwe" id="" value="1" autocomplete="off"
                                                                checked="true" disabled>
                                                            <div class="radio-label">Yes</div>
                                                            <span class="form-check-sign"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check-radio col-md-2">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input vlweMdl-vlwe" type="radio"
                                                                name="vlwe" id="" value="0" autocomplete="off" disabled>
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
                                            <input type="text" class="form-control" id="vlweMdl-location"
                                                name="location">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>
                                            <input type="text" class="form-control datetimepicker"
                                                data-date-format="YYYY-MM-DD hh:mm A" name="date" id="vlweMdl-date">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hours</td>
                                        <td>
                                            <input type="number" class="form-control" id="vlweMdl-hours" name="hours"
                                                step=".1" min="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>VLWE Supervisor</td>
                                        <td>
                                            <input type="text" class="form-control" id="vlweMdl-supervisor"
                                                name="supervisor">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Approver Staff</td>
                                        <td>
                                            <select id="vlweMdl-apprStaff" class="form-control select-self-advisiorList"
                                                name="staff1">

                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td id="vlweMdl-status">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Comment</td>
                                        <td>
                                            <textarea id="vlweMdl-comment" name="comment" rows="5"
                                                class="md-textarea form-control"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-right vlweMdl-btn-group">
                                    <button type="button" class="btn btn-fill btn-info"
                                        id="vlweMdl-edit-btn">Edit</button>
                                    <!-- <button type="button" class="btn btn-fill btn-info" id="vlweMdl-del-btn">Approve</button>
                                    <button type="button" class="btn btn-fill btn-danger" id="vlweMdl-del-btn">Reject</button> -->
                                    <button type="button" class="btn btn-fill btn-default"
                                        id="vlweMdl-cancel-btn">Close</button>
                                </div>
                                <div class="col-md-12 text-center">
                                    <label id="vlweMdl-modifiedBy">Last modified at 2018-12-02 16:38
                                        by Dana
                                        Ghareeb</label><br />
                                    <label id="vlweMdl-createdBy">Created at 2018-09-04 14:25 by
                                        Kieran
                                        Reynolds</label>
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
<script>
    $(document).ready(function () {
        ajaxtoApprovalList('.select-self-advisiorList');
    });
</script>