$(document).ready(function () {
  // Set validation
  $("#actMdl-edit-btn").click(function () {
    setFormValidation("#actMdlValidation");
    if ($("#actMdlValidation").valid()) {
      var activityEditForm = $("#actMdlValidation").serializeArray();
      var activityEditFormObject = {};
      $.each(activityEditForm, function (i, v) {
        activityEditFormObject[v.name] = v.value;
      });
      editSchoolActivityDetail(activityEditFormObject);
    }
  });

  $("#addSubmitMdl-add-btn").click(function () {
    setFormValidation("#addSubmitMdlValidation");
    if ($("#addSubmitMdlValidation").valid()) {
      addSelfSubmitHoursByStaff();
    }
  });

  $("#addVlweMdl-add-btn").click(function () {
    setFormValidation("#addVlweMdlValidation");
    if ($("#addVlweMdlValidation").valid()) {
      addVlweHoursByStaff();
    }
  });

  $("#addActMdl-add-btn").click(function () {
    setFormValidation("#addActMdlValidation");
    if ($("#addActMdlValidation").valid()) {
      var addActivityForm = $("#addActMdlValidation").serializeArray();
      var addActivityFormObject = {};
      $.each(addActivityForm, function (i, v) {
        addActivityFormObject[v.name] = v.value;
      });
      addAcitivityByStaff(addActivityFormObject);
    }
  });

  $("#sSubmitMdl-edit-btn").click(function () {
    setFormValidation("#sSubmitMdlValidation");
    if ($("#sSubmitMdlValidation").valid()) {
      toggleSpinner();
      var selfSubmitForm = $("#sSubmitMdlValidation").serializeArray();
      var selfSubmitFormObject = {};
      $.each(selfSubmitForm, function (i, v) {
        selfSubmitFormObject[v.name] = v.value;
      });
      editSelfsubmitByStaff(selfSubmitFormObject);
    }
  });

  $("#sStudentMdl-edit-btn").click(function () {
    setFormValidation("#sStudentMdlValidation");
    if ($("#sStudentMdlValidation").valid()) {
      toggleSpinner();
      var searchStuForm = $("#sStudentMdlValidation").serializeArray();
      var searchStuFormObject = {};
      $.each(searchStuForm, function (i, v) {
        searchStuFormObject[v.name] = v.value;
      });
      editSearchStudentByStaff(searchStuFormObject);
    }
  });

  $("#vlweMdl-edit-btn").click(function () {
    setFormValidation("#vlweMdlValidation");
    if ($("#vlweMdlValidation").valid()) {
      var vlweForm = $("#vlweMdlValidation").serializeArray();
      var vlweFormObject = {};
      $.each(vlweForm, function (i, v) {
        vlweFormObject[v.name] = v.value;
      });
      vlweFormObject["category"] = "21";
      vlweFormObject["vlwe"] = "1";
      editVlweByStaff(vlweFormObject);
    }
  });

  $("#career-save-btn").click(function () {
    setFormValidation("#form-careerLife");
    if ($("#form-careerLife").valid()) {
      updateForm = getAllValInForm("form-careerLife");
      var isChanged = checkSomethingChanged(defaultForm, updateForm);
      if (isChanged == true) {
        $(".changeNothing").css("display", "none");
        toggleSpinner();

        var careerLifeForm = $("#form-careerLife").serializeArray();
        var careerLifeFormObject = {};
        $.each(careerLifeForm, function (i, v) {
          careerLifeFormObject[v.name] = v.value;
        });
        ajaxToUpdateCareerLife(careerLifeFormObject);
      } else {
        $(".changeNothing").css("display", "block");
      }
    }
  });

  $("#addCareer-submit-btn").click(function () {
    setFormValidation("#form-addCareerLifeModal");
    if ($("#form-addCareerLifeModal").valid()) {
      toggleSpinner();
      $("#addCareer-course").prop("disabled", "");
      var addCareerLifeForm = $("#form-addCareerLifeModal").serializeArray();
      var addCareerLifeFormObject = {};
      $.each(addCareerLifeForm, function (i, v) {
        addCareerLifeFormObject[v.name] = v.value;
      });
      ajaxToAddCareerLife(addCareerLifeFormObject);
    }
  });

  $("#LeaveBanMdl-add-btn").click(function () {
    var i = 0;
    $('#leaveBanCreateMdl input').each(function(){
      if(!$(this).val()){
        i++;
      }
    });
    if(i == 0){
      var leaveBanCreateForm = $("#LeaveBanMdlValidation").serializeArray();
      var leaveBanCreateFormObject = {};
      $.each(leaveBanCreateForm, function (i, v) {
        leaveBanCreateFormObject[v.name] = v.value;
      });
      saveStudentLeaveBan(leaveBanCreateFormObject);
    } else {
      showSwal("error", "Please fill all required fields");
    }
  });

  $("#leaveRequestMdl-edit-btn").click(function () {
      $('.leaveRequestMdlDate').removeAttr('disabled');
      var leaveForm = $("#leaveRequestMdlValidation").serializeArray();
      $('.leaveRequestMdlDate').attr('disabled', 'disabled');

      var leaveFormObject = {};
      $.each(leaveForm, function (i, v) {
        leaveFormObject[v.name] = v.value;
      });
      editLeaveRequest(leaveFormObject);

  });

  $("#LeaveBanDetailMdl-edit-btn").click(function () {
      var leaveForm = $("#LeaveBanDetailMdlValidation").serializeArray();
      var leaveFormObject = {};
      $.each(leaveForm, function (i, v) {
        leaveFormObject[v.name] = v.value;
      });
      editLeaveBan(leaveFormObject);

  });


  // Remove validation and value in form
  $("#schoolActivityModal").on("hidden.bs.modal", function () {
    clearFormValidation("#actMdlValidation");
    clearForm("#actMdl-table");
  });

  $("#addSelfSubmitModal").on("hidden.bs.modal", function () {
    clearFormValidation("#addSubmitMdlValidation");
    clearForm("#addSubmitMdlValidation");
  });

  $("#addActivityModal").on("hidden.bs.modal", function () {
    clearFormValidation("#addActMdlValidation");
    clearForm("#addActMdl-table");
  });

  $("#selfSubmitModal").on("hidden.bs.modal", function () {
    clearFormValidation("#sSubmitMdlValidation");
    clearForm("#sSubmitMdl-table");
  });

  $("#addVlweModal").on("hidden.bs.modal", function () {
    clearFormValidation("#addVlweMdlValidation");
    clearForm("#addVlweMdl-table");
  });

  $("#vlweModal").on("hidden.bs.modal", function () {
    clearFormValidation("#vlweMdlValidation");
    clearForm("#vlweMdl-table");
  });

  $("#sStudentModal").on("hidden.bs.modal", function () {
    clearFormValidation("#sStudentMdlValidation");
    clearForm("sStudentMdlValidation");
  });
  $("#addEnrollModal").on("hidden.bs.modal", function () {
    clearForm(".card-body");
  });

  $("#careerLifeModal").on("hidden.bs.modal", function () {
    clearForm(".card-body");
  });

  $("#AddCareerLifeModal").on("hidden.bs.modal", function () {
    clearFormValidation("#form-addCareerLifeModal");
    clearForm("#form-addCareerLifeModal");
    clearImg("#addCareer-studentPic");
  });

  // Parse Float number of hours
  $("#actMdl-hours,#addSubmitMdl-hours,#addActMdl-hours, #sSubmitMdl-hours").change(function (event) {
    var target = $(event.target);
    var id = "#" + target.attr("id");
    parseHourDecimal(id);
  });

  // Parse Int number of max enrollment
  $("#addActMdl-maxEnroll, #actMdl-maxEnroll").change(function (event) {
    var target = $(event.target);
    var id = "#" + target.attr("id");
    parseMaxEnrollment(id);
  });

  $("#addSubmitMdl-student, #addVlweMdl-student").keypress(function (e) {
    var target = $(e.target);
    var id = "#" + target.attr("id");
    var key = e.which;
    if (key == 13) {
      searchStudentByName(id);
    }
  });

  $("#report-student, #searchStu-student, #addCareer-searchStu, #LeaveBanMdl-student").keypress(function (e) {
    var target = $(e.target);
    var id = "#" + target.attr("id");
    var key = e.which;
    if (key == 13) {
      if (id == "#addCareer-searchStu") {
        searchStudentByName_career(id);
      } else if (id == "#LeaveBanMdl-student") {
        searchStudentByNameV2(id);
      } else {
        searchStudentByName_report(id);
      }
    }
  });

  $("#addEnr-stu-text").keypress(function (e) {
    var key = e.which;
    if (key == 13) {
      actMdlsearchStudentByName();
    }
  });

  $(document).on("click", "#submit-search-stu-btn, #vlwe-search-stu-btn", function (event) {
    var target = $(event.target);
    var btn_id = target.attr("id");
    var id = "";
    if (btn_id == "submit-search-stu-btn") {
      id = "#addSubmitMdl-student";
    } else if (btn_id == "vlwe-search-stu-btn") {
      id = "#addVlweMdl-student";
    }
    searchStudentByName(id);
  });

  $(document).on("click", "#report-search-stu-btn, #searchStu-search-stu-btn, #addCareer-searchStuBtn, #leave-search-stu-btn", function (event) {
    var target = $(event.target);
    var btn_id = target.attr("id");
    if (btn_id == "report-search-stu-btn") {
      searchStudentByName_report("#report-student");
    } else if (btn_id == "searchStu-search-stu-btn") {
      searchStudentByName_report("#searchStu-student");
    } else if (btn_id == "addCareer-searchStuBtn") {
      searchStudentByName_career("#addCareer-searchStu");
    } else if (btn_id == "leave-search-stu-btn"){
      searchStudentByNameV2("#LeaveBanMdl-student");
    }
  });

  $("#searchStuMdl-table").on("click", "tbody tr.searchStudentTr", function () {
    var id = $(this).attr("data-id");
    var fullName = $(this).attr("data-full-name");

    if (id == "") {
      showSwal("error", "Try to search student again");
    } else {
      if ($("#addSelfSubmitModal").is(":visible")) {
        $("#addSubmitMdl-studentId").val(id);
        $("#addSubmitMdl-student").val(fullName);
      } else if ($("#addVlweModal").is(":visible")) {
        $("#addVlweMdl-studentId").val(id);
        $("#addVlweMdl-student").val(fullName);
      }
      $("#searchStudentModal").modal("toggle");
    }
  });

  $('#btn-leave-create').click(function(event) {
    $('#leaveBanCreateMdl').modal();
    $('#leaveBanCreateMdl input').val('');
  });

  $("#searchStuMdl-table").on("click", "tbody tr.searchStudentTrV2", function () {
    var id = $(this).attr("data-id");
    var fullName = $(this).attr("data-full-name");

    if (id == "") {
      showSwal("error", "Try to search student again");
    } else {
        $(".resultStudentID").val(id);
        $(".resultStudentName").val(fullName);
    }
    $("#searchStudentModal").modal("toggle");

  });

  $("#searchStuMdlReport-table").on("click", "tbody tr", function () {
    var id = $(this).attr("data-id");
    var fullName = $(this).attr("data-full-name");
    var CurrentStatus = $(this).attr("data-status");

    if (id == "") {
      showSwal("error", "Try to search student again");
    } else {
      if ($("#pageId-comeFrom").val() == "#report-student") {
        createReportTable(id, fullName, CurrentStatus, globalSemesterList);
      } else if ($("#pageId-comeFrom").val() == "#searchStu-student") {
        createSearchStudentTable(
          id,
          fullName,
          CurrentStatus,
          globalSemesterList
        );
      } else if ($("#pageId-comeFrom").val() == "#addCareer-searchStu") {
        $("#addCareer-studentId").val(id);
        $("#addCareer-searchStu").val(fullName);
        $("#addCareer-studentPic").attr(
          "src",
          "https://asset.bodwell.edu/OB4mpVpg/student/bhs" + id + ".jpg"
        );
      }

      $("#searchStudentModal_report").modal("hide");
    }
  });

  $("#searchStuMdlCareer-table").on("click", "tbody tr", function () {
    var id = $(this).attr("data-id");
    var fullName = $(this).attr("data-full-name");
    var courseId = $(this).attr("data-course-id");

    if (id == "") {
      showSwal("error", "Try to search student again");
    } else {
      if (courseId != 0) {
        $("#addCareer-studentId").val(id);
        $("#addCareer-searchStu").val(fullName);
        $("#addCareer-studentPic").attr(
          "src",
          "https://asset.bodwell.edu/OB4mpVpg/student/bhs" + id + ".jpg"
        );
        $("#addCareer-course").val(courseId).change();

        $("#searchStudentModal_career").modal("hide");
      }
    }
  });

  $("#addEnrollMdl-table").on("click", "tbody tr", function () {
    var id = $(this).attr("data-id");
    if (id == "") {
      showSwal("error", "Try to search student again");
      // alert('Try to search student again');
    } else {
      insertActivityRecordByStaff(id);
    }
  });
});

$(document).on(
  "click",
  ".actTitleLink, .sSubmitNameLink, .add-sSubmit-btn, .add-act-btn, .add-enrol-btn, .add-vlwe-btn, .vlweNameLink, .searchStuTitleLink, .career-link, .submit-capstone-btn, .leaveRequestMdlLink, .selfAssessmentsMdlLink, .LeaveBanDetailMdlLink, .transcriptRequestMdlLink",
  function (event) {
    var target = $(event.target);
    var dataid = target.attr("data-id");
    if (target.hasClass("actTitleLink")) {
      target.attr({
        href: "#schoolActivityModal",
        "data-target": "#schoolActivityModal"
      });
      getDetailofActivity(dataid, globalres);
    } else if (target.hasClass("sSubmitNameLink")) {
      target.attr({
        href: "#selfSubmitModal",
        "data-target": "#selfSubmitModal"
      });
      getDetailofSelfSubmithour(dataid, selfsubmitResponse);
    } else if (target.hasClass("add-sSubmit-btn")) {
      var staff = $("#addSubmitMdl-apprStaff").val();
      if (staff) {
        $("#addSubmitMdl-approverPic").attr(
          "src",
          "https://asset.bodwell.edu/OB4mpVpg/staff/" + staff + ".jpg"
        );
      } else {
        clearImg("#addSubmitMdl-approverPic");
      }

      target.attr({
        "data-target": "#addSelfSubmitModal"
      });
    } else if (target.hasClass("add-act-btn")) {
      target.attr({
        "data-target": "#addActivityModal"
      });
    } else if (target.hasClass("add-enrol-btn")) {
      target.attr({
        "data-target": "#addEnrollModal"
      });
      $("#schoolActivityModal").css("opacity", "0.3");
    } else if (target.hasClass("add-vlwe-btn")) {
      target.attr({
        "data-target": "#addVlweModal"
      });
    } else if (target.hasClass("vlweNameLink")) {
      target.attr({
        href: "#vlweModal",
        "data-target": "#vlweModal"
      });
      getDetailofVlweHour(dataid, vlweResponse);
    } else if (target.hasClass("searchStuTitleLink")) {
      target.attr({
        href: "#sStudentModal",
        "data-target": "#sStudentModal"
      });
      getDetailofSearchStudent(dataid, searchStudentResponse);
    } else if (target.hasClass("career-link")) {
      target.attr({
        href: "#careerLifeModal",
        "data-target": "#careerLifeModal"
      });
      for (let i = 0; i < careerObj.length; i++) {
        if (dataid == careerObj[i].ProjectID) {
          if (careerObj[i].SEnglishName) {
            engName = " (" + careerObj[i].SEnglishName + ") ";
          } else {
            engName = "";
          }
          var fullName =
            careerObj[i].SFirstName + engName + careerObj[i].SLastName;

          var isOther = true;
          for (let j = 0; j < capstoneCategory.length; j++) {
            if (careerObj[i].ProjectCategory == capstoneCategory[j].val) {
              isOther = false;
            }
          }

          var studentImg =
            "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
            careerObj[i].StudentID +
            ".jpg";
          $("#career-student-img").prop("src", studentImg);
          $("#career-studentId").val(careerObj[i].StudentID);
          var studentName =
            careerObj[i].SFirstName + " " + careerObj[i].SLastName;
          $("#career-student-name").val(studentName);
          var staffImg =
            "https://asset.bodwell.edu/OB4mpVpg/staff/" +
            careerObj[i].TeacherID +
            ".jpg";
          $("#career-approverPic").prop("src", staffImg);
          var staffName = careerObj[i].FirstName + " " + careerObj[i].LastName;
          $("#career-staff").val(staffName);
          $("#career-course").val(careerObj[i].SubjectID).change();
          $("#career-topic").val(careerObj[i].ProjectTopic);
          if (isOther == true) {
            $("#career-capCategory").val("Other (Specify below)").change();
            $("#career-capCategory-other").prop("type", "text");
            $("#career-capCategory-other").val(careerObj[i].ProjectCategory);
          } else {
            $("#career-capCategory").val(careerObj[i].ProjectCategory).change();
          }

          $("#career-preStatus-hidden").val(careerObj[i].ApprovalStatus);
          $("#career-status").val(careerObj[i].ApprovalStatus).change();
          $("#career-guide-fName").val(careerObj[i].MentorFName);
          $("#career-guide-lName").val(careerObj[i].MentorLName);
          $("#career-guide-email").val(careerObj[i].MentorEmail);
          $("#career-guide-phone").val(careerObj[i].MentorPhone);
          $("#career-guide-position").val(careerObj[i].MentorDesc);
          $("#career-description").val(careerObj[i].ProjectDesc);
          $("#career-teachercomment").val(careerObj[i].TeacherComment);
          $("#career-studentName-hidden").val(fullName);
          $("#career-staffName-hidden").val(
            careerObj[i].FirstName + " " + careerObj[i].LastName
          );

          var modifyText =
            careerObj[i].ModifyDate + " by " + careerObj[i].ModifyUserName;
          var createText =
            careerObj[i].CreateDate + " by " + careerObj[i].CreateUserName;

          $("#career-modifiedBy").html(modifyText);
          $("#career-createdBy").html(createText);
          $("#hidden-projectId").val(dataid);
        }
      }
      defaultForm = getAllValInForm("form-careerLife");
    } else if (target.hasClass("submit-capstone-btn")) {
      target.attr({
        "data-target": "#AddCareerLifeModal"
      });
    } else if (target.hasClass("leaveRequestMdlLink")) {
      target.attr({
        href: "#leaveRequestMdl",
        "data-target": "#leaveRequestMdl"
      });
      $('#leaveRequestMdlValidation input').val('');

      getDetailofLeaveRequest(dataid,leaveRequestResponse);

    } else if (target.hasClass("selfAssessmentsMdlLink")) {
      target.attr({
        href: "#selfAssessmentsModal",
        "data-target": "#selfAssessmentsModal"
      });
      var name = target.attr("data-name");
      var grade = target.attr("data-grade");
      getDetailofSelfassessments(dataid,name, grade,selfAssessmentsResponse);

    } else if (target.hasClass("LeaveBanDetailMdlLink")) {
      target.attr({
        href: "#LeaveBanDetailMdl",
        "data-target": "#LeaveBanDetailMdl"
      });
      getDetailofLeaveBan(dataid, studentLeaveBanResponse);

    } else if (target.hasClass("transcriptRequestMdlLink")) {
      target.attr({
        href: "#transcriptRequestModal",
        "data-target": "#transcriptRequestModal"
      });
      $("#transcriptRequestForm input").prop("disabled", true);
      getDetailofTranscriptRequest(dataid, transcriptRequestResponse);

    }
  }
);

$(document).on("click", "#actMdl-del-btn", function (event) {
  swal({
      title: "Are you sure?",
      text: "This will delete the activity record and all associated student participation hours!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn btn-info",
      cancelButtonClass: "btn btn-danger",
      confirmButtonText: "OK",
      buttonsStyling: false
    })
    .then(function (confirm) {
      if (confirm) {
        deleteSchoolActivity();
      }
    })
    .catch(swal.noop);
});

$(
  document
).on(
  "click",
  "#actMdl-back-btn, #delActMdl-cancel-btn, #sSubmitMdl-cancel-btn, #sStudentMdl-cancel-btn, #addSubmitMdl-cancel-btn, #cancel-search-btn, #cancel-searchReport-btn, #addActMdl-back-btn, #cancel-addEnroll-btn, #addVlweMdl-cancel-btn, #vlweMdl-cancel-btn, #career-cancel-btn, #addCareer-cancel-btn, #cancel-searchCareer-btn, #waModal-close-btn, #waDetailModal-close-btn, #waPopulateModal-close-btn",
  function (event) {
    var target = $(event.target);
    var id = target.attr("id");
    var modal = "";
    switch (id) {
      case "actMdl-back-btn":
        modal = "#schoolActivityModal";
        break;
      case "delActMdl-cancel-btn":
        modal = "#deleteActivityModal";
        break;
      case "sSubmitMdl-cancel-btn":
        modal = "#selfSubmitModal";
        break;
      case "sStudentMdl-cancel-btn":
        modal = "#sStudentModal";
        break;
      case "addSubmitMdl-cancel-btn":
        modal = "#addSelfSubmitModal";
        break;
      case "cancel-search-btn":
        modal = "#searchStudentModal";
        break;
      case "addActMdl-back-btn":
        modal = "#addActivityModal";
        break;
      case "cancel-addEnroll-btn":
        modal = "#addEnrollModal";
        break;
      case "addVlweMdl-cancel-btn":
        modal = "#addVlweModal";
        break;
      case "vlweMdl-cancel-btn":
        modal = "#vlweModal";
        break;
      case "cancel-searchReport-btn":
        modal = "#searchStudentModal_report";
        break;
      case "career-cancel-btn":
        modal = "#careerLifeModal";
        break;
      case "addCareer-cancel-btn":
        modal = "#AddCareerLifeModal";
        break;
      case "cancel-searchCareer-btn":
        modal = "#searchStudentModal_career";
        break;
      case "bogsCategoryMdl-cancel-btn":
        modal = "#bogsCategoryModal";
        break;
      case "bogsCategoryItemMdl-cancel-btn":
        modal = "#bogsCategoryItemModal";
        break;
      case "waDetailModal-close-btn":
        modal = "#weeklyAssignmentDetailModal";
        break;
      case "waModal-close-btn":
        modal = "#weeklyAssignmentModal";
        break;
      case "waPopulateModal-close-btn":
        modal = "#waPopulateModal";
        break;
      default:
        break;
    }
    $(modal).modal("hide");
  }
);

$(
  document
).on(
  "hidden.bs.modal",
  "#deleteActivityModal, #searchStudentModal, #addEnrollModal",
  function (event) {
    var id = event.currentTarget.id;
    var modal = "";
    switch (id) {
      case "deleteActivityModal":
        modal = "#schoolActivityModal";
        break;
      case "searchStudentModal":
        modal = "#addSelfSubmitModal";
        break;
      case "addEnrollModal":
        modal = "#schoolActivityModal";
        break;
      default:
        break;
    }
    $(modal).css("opacity", "");
  }
);

$(document).on("click", "#searchStuMdl-table tbody a", function () {
  $("#searchStudentModal").modal("hide");
});

function setFormValidation(id) {
  $(id).validate({
    onclick: false,
    rules: {
      name: {
        required: true
      },
      staffList: {
        required: true
      },
      category: {
        required: true
      },
      location: {
        required: true
      },
      start: {
        required: true
      },
      end: {
        required: true
      },
      hours: {
        required: true
      },
      student: {
        required: true
      },
      title: {
        required: true
      },
      sDate: {
        required: true
      },
      eDate: {
        required: true
      },
      staff1: {
        required: true
      },
      studentId: {
        required: true
      },
      supervisor: {
        required: true
      },
      Actvlwe: {
        required: true
      },
      maxEnroll: {
        required: true
      },
      vlwe: {
        required: true
      },
      course: {
        required: true
      },
      topic: {
        required: true
      },
      capCategory: {
        required: true
      },
      firstName: {
        required: true
      },
      lastName: {
        required: true
      },
      email: {
        required: true
      },
      position: {
        required: true
      },
      description: {
        required: true
      }
    },
    highlight: function (element) {
      $(element)
        .closest(".form-group")
        .removeClass("has-success")
        .addClass("has-danger");
      $(element)
        .closest(".form-check")
        .removeClass("has-success")
        .addClass("has-danger");
    },
    success: function (element) {
      $(element)
        .closest(".form-group")
        .removeClass("has-danger")
        .addClass("has-success");
      $(element)
        .closest(".form-check")
        .removeClass("has-danger")
        .addClass("has-success");
    },
    errorPlacement: function (error, element) {
      $(element).closest(".form-group").append(error);
    }
  });
}

function clearFormValidation(form_id) {
  var input_text = form_id + ' [type="text"]';
  $(input_text)
    .closest(".form-group")
    .removeClass("has-danger")
    .addClass("has-success");
  $(input_text)
    .closest(".form-check")
    .removeClass("has-danger")
    .addClass("has-success");

  var input_num = form_id + ' [type="number"]';
  $(input_num)
    .closest(".form-group")
    .removeClass("has-danger")
    .addClass("has-success");
  $(input_num)
    .closest(".form-check")
    .removeClass("has-danger")
    .addClass("has-success");

  var input_num = form_id + ' [type="email"]';
  $(input_num)
    .closest(".form-group")
    .removeClass("has-danger")
    .addClass("has-success");
  $(input_num)
    .closest(".form-check")
    .removeClass("has-danger")
    .addClass("has-success");

  var input_num = form_id + " textarea";
  $(input_num)
    .closest(".form-group")
    .removeClass("has-danger")
    .addClass("has-success");
  $(input_num)
    .closest(".form-check")
    .removeClass("has-danger")
    .addClass("has-success");

  var input_num = form_id + " select";
  $(input_num)
    .closest(".form-group")
    .removeClass("has-danger")
    .addClass("has-success");
  $(input_num)
    .closest(".form-check")
    .removeClass("has-danger")
    .addClass("has-success");
  $(".error").remove();
}

function parseHourDecimal(id) {
  var val = $(id).val();
  var parsVal = parseFloat(val).toFixed(1);
  $(id).val(parsVal);
}

function parseMaxEnrollment(id) {
  var val = $(id).val();
  var parsVal = parseInt(val);
  $(id).val(parsVal);
}

function clearForm(table_id) {
  $(table_id)
    .find('input[type="text"], input[type="number"], textarea,select')
    .val("");
}

function clearImg(id) {
  $(id).attr("src", "../img/user.png");
}

function getFullStaffName(id) {
  var prefix;
  var x = $("#" + id).val();
  for (var i = 0; i < globalApprovalList.length; i++) {
    if (globalApprovalList[i].StaffID == x) {
      if (globalApprovalList[i].Sex == "F") {
        prefix = "Ms. ";
      } else {
        prefix = "Mr. ";
      }
      $("#sSubmitMdl-apprStaff-FullName").val(
        prefix + globalApprovalList[i].FullName
      );
    }
  }
}
