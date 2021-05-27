$(document).ready(function () {
  $("#bogsMenu").addClass("in");
  $(".page-title").html("View Grade");
  $(".bogs-select-children select").addClass("select-view-grade");
  $(".bogs-select-item").css("display", "none");
  $(".courseList").change(function (event) {
    var selectedCourse = $(".courseList").val();
    $(".categoryList").prepend('<option value="all" selected>All</option>');
    generateCategoryListV2(".categoryList", selectedCourse, globalOptionsListV2["CategoryList"], true);
    var selectedCategory = $(".categoryList").val();
  });

  $(".btn-bogs-view").click(function (event) {
    var selectedCourse = $(".courseList").val();
    var selectedCategory = $(".categoryList").val();
    console.log(globalOptionsListV2);
    displayItemInfoView(globalOptionsListV2);
    if (globalGradeList) {
      if (selectedCategory == "all") {
        setCardTitle(2);
        createViewGradeTable("overview");
        $(".viewGrade-description").css("display", "none");
        if (globalGradeList["overviewTable"][selectedCourse]) {
          generateOverViewTableHeader(globalGradeList, selectedCourse);
          generateOverViewTableRows(globalGradeList, selectedCourse, selectedCategory);
        } else {
          getOverViewGrade(globalOptionsListV2, true);
        }
      } else {
        setCardTitle(1);
        createViewGradeTable("viewgrade");
        $(".viewGrade-description").css("display", "block");
        if (globalGradeList["viewGradeTable"][selectedCategory]) {
          generateViewTableHeader(globalGradeList, selectedCategory);
          generateViewTableRows(globalGradeList, selectedCourse, selectedCategory);
        } else {
          getOverViewGrade(globalOptionsListV2, true);
        }
      }
    } else {
      if (selectedCategory == "all") {
        setCardTitle(2);
        createViewGradeTable("overview");
        $(".viewGrade-description").css("display", "none");
      } else {
        setCardTitle(1);
        createViewGradeTable("viewgrade");
      }
      getOverViewGrade(globalOptionsListV2, true);
    }
  });

  $(".categoryList").change(function (event) {
    var selectedCourse = $(".courseList").val();
    var selectedCategory = $(".categoryList").val();
    displayItemInfoView(globalOptionsListV2);
    if (globalGradeList) {
      if (selectedCategory == "all") {
        setCardTitle(2);
        createViewGradeTable("overview");
        $(".viewGrade-description").css("display", "none");
        if (globalGradeList["overviewTable"][selectedCourse]) {
          generateOverViewTableHeader(globalGradeList, selectedCourse);
          generateOverViewTableRows(globalGradeList, selectedCourse, selectedCategory);
        } else {
          getOverViewGrade(globalOptionsListV2, true);
        }
      } else {
        setCardTitle(1);
        createViewGradeTable("viewgrade");
        $(".viewGrade-description").css("display", "block");
        if (globalGradeList["viewGradeTable"][selectedCategory]) {
          generateViewTableHeader(globalGradeList, selectedCategory);
          generateViewTableRows(globalGradeList, selectedCourse, selectedCategory);
        } else {
          getOverViewGrade(globalOptionsListV2, true);
        }
      }
    }
  });
});

function createViewGradeTable(classname) {
  var table_html;
  if (classname) {
    table_html = '<table id="datatables-bogs-viewGrade" class="table dataTable table-striped table-hover display ellipsis-table ' + classname + '" cellspacing="0">' + "<thead></thead><tbody></tbody></table>";
  } else {
    table_html = '<table id="datatables-bogs-viewGrade" class="table dataTable table-striped table-hover display ellipsis-table" cellspacing="0">' + "<thead></thead><tbody></tbody></table>";
  }

  $(".viewGrade-table-container").html(table_html);
}

function setCardTitle(status) {
  var title = "";
  switch (status) {
    case 1:
      title = "View Grade";
      break;
    case 2:
      title = "Overview";
      break;
    case 3:
      title = "Overall Average";
      break;
    default:
      break;
  }

  $(".bogs-grade-title").html(title);
}

$(document).on("click", ".btn-bogs-overall", function () {
  var selectedCourse = $(".courseList").val();
  var selectedCourseText = $(".courseList option:selected").text();

  setCardTitle(3);
  if ( ! $.fn.DataTable.isDataTable( '#datatables-bogs-viewGrade' ) ) {
    getOverViewGrade(globalOptionsListV2, true);
  }
  createViewGradeTable("overall");
  generateOverallTableHeader(globalGradeList, selectedCourse);
  generateOverallTableRows(globalGradeList, selectedCourse);
  $(".course-info").html(globalOptionsListV2["termInfo"][0].SemesterName + " - " + selectedCourseText);
});
