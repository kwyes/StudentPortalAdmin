$(document).on("focus", "#datatables-bogs-categoryItem tbody td .datepicker", function (event) {
  $(".datepicker").datetimepicker({
    // debug: true,
    // readonly: true,
    ignoreReadonly: true,
    icons: {
      time: "fa fa-clock-o",
      date: "fa fa-calendar",
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down",
      previous: "fa fa-chevron-left",
      next: "fa fa-chevron-right",
      today: "fa fa-screenshot",
      clear: "fa fa-trash",
      close: "fa fa-remove"
    }
  }).on("dp.change", function () {
    var checkbox = $(this).parent().parent().parent()[0].children[0].children[0];
    $(checkbox).prop("checked", true);
  });
});

$("#btn-bogs-category-save, #btn-bogs-category-delete, #btn-bogs-categoryItem-save, #btn-bogs-categoryItem-delete").click(function (event) {
  var elem = $(this);
  var elemId = elem.attr("id");

  var id;
  var tr;
  var children_input;
  var itemsArr = [];
  var breakpoint = "break";
  var targetNum;
  var outOf;

  if (elemId == "btn-bogs-category-save" || elemId == "btn-bogs-category-delete") {
    $(".bogs-category-check:checked").each(function (i) {
      id = $(this).val();
      tr = $(this).parent().parent()[0].children;

      itemsArr.push({
        categoryId: id,
        categoryName: tr[2].children[0].children[0].value,
        categoryWeight: tr[3].children[0].children[0].value / 100
      });
      breakpoint = "ok";
    });

    targetNum = itemsArr.length;
    outOf = globalCategoryList.length;
  }
  if (elemId == "btn-bogs-categoryItem-save" || elemId == "btn-bogs-categoryItem-delete") {
    $(".bogs-categoryItem-check:checked").each(function (i) {
      id = $(this).val();
      tr = $(this).parent().parent()[0].children;
      var categoryId = $(this).attr("data-category-id");

      itemsArr.push({
        categoryId: categoryId,
        categoryItemId: id,
        categoryName: tr[2].textContent,
        title: tr[3].children[0].children[0].value,
        assignDate: tr[4].children[0].children[0].value,
        itemWeight: tr[5].children[0].children[0].value / 100,
        outOf: tr[6].children[0].children[0].value,
        description: tr[7].children[0].children[0].value
      });

      breakpoint = "ok";
    });

    targetNum = itemsArr.length;
    outOf = globalCategoryItemsList.length;
  }

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
        if (elemId == "btn-bogs-category-save") {
          chk = 0;
        } else if (elemId == "btn-bogs-category-delete") {
          chk = 1;
        } else if (elemId == "btn-bogs-categoryItem-save") {
          chk = 2;
        } else if (elemId == "btn-bogs-categoryItem-delete") {
          chk = 3;
        }
        controlCourseSettingsFunction(itemsArr, chk);
      }
    }).catch(swal.noop);
  } else {
    showSwal("error", "You need to check at least one");
  }
});

$(document).ready(function () {
  $("#bogsMenu").addClass("in");
  $(".page-title").html("Course Settings");
  $(".bogs-select-group2").css("display", "none");
  $(".bogs-viewBtn").css("display", "none");

  $(".courseList").on("change", function () {
    errorArr = [];
    categoryColor = [];
    $(".alert").css("display", "none", "important");
    getCategory(this.value);
    getCategoryItems(this.value);
    var selectedCourseText = $(".courseList option:selected").text();
    $(".course-info").html(selectedCourseText);
    calculateNumandPercentage(globalCategoryList, globalCategoryItemsList);
    displayErr(errorArr);
    $(".alert").css("top", "20px", "important");
  });
  displayErr(errorArr);
});
