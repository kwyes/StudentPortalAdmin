<div class="modal fade modal-primary" id="AddCareerLifeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-login modal-lg">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>
                    <div class="header header-primary text-center">
                        <h4>Career Life Pathway Self-Submit (By Staff)</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="text-right font-italic"><label><span class="color-red mg-lr-5">*</span> =
                                Required</label>
                        </div>
                        <form id="form-addCareerLifeModal" action="" method="">
                            <input type="hidden" id="hidden-semesterId" name='semesterId'>
                            <div class="row row-eq-height">
                                <div class="col-md-8">
                                    <div class="row row-eq-height">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="addCareer-searchStu">Search Student</label>
                                                <input type="text" class="form-control" id="addCareer-searchStu"
                                                    name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <button type="button"
                                                    class="btn btn-fill btn-info btn-sm material-icons"
                                                    id="addCareer-searchStuBtn" data-toggle="modal">
                                                    search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="addCareer-studentId">Student ID</label>
                                                <input type="text" class="form-control" id="addCareer-studentId"
                                                    name="studentId" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="addCareer-studentPic">Student Picture</label><br />
                                    <div class="frame-approverPic text-center">
                                        <img src="../img/user.png" alt="studentPic" id="addCareer-studentPic"
                                            onerror="this.src='../img/user.png'" class="img-m">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="addCareer-course">Course (Teacher)
                                    <span class="color-red mg-lr-5">*</span></label>
                                <select name="course" id="addCareer-course" class="form-control" required disabled>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="addCareer-topic">Capstone Topic <span
                                        class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" name="topic" id="addCareer-topic"
                                    maxlength="120" required>
                            </div>

                            <div class="form-group">
                                <label for="addCareer-capCategory">Capstone Category
                                    <span class="color-red mg-lr-5">*</span></label>
                                <select name="capCategory" id="addCareer-capCategory" class="form-control" required>
                                </select>
                            </div>

                            <div class="form-group mg-b-8">
                                <input type="hidden" class="form-control" name="other" id="addCareer-capCategory-other"
                                    maxlength="100" required>
                            </div>


                            <label>Capstone Career Guide</label>
                            <div class="row custom-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addCareer-guide-fName">First Name <span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control" name="firstName"
                                            id="addCareer-guide-fName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addCareer-guide-lName">Last Name <span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="text" class="form-control" name="lastName"
                                            id="addCareer-guide-lName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row custom-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addCareer-guide-email">E-mail <span
                                                class="color-red mg-lr-5">*</span></label>
                                        <input type="email" class="form-control" name="email" id="addCareer-guide-email"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addCareer-guide-phone">Phone Number</label>
                                        <input type="text" class="form-control" name="phone"
                                            pattern="^\d{3}-\d{3}-\d{4}$" id="addCareer-guide-phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addCareer-guide-position">Position Title <span
                                        class="color-red mg-lr-5">*</span></label>
                                <input type="text" class="form-control" name="position" id="addCareer-guide-position"
                                    placeholder="e.g., Bodwell staff, work for City Center, etc." required>
                            </div>
                            <div class="form-group">
                                <label for="addCareer-description">Capstone Brief Description <span
                                        class="color-red mg-lr-5">*</span></label>
                                <textarea class="form-control" name="description" id="addCareer-description" rows="10"
                                    maxlength="1000" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-info custom-btn btn-sm"
                                        id="addCareer-submit-btn">Submit</button>
                                    <button type="reset" class="btn btn-default custom-btn btn-sm"
                                        id="addCareer-cancel-btn">Cancel</button>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  include_once('layout/searchStudentModal_career.html');
  include_once('layout/spinner.html');
?>
<script type="text/javascript">
    $(document).ready(function () {
        ajaxToGetListCareerSubejct('<?=$SemesterID?>', '#addCareer-course');
        generateSelector_v2('#addCareer-capCategory', capstoneCategory, '', '')

        $('#hidden-semesterId').val('<?=$SemesterID?>');

        $('#addCareer-capCategory').change(function (event) {
            if ($('#addCareer-capCategory').val() == 'Other (Specify below)') {
                $('#addCareer-capCategory-other').prop('type', 'text');
            } else {
                $('#addCareer-capCategory-other').val('')
                $('#addCareer-capCategory-other').prop('type', 'hidden');
            }

        });

        $('#addCareer-guide-phone').keyup(function (e) {
            var regex1 = RegExp('[0-9]')
            var regex2 = RegExp('[a-zA-Z]{2}')
            if (regex1.test(e.key) || regex2.test(e.key)) {
                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3').slice(0,
                    12))
            } else {
                var len = $(this).val().length;
                $(this).val($(this).val().slice(0, len - 1))
            }
        });

    });
</script>