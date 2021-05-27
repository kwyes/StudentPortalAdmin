<div class="modal fade modal-primary" id="selfAssessmentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="card card-login card-plain">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="modal-close-icon">&times;</span>
                    </button>


                    <div class="header header-primary text-center">
                        <h4>Self Assessment</h4>
                        <p>Name : <span class="studentName"></span></p>
                        <p>Grade : <span class="grade"></span></p>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                      <input type="hidden" id="AssessmentID" name="" value="">
                      <div class="selfAssessments-wrapper table-responsive">

                      </div>
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

    });
</script>
<style media="screen">
.modal-dialog {
width: 100%;
height: 100%;
margin: 0;
padding: 0;
}

.modal-content {
height: auto;
min-height: 100%;
border-radius: 0;
}
.selfAssessments-wrapper img {
  width:auto !important;
}

</style>
