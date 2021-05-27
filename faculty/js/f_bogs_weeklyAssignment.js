$(document).ready(function () {
  $("#bogsMenu").addClass("in");
  $(".page-title").html("G8/G9 Weekly Assignment");
  $(".bogs-select-group2").css("display", "none");
  $(".bogs-select-item").css("display", "none");
  $(".bogs-viewBtn").css("display", "none");
  $(".courseList").change(function (event) {
    var selectedCourse = $('.courseList').val();
    var selectedCourseText = $('.courseList option:selected').text()
    $('.course-info').html(selectedCourseText);
    getStudentListBySubject();
    dateTimePicker();
    var weekDate = getWeekDate(new Date());
    $("#weeklyDatePicker2").val(weekDate);

    setWeekDatePicker("#weeklyDatePicker2");
    getWeeklyAssignment();
  });
  $('#weeklyDatePicker2').on('dp.change', function(e){
    getWeeklyAssignment();
  });


  $("#btn-bogs-wassignment-save").click(function (params) {
    var tr;
    var itemsArr = [];
    var breakpoint = "break";
    var targetNum;
    var outOf;
    var chk;

    $(".wa-check:checked").each(function (i) {
      studentId = $(this).val();
      classname_key = $(this).attr("data-id");
      course_id = classname_key.split("-")[1];
      var term = $('.termList').val();
      tr = $(this).parent().parent()[0].children;

      var wa_num = $(tr[1]).html();
      var wa_id = $('.waId' + classname_key + '-' + wa_num).val();
      var wa_text = $(tr[2].children[0].children).closest('input').val();
      var wa_status = $(tr[3].children[0].children[0]).children('option:selected').val();
      if(wa_text){
        itemsArr.push({
          studentId: studentId,
          course_id: course_id,
          wa_seq: wa_num,
          wa_id: wa_id,
          wa_text: wa_text,
          wa_status: wa_status,
          wa_term: term
        });
      }

      breakpoint = "ok";
    });
    console.log(itemsArr);
    targetNum = itemsArr.length;
    outOf = globalStudentListBySubject.length * 3;

    if (breakpoint == "ok") {
      swal({
        title: "Are you sure?",
        text: "This would update " + targetNum + " out of " + outOf + " record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-info",
        cancelButtonClass: "btn btn-danger",
        confirmButtonText: "OK",
        buttonsStyling: false
      }).then(function (confirm) {
        if (confirm) {
          saveWeeklyAssignment(itemsArr);
        }
      }).catch(swal.noop);
    } else {
      showSwal("error", "You need to change at least one");
    }
  });
});

$("#btn-bogs-wassignment-cancel").click(function () {
  getStudentListBySubject();
  var weekDate = getWeekDate(new Date());
  $("#weeklyDatePicker2").val(weekDate);
  setWeekDatePicker("#weeklyDatePicker2");
  getWeeklyAssignment();
  changeBtnClass("#btn-bogs-wassignment-save", "btn-primary", "btn-info");
});


$(document).on("change", ".change-input-wa", function () {
  // console.log($(this).parent().parent().parent()[0].children[0].children[0]);
  var checkbox = $(this).parent().parent().parent()[0].children[0].children[0];
  $(checkbox).prop("checked", true);
  changeBtnClass("#btn-bogs-wassignment-save", "btn-info", "btn-primary");

});
