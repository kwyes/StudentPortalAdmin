$(document).ready(function () {
  $("#bogsMenu").addClass("in");
  $(".page-title").html("Enter Grade");
  $(".bogs-select-children select").addClass("select-enter-grade");
  $(".bogs-viewBtn").css("display", "none");
  var chosenCourseId = $(".chosenCourseId").val();
  if (chosenCourseId) {
    $(".courseList").val(chosenCourseId).change();
  }
  var selectedCourseText = $(".courseList option:selected").text();
  $(".course-info").html(selectedCourseText);

  $(".courseList").change(function (event) {
    var selectedCourse = $(".courseList").val();
    generateCategoryListV2(".categoryList", selectedCourse, globalOptionsList["CategoryList"], false);
    var selectedCategory = $(".categoryList").val();
    generateCategoryItemList(".itemList", selectedCategory, globalOptionsList["categoryItemArray"]);
  });

  $(".categoryList").change(function (event) {
    toggleSpinner();
    var selectedCategory = $(".categoryList").val();
    generateCategoryItemList(".itemList", selectedCategory, globalOptionsList["categoryItemArray"]);
    toggleSpinner();
  });

  $(".select-enter-grade").change(function (event) {
    displayItemInfo(globalOptionsList);
    getEnterGradeRecord();
  });

  $("#btn-bogs-enterGrade-save").click(function (params) {
    var tr;
    var itemsArr = [];
    var breakpoint = "break";
    var targetNum;
    var outOf;
    var chk;

    $(".bogs-grade-check:checked").each(function (i) {
      gradeId = $(this).val();
      studSubjId = $(this).attr("data-id");
      tr = $(this).parent().parent()[0].children;

      if (tr[3].children[0].children[0].checked == true) {
        chk = 1;
      } else {
        chk = 0;
      }

      itemsArr.push({gradeId: gradeId, studSubjId: studSubjId, exempted: chk, score: tr[4].children[0].children[0].value, comment: tr[6].children[0].children[0].value});
      breakpoint = "ok";
    });

    targetNum = itemsArr.length;
    outOf = globalEnterGradeList.length;

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
          saveEnterGradeRecord(itemsArr);
        }
      }).catch(swal.noop);
    } else {
      showSwal("error", "You need to change at least one");
    }
  });
});
