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
        <div class="page-title">Student Self Assessments</div>
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
      <select class="term-select form-control custom-form" id="selfsubmit-selectTerm" disabled>
      </select>
    </div> -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content">
              <div class="mg-b-20">
                <div class="row">
                  <div class="col-md-4">
                    <h4 class="card-title">
                      <i class="material-icons-outlined">description</i>Browse Students Self Assessments
                    </h4>
                    <p class="card-category"><?php echo $_SESSION['SemesterName'].' - '.$_SESSION['termStatus']?></p>
                  </div>
                  <div class="col-md-8 text-right">
                    <div>
                      <button id="btn-self-assessments-summary" type="button"
                        class="btn btn-fill btn-info btn-summary btn-sm" onclick="">Summary</button>
                      <button id="btn-self-assessments-export" type="button"
                        class="btn btn-fill btn-info btn-export btn-sm" onclick="">Export</button>
                    </div>

                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12 selfAssessments-filter-group">
                  <label class="mg-r-10">
                    Grade :
                    <div class="select-container">
                      <select name="grade" id="sAssessments-grade-select"
                        class="form-control custom-form mg-lr-7 width-200 gradeList">
                        <option value="">All</option>
                        <option value="aep">AEP 10/11</option>
                        <option value="g10">GRADE 10 - 12</option>
                        <option value="g8">GRADE 8 - 9</option>
                      </select>
                    </div>
                  </label>

                  <label class="mg-r-10">
                    Term :
                    <div class="semester_filter">
                      <select id="sAssessments-term-select" class="select-term form-control custom-form">
                      </select>

                    </div>
                  </label>

                  <!-- <button type="button" class="btn btn-fill btn-default filter-reset-btn btn-sm">Reset</button> -->
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-selfAssessments" class="table dataTable table-striped table-hover display ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CreateDATE</th>
                      <th>Term</th>
                      <th>STUDENT ID</th>
                      <th>STUDENT NAME</th>
                      <th>Grade</th>
                      <th>ModifyDate</th>
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
  include_once('layout/selfAssessmentsModal.php');
?>
<script type="text/javascript">
function openWindowWithPost(url,keys,values)
{
    var newWindow = window.open(url);

    if (!newWindow) return false;

    var html = "";
    html += "<html><head></head><body><form id='formid' method='post' action='" + url +"'>";

    if (keys && values && (keys.length == values.length))
        for (var i=0; i < keys.length; i++)
            html += "<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";

    html += "</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</sc"+"ript></body></html>";

    newWindow.document.write(html);
    return newWindow;
}

  $(document).ready(function () {
    showCurrentTerm();
    pagerNumResize();
    getSelfAssessments();

    $("#sAssessments-term-select").change(function(){
      getSelfAssessments();
    });

    $('#btn-self-assessments-summary').click(function(event) {
      var grade = $('#sAssessments-grade-select').val();
      var term = $('#sAssessments-term-select').val();
      var url = 'layout/selfAssessmentsSummary.php';
      var keys= ["<?=$_SESSION['staffId']?>","<?=$_SESSION['staffRole']?>",grade, term];

      var values= ["staffId","RoleBogs","Grade","Term"];
      openWindowWithPost(url,keys,values);
    });

    $('#btn-self-assessments-export').click(function(event) {
      var grade = $('#sAssessments-grade-select').val();
      var term = $('#sAssessments-term-select').val();
      var url = 'excel/StudentAssessmentsExcel.php';
      var keys= [grade, term];

      var values= ["staffId","RoleBogs","Grade","Term"];
      openWindowWithPost(url,keys,values);
    });




  });
</script>
