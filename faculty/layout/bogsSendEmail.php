<div class="main-panel">
  <nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-minimize">
        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
          <i class="material-icons visible-on-sidebar-regular">more_vert</i>
          <i class="material-icons visible-on-sidebar-mini">view_list</i>
        </button>
      </div>
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="page-title">Send Email</div>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right bogs-navbar">
          <!-- <li class="separator hidden-lg hidden-md"></li> -->
          <li class="nav-item">
            <div class="form-group">
              <label class="color-18acbc font-12">Term</label>
              <select name="termList"
                class="form-control custom-form width-200 termList">
                <option value="">Summer 2019</option>
                <option value="">Winter 2019</option>
              </select>
            </div>
          </li>
          <li class="nav-item">
            <div class="form-group">
              <label class="color-18acbc font-12">Course</label>
              <select name="courseList"
                class="form-control custom-form width-200 courseList">
                <option value="">Composition 10A</option>
                <option value="">Creative Writing 10B</option>
              </select>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="content">
    <!-- <div class="term-filter">
      <select class="term-select form-control custom-form" id="dashboard-selectTerm">
      </select>
    </div> -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Total Activities -->
          <div class="card">
            <div class="card-content">
              <div class="row mg-b-20">
                <div class="col-md-6">
                  <h4 class="card-title"><i class="material-icons-outlined">mail</i>Send Email</h4>
                  <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.'Composition 10A'?></p>
                </div>
              </div>
              <form id="sendEmailValidation" action="" method="">
                <div class="row row-eq-height">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sendEmail-category">Category</label>
                      <select name="category" id="sendEmail-category" class="form-control width-auto">
                        <option value="">All</option>
                        <option value="1">Midterm Exam</option>
                        <option value="2">Final Exam</option>
                        <option value="3">Assignments / Quizzes / Projects</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="sendEmail-categoryItem">Category Item</label>
                      <select name="categoryItem" id="sendEmail-categoryItem" class="form-control width-auto">
                        <option value="">All</option>
                        <option value="1">Stand Alone Paragraph</option>
                        <option value="2">Multiple Choice Questions</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="sendEmail-subject">Subject</label>
                  <input type="text" class="form-control width-60per" id="sendEmail-subject" name="subject">
                </div>

                <div class="form-group">
                  <label for="sendEmail-message">Message</label>
                  <textarea id="sendEmail-message" name="message" rows="5"
                      class="md-textarea form-control width-60per" style="height: 100px;" maxlength="1000"></textarea>
                </div>

                <div class="row row-eq-height">
                  <div class="col-md-3">
                    <div class="form-check">
                      <label for="sendEmail-ccCounselor">CC Counselor</label>
                      <input type="checkbox" name="ccCounselor" id="sendEmail-ccCounselor" class="form-check-input">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="sendEmail-ccMyself">CC Myself</label>
                      <input type="checkbox" name="ccMyself" id="sendEmail-ccMyself">
                    </div>
                  </div>
                </div>

                <div class="material-datatables">
                  <table id="datatables-bogs-sendEmail" class="table dataTable table-striped table-hover display"
                    cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th><input type="checkbox" class="selectAll"></th>
                        <th>STUDENT ID</th>
                        <th>LAST NAME</th>
                        <th>FIRST NAME</th>
                        <th>ENGLISH NAME</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td>201800050</td>
                        <td>BARAFANOVA</td>
                        <td>Kristina</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td>201800335</td>
                        <td>ENAMZADEH</td>
                        <td>Rozhin</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td>201700388</td>
                        <td>GHAEINI KARIZAKI</td>
                        <td>Amirashkan</td>
                        <td>Ashkan</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button id="btn-bogs-email-send" type="button"
                          class="btn btn-fill btn-info btn-sm">Send Email</button>
                    <button id="btn-bogs-email-cancel" type="button"
                          class="btn btn-fill btn-info btn-sm">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  selectAllCheckbox("#datatables-bogs-sendEmail");
})
</script>
