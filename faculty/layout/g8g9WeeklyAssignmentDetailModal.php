<div class="modal fade modal-primary" id="weeklyAssignmentDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="card card-plain">
        <div class="modal-header justify-content-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="modal-close-icon">&times;</span>
          </button>

          <div class="header header-primary text-center">
            <h4>G8/G9 Weekly Assignment</h4>
          </div>
        </div>
        <div class="modal-body">
          <div class="row row-eq-height">
            <div class="col-lg-8 col-md-8 col-sm-6">
              <label class="mg-r-10">
                Term :
                <div class="select-container">
                  <select id="sSubmit-term-select" class="select-term form-control custom-form mg-lr-7">
                  </select>

                </div>
              </label>

              <label class="mg-r-10">
                Teacher :
                <div class="select-container">
                  <select name="staffLeader"
                    class="form-control custom-form mg-lr-7 width-200 ApprovalList">
                    <option value="">Select..</option>
                    <option value="all">All</option>
                  </select>
                </div>
              </label>

              <label class="mg-r-10">
                Course : 
                <div class="select-container">
                  <select name="courseList" class="form-control custom-form courseList mg-lr-7">
                  </select>
                </div>
              </label>

              <label class="mg-r-10">
                Week :
                <div class="select-container">
                  <input type='text' id='weeklyDatePicker3' class="form-control custom-form mg-lr-7 maxWidth-none datepicker" placeholder="Select Week" />
                </div>
              </label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 row">
              <div class="col-md-12 row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"><label><i class="material-icons font-12 color-red">clear</i></label></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><label>Incomplete</label></div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right"><label class="incomp-num">0</label></div>
              </div>
              <div class="col-md-12 row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"><label><i class="material-icons font-12 color-yellow">not_interested</i></label></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><label>Partially Complete</label></div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right"><label class="pComp-num">0</label></div>
              </div>
              <div class="col-md-12 row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center"><label><i class="material-icons font-12 color-blue">done</i></label></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><label>Complete</label></div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right"><label class="comp-num">0</label></div>
              </div><div class="col-md-12 row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><label>TOTAL</label></div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right"><label class="wa-total-num">0</label></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header ">
                  <div class="card-text">
                    <h4 class="card-title"><i class="material-icons-outlined card-icon">assignment_ind</i><span
                        class="dashboard-fullName"></span>
                    </h4>
                  </div>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img draggable="false" class="dashboard-userPic img-m" src="" onerror="this.src='../assets/img/student.png'" alt="">
                  </div>
                  <table class="table table-hover" id="student-inf">
                    <tbody>
                      <tr>
                        <td>Student ID</td>
                        <td class="dashboard-studentId"></td>
                      </tr>
                      <tr>
                        <td>PEN</td>
                        <td class="dashboard-pen"></td>
                      </tr>
                      <tr>
                        <td>Current Grade </td>
                        <td class="dashboard-grade"></td>
                      </tr>
                      <tr>
                        <td>Counsellor</td>
                        <td class="dashboard-Counsellor"></td>
                      </tr>
                      <tr>
                        <td>Living Location</td>
                        <td class="dashboard-location"></td>
                      </tr>
                      <tr>
                        <td>House</td>
                        <td class="dashboard-house"></td>
                      </tr>
                      <tr>
                        <td>Hall</td>
                        <td class="dashboard-hall"></td>
                      </tr>
                      <tr>
                        <td>Room No</td>
                        <td class="dashboard-room"></td>
                      </tr>
                      <tr>
                        <td>Youth Advisor 1</td>
                        <td class="dashboard-advisor1"></td>
                      </tr>
                      <tr>
                        <td>Youth Advisor 2</td>
                        <td class="dashboard-advisor2"></td>
                      </tr>
                      <tr>
                        <td>Mentor Teacher</td>
                        <td class="dashboard-mentor"></td>
                      </tr>
                      <tr>
                        <td>Number of Terms</td>
                        <td class="dashboard-terms"></td>
                      </tr>
                      <tr>
                        <td>Number of AEP Terms</td>
                        <td class="dashboard-aepTerms"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body scroll">
                <div class="table-responsive">
                  <table id="waDetail" class="table table-hover" width="100%">
                    <thead class="text-warning text-center">
                      <tr>
                        <th>Teacher</th>
                        <th>Course</th>
                        <th>Week</th>
                        <th>Assignment</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer text-center">
          <button type="button" class="btn btn-fill btn-default btn-sm" id="waDetailModal-close-btn">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    var weekDate = getWeekDate(new Date());
    $("#weeklyDatePicker3").val(weekDate);

    setWeekDatePicker("#weeklyDatePicker3");
    getWeeklyAssignment();
  });
</script>