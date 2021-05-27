<?php
  $editautharr = array(30,99);
  $boardingautharr = array(30,31,32);
?>
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
        <div class="page-title">Dashboard</div>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="separator hidden-lg hidden-md"></li>
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
        <div class="col-md-4">
          <!-- Term Schedule -->
          <div class="card">
            <div class="card-content">
              <h4 class="card-title"><i class="material-icons-outlined">calendar_today</i><span
                  class="dashboard-semesterName"></span> - <span class="dashboard-termStatus"></span></h4>
              <p class="category current-term-p"></p>
              <!-- <div class="table-responsive"> -->
              <div class="progress progress-striped active mg-t-20">
                <div class="progress-bar">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
          </div>
          <!-- User Profile -->
          <div class="card">
            <div class="card-content">
              <h4 class="card-title"><i class="material-icons-outlined">perm_identity</i><span
                  class="dashboard-username"></span>
              </h4>
              <p class="category dashboard-position"></p>
              <div class="text-center">
                <img class="staff-img img-m" onerror="this.src='https://asset.bodwell.edu/OB4mpVPg/common/userimg.png'"
                  alt="" />
              </div>
            </div>
          </div>

        </div>
        <div class="col-md-8">
          <!-- Total Activities -->
          <!-- <div class="card">
            <div class="card-content">
              <h4 class="card-title"><i class="material-icons-outlined">accessibility_new</i>Activities</h4>
              <div class="table-responsive table-sales">
                <table id="dashboard-activities" class="table table-hover dashboard-enrollmentTable"
                  style="table-layout:fixed">
                  <thead>
                    <tr>
                      <th class="color-3c4858" rowspan="2" width="10%"><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                      <div class='mg-b-5'><label><i class='material-icons-outlined mg-r-10'>directions_bike</i>
                      Physical, Outdoor & Recreation Education</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>school</i> Academic, Interest & Skill Development</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>language</i> Citizenship, Interaction & Leadership Experience</label></div>
                      <div><label><i class='material-icons-outlined mg-r-10'>palette</i> Arts, Culture & Local Exploration</label></div>
                    </div>">Category</span></th>
                      <th class="color-3c4858" rowspan="2">School Activities<br /> I'm Leading</th>
                      <th class="color-3c4858" colspan="3">Self-Submitted Activities</th>
                    </tr>
                    <tr>
                      <th class="color-3c4858">I’ve Approved</th>
                      <th class="color-3c4858">I’ve Rejected</th>
                      <th class="color-3c4858">Pending My Approval</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center"><i class="material-icons-outlined">directions_bike</i></td>
                      <td class="text-center"><span class="dashboard-PORE-myActivities">0</span></td>
                      <td class="text-center"><span class="dashboard-PORE-selfActivities-approve">0</span></td>
                      <td class="text-center"><span class="dashboard-PORE-selfActivities-reject">0</span></td>
                      <td class="text-center"><span class="dashboard-PORE-selfActivities-pending">0</span></td>
                    </tr>
                    <tr>
                      <td class="text-center"><i class="material-icons-outlined">school</i></td>
                      <td class="text-center"><span class="dashboard-AISD-myActivities">0</span></td>
                      <td class="text-center"><span class="dashboard-AISD-selfActivities-approve">0</span></td>
                      <td class="text-center"><span class="dashboard-AISD-selfActivities-reject">0</span></td>
                      <td class="text-center"><span class="dashboard-AISD-selfActivities-pending">0</span></td>
                    </tr>
                    <tr>
                      <td class="text-center"><i class="material-icons-outlined">language</i></td>
                      <td class="text-center"><span class="dashboard-CILE-myActivities">0</span></td>
                      <td class="text-center"><span class="dashboard-CILE-selfActivities-apprve">0</span></td>
                      <td class="text-center"><span class="dashboard-CILE-selfActivities-reject">0</span></td>
                      <td class="text-center"><span class="dashboard-CILE-selfActivities-pending">0</span></td>
                    </tr>
                    <tr>
                      <td class="text-center"><i class="material-icons-outlined">palette</i></td>
                      <td class="text-center"><span class="dashboard-ACLE-myActivities">0</span></td>
                      <td class="text-center"><span class="dashboard-ACLE-selfActivities-approve">0</span></td>
                      <td class="text-center"><span class="dashboard-ACLE-selfActivities-reject">0</span></td>
                      <td class="text-center"><span class="dashboard-ACLE-selfActivities-pending">0</span></td>
                    </tr>
                    <tr>
                      <td class="text-center">Total</td>
                      <td class="text-center"><span class="dashboard-TOTAL-myActivities">0</td>
                      <td class="text-center"><a href="?page=selfsubmit"><span class="dashboard-TOTAL-selfActivities-approve">0</a></td>
                      <td class="text-center"><a href="?page=selfsubmit"><span class="dashboard-TOTAL-selfActivities-reject">0</a></td>
                      <td class="text-center"><a href="?page=selfsubmit"><span class="dashboard-TOTAL-selfActivities-pending">0</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div> -->
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <?php
            if(in_array($_SESSION['staffRole'], $editautharr)){

          ?>
          <div class="card">
            <div class="card-content">
              <h4 class="card-title"><i class="material-icons-outlined">settings</i>Manage School Activities</h4>
              <ul class="manage-schAct">
                <li><a href="?page=activities">Edit activities</a></li>
                <!-- <li><a href="">Bulk upload activities</a></li> -->
              </ul>
            </div>
          </div>
          <?php
            }
         ?>
        </div>

        <div class="col-md-8">
          <?php
            if(in_array($_SESSION['staffRole'], $boardingautharr)){
          ?>
          <div class="card">
            <div class="card-content">
              <h4 class="card-title"><i class="material-icons-outlined">group</i>My Students</h4>
              <table id="dashboard-studentlist" class="table ellipsis-table table-hover dashboard-stulist">
                <thead>
                  <tr>
                    <th class="color-3c4858">STUDENT NAME</th>
                    <th class="color-3c4858">SP</th>
                    <th class="color-3c4858">ORIGIN</th>
                    <th class="color-3c4858">RESIDENCE</th>
                    <th class="color-3c4858">ROOM</th>
                    <th class="color-3c4858">HALL</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <script>
            $(document).ready(function () {
              getMyStudentList('<?=$_SESSION['stfFullName']?>');
            });
          </script>
          <?php
            }
         ?>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
<?php include_once('studentpicFrame.html'); ?>
<script type="text/javascript">
  $(document).ready(function () {
    showMyProfile();
    showCurrentTerm();
    dashBoard_total_activities();
    dashBoard_my_activities();
    dashBoard_my_selfsubmit_activities();
  });
</script>
