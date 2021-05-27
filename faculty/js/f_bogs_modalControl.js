$(document).ready(function () {
  generateSelector_v2("#bogsCategoryMdl-category", bogscategoryArr, "none", "");
  $("#bogsCategoryMdl-cateName").hide();
  var selectedCategory = $("#bogsCategoryMdl-category option:selected").text();
  $("#bogsCategoryMdl-cateName").val(selectedCategory);
  $("#bogsCategoryMdl-category").change(function (event) {
    if (this.value == "99") {
      $("#bogsCategoryMdl-cateName").val("");
      $("#bogsCategoryMdl-cateName").show();
    } else {
      var selectedCategory = $("#bogsCategoryMdl-category option:selected").text();
      $("#bogsCategoryMdl-cateName").hide();
      $("#bogsCategoryMdl-cateName").val(selectedCategory);
    }
  });

  $("#bogsCategoryMdl-add-btn").click(function (event) {
    setFormBogsValidation("#bogsCategoryMdlValidation");
    if ($("#bogsCategoryMdlValidation").valid()) {
      $("#bogsCategoryMdl-add-btn").prop("disabled", "disabled");
      var formArr = customSerializeArray("#bogsCategoryMdlValidation");
      formArr["SubjectID"] = $(".courseList").val();
      formArr["SemesterID"] = $(".termList").val();
      AddBogsCategory(formArr);
    }
  });

  $("#bogsCategoryItemMdl-add-btn").click(function (event) {
    setFormBogsValidation("#bogsCategoryItemMdlValidation");
    if ($("#bogsCategoryItemMdlValidation").valid()) {
      var formArr = customSerializeArray("#bogsCategoryItemMdlValidation");
      formArr["SubjectID"] = $(".courseList").val();
      formArr["SemesterID"] = $(".termList").val();
      formArr["text"] = $("#bogsCategoryItemMdl-category option:selected").text();

      AddBogsCategoryItems(formArr);
    }
  });

  $("#bogsCategoryModal").on("hidden.bs.modal", function () {
    clearForm("#bogsCategoryMdlValidation");
    clearFormValidation("#bogsCategoryMdlValidation");
    $("#bogsCategoryMdl-cateName").css("display", "none");
    $("#bogsCategoryMdl-add-btn").prop("disabled", "");
  });

  $("#bogsCategoryItemModal").on("hidden.bs.modal", function () {
    clearForm("#bogsCategoryItemMdlValidation");
    clearFormValidation("#bogsCategoryItemMdlValidation");
  });

  $("#courseCalendarModal").on("hidden.bs.modal", function () {
    var selectedCourse = $('.courseList').val();
    getCategoryItems(selectedCourse);
    if (globalCategoryList) {
      calculateNumandPercentage(globalCategoryList, globalCategoryItemsList);
    }
  });

  $("#courseCalendarEventModal").on("hidden.bs.modal", function () {
    $('.calendarEventTitle').html('');
    $('.calendarEventDate').html('');
    $(".calendarEvent").removeClass (function (index, className) {
      return (className.match (/bgColor-\w+/g) || []).join(' ');
    });
  });

  $("#courseCalendarModal").on("shown.bs.modal", function () {
    var term = $(".termList").val();
    var staffId = $(".bogsStaffId").val();
    if (!globalSchedulelist) {
      GetCourseSchedule(term, staffId);
    }
    //grap the globalSchedulelist and display events
    generateCourseList(".courseList-calendar", globalcourselist, false);
    var calCourse = $(".courseList-calendar").val();
    getCategoryV2(calCourse);
    generateCategoryListV4(".categoryList-calendar", globalCategoryListV2);
    var calCategory = $(".categoryList-calendar").val();
    initFullCalendar(globalSchedulelist, calCourse, calCategory);
  });

  $(".courseList-calendar").change(function () {
    var calCourse = $(".courseList-calendar").val();
    getCategoryV2(calCourse);
    generateCategoryListV4(".categoryList-calendar", globalCategoryListV2);
    var calCategory = $(".categoryList-calendar").val();

    updateCalenderEvents(globalSchedulelist, calCourse, calCategory);
  });

  $(".categoryList-calendar").change(function () {
    var calCourse = $(".courseList-calendar").val();
    var calCategory = $(".categoryList-calendar").val();

    updateCalenderEvents(globalSchedulelist, calCourse, calCategory);
  });
});

$(document).on("click", "#bogsCategoryMdl-cancel-btn, #bogsCategoryItemMdl-cancel-btn", function (event) {
  var target = $(event.target);
  var id = target.attr("id");
  var modal = "";
  switch (id) {
    case "bogsCategoryMdl-cancel-btn":
      modal = "#bogsCategoryModal";
      break;
    case "bogsCategoryItemMdl-cancel-btn":
      modal = "#bogsCategoryItemModal";
      break;
    default:
      break;
  }
  $(modal).modal("hide");
});

function setFormBogsValidation(id) {
  $(id).validate({
    onclick: false,
    rules: {
      categoryCode: {
        required: true
      },
      categoryName: {
        required: true
      },
      categoryWeight: {
        required: true
      },
      outOf: {
        required: true
      },
      numOfItem: {
        required: true
      }
    },
    highlight: function (element) {
      $(element).closest(".form-group").removeClass("has-success").addClass("has-danger");
      $(element).closest(".form-check").removeClass("has-success").addClass("has-danger");
    },
    success: function (element) {
      $(element).closest(".form-group").removeClass("has-danger").addClass("has-success");
      $(element).closest(".form-check").removeClass("has-danger").addClass("has-success");
    },
    errorPlacement: function (error, element) {
      $(element).closest(".form-group").append(error);
    }
  });
}

function clearForm(table_id) {
  $(table_id).find('input[type="text"], input[type="number"], textarea,select').val("");
}

function clearFormValidation(form_id) {
  var input_text = form_id + ' [type="text"]';
  $(input_text).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_text).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + ' [type="number"]';
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + " select";
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");
  $(".error").remove();
}
