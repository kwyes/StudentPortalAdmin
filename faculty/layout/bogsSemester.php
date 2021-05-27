<div class="content bogs-content">
    <div class="container-fluid">
        <div class="flexContainer flexCenter">
            <div class="width-50per">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title mg-b-20"><i class="material-icons-outlined">settings</i>Semester Config</h4>
                        <div class="form-group text-center">
                            <label class="font-12">This semester will affect all BOGS pages.</label>
                            <div class="row-eq-height flexCenter">
                                <select id="bogsSelectSemesterList"
                                    class="form-control custom-form width-auto font-16">
                                </select>
                                <button class="btn btn-fill btn-info btn-sm btn-bogs-selectSemester">Select</button>
                            </div>
                        </div>
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
  $("#bogsMenu").addClass("in");
  $(".page-title").html("Semester Config");
  $(".bogs-select-term").css("display", "none");
  $(".bogs-select-course").css("display", "none");
  $(".bogs-select-group2").css("display", "none");
  $(".bogs-select-item").css("display", "none");
  $(".bogs-viewBtn").css("display", "none");
  showCurrentTerm();
  generateTermListV2("#bogsSelectSemesterList", globalSemesterList);
  $(".btn-bogs-selectSemester").click(function (event) {
    var bogsVal = $('#bogsSelectSemesterList').val();
    var text = 'bogsSemester';
    var text2 = 'bogsSemesterText';
    var selectedSemesterText = $("#bogsSelectSemesterList option:selected").text();
    registerSession(bogsVal,text, 0);
    registerSession(selectedSemesterText,text2, 1);
    // location.href = "?page=bogs&menu=weeklyAssignment";

  });

})
</script>
