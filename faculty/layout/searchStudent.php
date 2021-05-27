<?php

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
                <div class="page-title">Search Student</div>
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
      <select class="term-select form-control custom-form" id="activities-selectTerm" disabled>
      </select>
    </div> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <input type="hidden" class="searchstudent-session-sid" name="" value="">
                        <input type="hidden" class="searchstudent-session-source" name=""
                            value="<?=$_SESSION['source']?>">
                        <div class="card-content">
                            <div class="mg-b-20">
                                <h4 class="card-title"><i class="material-icons">search</i>Search Student
                                </h4>
                                <p class="card-category">
                                    <?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?>
                                </p>
                            </div>
                            <div class="row row-eq-height">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="searchStu-student">Search Student</label>
                                        <input type="text" class="form-control" id="searchStu-student" name="student">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <button type="button" class="btn btn-fill btn-info btn-sm material-icons"
                                            id="searchStu-search-stu-btn" data-toggle="modal">
                                            search
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr />

                            <div class="row row-eq-height">
                                <div class="col-md-6">
                                    <label>Student Name :<span id="searchStu-stuName" class="color-202020 text-bold"></span><sup
                                            id="searchStu-stuStatus"
                                            style="font-size: 14px; margin-left:8px;"></sup></label>
                                </div>
                            </div>

                            <div class="material-datatables">
                                <table id="datatables-student-search"
                                    class="table table-striped table-no-bordered table-hover table-report display nowrap ellipsis-table"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>ACTIVITIY</th>
                                            <th>SOURCE</th>
                                            <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                                            <div class='mg-b-5'><label><i class='material-icons-outlined mg-r-10'>directions_bike</i>
                                            Physical, Outdoor & Recreation Education</label></div>
                                            <div><label><i class='material-icons-outlined mg-r-10'>school</i> Academic, Interest & Skill Development</label></div>
                                            <div><label><i class='material-icons-outlined mg-r-10'>language</i> Citizenship, Interaction & Leadership Experience</label></div>
                                            <div><label><i class='material-icons-outlined mg-r-10'>palette</i> Arts, Culture & Local Exploration</label></div>
                                          </div>">CATEGORY</span></th>
                                            <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                                            <label>Qualifies for Career Exploration Hours</label>
                                          </div>">CREX</span></th>
                                            <th>HOURS</th>
                                            <th>SUBMITTED BY</th>
                                            <th>APPROVER</th>
                                            <th>SUPERVISOR</th>
                                            <th><span rel="tooltip" data-html="true" data-original-title="<div class='text-left'>
                                            <!-- <label><i class='material-icons-outlined mg-r-10'>date_range</i>
                                              Registered</label> -->
                                            <label><i class='material-icons-outlined mg-r-10'>hourglass_empty</i> Pending
                                              Approval</label>
                                            <label><i class='material-icons-outlined mg-r-10'>done_outline</i> Hours
                                              Approved</label>
                                            <label><i class='material-icons-outlined mg-r-10'>link_off</i> Rejected</label>
                                          </div>">STATUS</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- end content-->
                    </div><!--  end card  -->
                </div> <!-- end col-md-12 -->
            </div> <!-- end row -->
        </div>
    </div>
</div>
<script src="../js/modalControl.js?ver=<?=$settings['gsversion']?>"></script>
<?php
  include_once('layout/searchStudentModal_report.html');
  include_once('layout/searchStudentSelfSubmitModal.php');
  include_once('layout/studentpicFrame.html');
?>
<script type="text/javascript">
    $(document).ready(function () {
        showCurrentTerm();
        pagerNumResize();
        dateTimePicker();
    });
</script>
