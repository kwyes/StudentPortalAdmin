<div class="modal" id="transcriptRequestModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-login card-plain">
        <div class="modal-header justify-content-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="modal-close-icon">&times;</span>
          </button>
          <div class="header header-primary text-center">
            <h4>Transcript Request Form</h4>
          </div>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div class="text-right font-italic"><label></label></div>
            <form id="transcriptRequestForm" class="needs-validation" novalidate>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="transcriptRequestModal-student-img">Student Picture</label><br />
                      <div class="text-center">
                          <img src="../img/user.png" alt="student-img" id="transcriptRequestModal-student-img"
                              onerror="this.src='../img/user.png'" class="img-m">
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="studentID">Student ID</label>
                    <input type="text" class="form-control" name="studentID"
                      id="studentID">
                      <input type="hidden" class="form-control" name="RequestID"
                        id="RequestID">
                  </div>
                  <div class="form-group">
                    <label for="requestDate">Student Name</label>
                    <input type="text" class="form-control" name="studentName"
                      id="studentName">
                  </div>

                  <div class="form-group">
                    <label for="requestDate">Request Date <span class="color-red">*</span></label>
                    <input type="text" class="form-control datepicker" data-date-format="YYYY-MM-DD" name="requestDate"
                      id="requestDate" required onkeydown="return false">
                  </div>
                  <div class="form-group">
                    <label for="deadLine">Deadline to upload transcript <span class="color-red">*</span></label>
                    <input type="text" class="form-control datepicker" data-date-format="YYYY-MM-DD" name="deadLine"
                      id="deadLine" onkeydown="return false" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="copy-type">Is this a first copy you are requesting?</label>

                    <div class="row custom-row">
                      <div class="form-check-radio col-md-3">
                        <label class="form-check-label">
                          <input class="form-check-input copy-type" type="radio" name="copytype" id="copytype-in" value="First Copy"
                            autocomplete="off" >
                          First Copy
                          <span class="form-check-sign"></span>

                        </label>
                      </div>
                      <div class="form-check-radio col-md-3">
                        <label class="form-check-label">
                          <input class="form-check-input copy-type" type="radio" name="copytype" id="copytype-up" value="Updated Copy">
                          Updated Copy
                          <span class="form-check-sign"></span>
                        </label>
                      </div>
                    </div>

              </div>


              <div class="form-group">
                <label for="aplicationNumber">You are applying to</label>
                  <input type="text" class="form-control" name="applyTo"
                    id="applyTo">

              </div>

              <div class="form-group">
                <label for="physical-copy">Do you request a copy to send to University?</label>
                <div class="row custom-row">
                  <div class="form-check-radio col-md-3">
                    <label class="form-check-label">
                      <input class="form-check-input physical-copy" type="radio" name="physicalcopy" id="physicalcopy-y" value="Y"
                        autocomplete="off">
                      Yes
                      <span class="form-check-sign"></span>
                    </label>
                  </div>
                  <div class="form-check-radio col-md-3">
                    <label class="form-check-label">
                      <input class="form-check-input physical-copy" type="radio" name="physicalcopy" id="physicalcopy-n" value="N">
                      No
                      <span class="form-check-sign"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="physicalCopy-extra">
                <div class="form-group">
                  <label for="aplicationNumber">Application Number
                    </label>
                  <input type="text" class="form-control" name="ApplicationNumber" id="aplicationNumber">
                </div>

                <div class="form-group">
                  <label for="aplicationNumber">University Name
                    </label>
                  <input type="text" class="form-control" name="UniversityName" id="UniversityName">
                </div>

                <div class="form-group">
                  <label for="aplicationNumber">Address
                    </label>
                  <input type="text" class="form-control" name="Address" id="Address">
                </div>

                <div class="form-group">
                  <label for="mailingmethod">Mailing Method</label>
                    <div class="form-check-radio">
                      <label class="form-check-label">
                        <input class="form-check-input mailingMethod" type="radio" name="mailingMethod" id="" value="CanadaPost" required>
                        Canada Post
                        <span class="form-check-sign"></span>
                      </label>
                    </div>
                    <div class="form-check-radio">
                      <label class="form-check-label">
                        <input class="form-check-input mailingMethod" type="radio" name="mailingMethod" id="" value="Courier" required>
                        Courier
                        <span class="form-check-sign"></span>
                      </label>
                    </div>
                    <div class="form-check-radio">
                      <label class="form-check-label">
                        <input class="form-check-input mailingMethod" type="radio" name="mailingMethod" id="" value="pickup" required>
                        Pick up at the front office
                        <span class="form-check-sign"></span>
                      </label>
                    </div>
                    <div class="form-check-radio">
                      <label class="form-check-label">
                        <input class="form-check-input mailingMethod" type="radio" name="mailingMethod" id="" value="Email" required>
                        Email
                        <span class="form-check-sign"></span>
                      </label>
                    </div>
                </div>
                
              </div>




              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="transcriptRequestModal-paid">Paid</label>
                      <select id="transcriptRequestModal-paid" class="form-control" name="paid">
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                      </select>
                      <span class="material-input"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="transcriptRequestModal-status">Status</label>
                      <input type="hidden" id="transcriptRequestModal-preStatus-hidden" name="preStatus" value="" autocomplete="off">
                      <select id="transcriptRequestModal-status" class="form-control" name="status">
                          <option value="P">Pending</option>
                          <option value="C">Canceled</option>
                          <option value="D">Done</option>
                      </select>
                      <span class="material-input"></span>
                  </div>
                </div>
              </div>



            </form>
          </div>

          <div class="modal-footer text-center">
            <button type="button" class="btn btn-success custom-btn" id="transcript-save-btn">Save</button>
            <button type="reset" class="btn btn-default custom-btn" id="transcript-cancel-btn" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      dateTimePicker();
      $('#transcript-save-btn').click(function(event) {
        $("#transcriptRequestForm input").prop("disabled", false);

        var transcriptRequestForm = $("#transcriptRequestForm").serializeArray();
        var transcriptRequestFormObject = {};
        $.each(transcriptRequestForm, function (i, v) {
          transcriptRequestFormObject[v.name] = v.value;
        });
        console.log(transcriptRequestFormObject);
        saveTranscriptRequest(transcriptRequestFormObject);
      });
    });
  </script>
