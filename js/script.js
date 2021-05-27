var globalSemesterList;
var globalLoginUserName;

function showCurrentTerm() {
  var tr;
  $.ajax({
    url: "../ajax_php/a.currentterm.php",
    type: "POST",
    dataType: "json",
    async: false,
    success: function (response) {
      globalSemesterList = response;
      console.log(response);
      if (response.result == 0) {
        console.log("IT");
      } else {
        $(".term-select").append(
          '<option value="' +
          response[0].SemesterID +
          '">' +
          response[0].SemesterName +
          "</option>"
        );
        $(".dashboard-semesterName").html(response[0].SemesterName);
        $(".dashboard-termStatus").html(response[0].termStatus);
        $(".dashboard-sDate").html(response[0].StartDate);
        $(".dashboard-mDate").html(response[0].MidCutOffDate);
        $(".dashboard-eDate").html(response[0].EndDate);
        var EndDate = new Date(response[0].EndDate).getTime();
        var StartDate = new Date(response[0].StartDate).getTime();
        var Today = new Date().getTime();
        var Total = EndDate - StartDate;
        var per = EndDate - Today;
        var param = (per / Total) * 100;
        $(".termId").val(response[0].SemesterID);
        $(".term-status").html(
          response[0].SemesterName + " - " + response[0].termStatus
        );
        makeProgress(param.toFixed(2));
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function showMyProfile() {
  $.ajax({
    url: "../ajax_php/a.showMyProfile.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        $(".profile-staffId").val(response[0].StaffID);
        var imgSrc =
          "https://asset.bodwell.edu/OB4mpVPg/staff/" +
          response[0].StaffID +
          ".jpg";
        $(".staff-img").attr("src", imgSrc);
        $(".profile-firstname").val(response[0].FirstName);
        $(".profile-lastname").val(response[0].LastName);
        var fullName = response[0].FirstName + " " + response[0].LastName;
        globalLoginUserName = fullName;
        $(".dashboard-username").html(fullName);
        $(".dashboard-position").html(response[0].PositionTitle);
        $(".label-floating").addClass("is-focused");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function dashBoard_total_activities() {
  $.ajax({
    url: "../ajax_php/a.getTotalActivites.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        console.log("IT");
      } else {
        var totalActivity = 0;
        for (var i = 0; i < response.length; i++) {
          totalActivity += parseInt(response[i].NumberOfActivity);
          $(".dashboard-" + response[i].Title + "-activities").html(
            response[i].NumberOfActivity
          );
        }
        $(".dashboard-TOTAL-activities").html(totalActivity);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function updateSelfSubmitHours(val, chk) {
  console.log(val);
  console.log(chk);
  $.ajax({
    url: "../ajax_php/a.updateSelfSubmitHours.php",
    type: "POST",
    dataType: "json",
    data: {
      studentActivityId: val[0].studentActivityId,
      studentId: val[0].studentId,
      info: val[0].info,
      type: chk,
    },
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        console.log("IT");
      } else {
        showSwal("success");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function addSelfSubmitHoursByStaff() {
  var activityStudentId = $("#addSubmitMdl-studentId").val();
  var activityName = $("#addSubmitMdl-title").val();
  var activityCategory = $("#addSubmitMdl-category").val();
  var activityLocation = $("#addSubmitMdl-location").val();
  var activitySDate = $("#addSubmitMdl-sDate").val();
  var activityEDate = $("#addSubmitMdl-eDate").val();
  var activityHours = $("#addSubmitMdl-hours").val();
  var activityVLWE = $('input[name="vlwe"]:checked').val();
  var activityApprover = $("#addSubmitMdl-apprStaff").val();
  var activityComment1 = $("#addSubmitMdl-comment1").val();
  var activityComment2 = $("#addSubmitMdl-comment2").val();
  var activityComment3 = $("#addSubmitMdl-comment3").val();
  $.ajax({
    url: "../ajax_php/a.addActivityRecord.php",
    type: "POST",
    dataType: "json",
    data: {
      activityStudentId: activityStudentId,
      activityName: activityName,
      activityCategory: activityCategory,
      activityLocation: activityLocation,
      activitySDate: activitySDate,
      activityEDate: activityEDate,
      activityHours: activityHours,
      activityVLWE: activityVLWE,
      activityApprover: activityApprover,
      activityComment1: activityComment1,
      activityComment2: activityComment2,
      activityComment3: activityComment3,
    },
    success: function (response) {
      if (response[0].result == 1) {
        location.reload();
      } else {
        showSwal("error", "Something went wrong!");
        location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxtoApprovalList(id) {
  $.ajax({
    url: "../ajax_php/a.ApprovalList.php",
    type: "POST",
    dataType: "json",
    async: false,
    success: function (response) {
      globalApprovalList = response;
      for (var i = 0; i < response.length; i++) {
        let staffId = response[i].StaffID;
        let fullName = response[i].FullName;
        let positionTitle = response[i].PositionTitle2;
        $(id).append(
          '<option value="' +
          staffId +
          '">' +
          fullName +
          " (" +
          positionTitle +
          ")" +
          "</option>"
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getDetailofActivity(dataid, globalres) {
  for (let i = 0; i < globalres.length; i++) {
    let activityDetail = globalres[i];
    let enrollStatus;
    if (activityDetail.activityId == dataid) {
      $("#actMdl-ActivityID").val(activityDetail.activityId);
      $("#actMdl-title").val(activityDetail.title);
      $("#actMdl-description").val(activityDetail.description);
      $("#actMdl-location").val(activityDetail.location);
      $("#actMdl-meetPlace").val(activityDetail.MeetingPlace);
      $("#actMdl-start").val(activityDetail.startDate);
      $("#actMdl-end").val(activityDetail.endDate);
      $("#actMdl-hours").val(activityDetail.baseHours);
      $("#actMdl-stf1").val(activityDetail.staffId).change();
      if (activityDetail.staffId2) {
        if (activityDetail.staffId2.replace(/ /g, "") == "") {
          $("#actMdl-stf2").val("").change();
        } else {
          $("#actMdl-stf2").val(activityDetail.staffId2).change();
        }
      } else {
        $("#actMdl-stf2").val("").change();
      }

      $("#actMdl-category").val(activityDetail.ActivityCategory).change();
      $("#actMdl-enrType").val(activityDetail.EnrollType).change();
      $("#actMdl-maxEnroll").val(activityDetail.maxEnroll);
      if (activityDetail.workExp == 1) {
        $("#actMdl-vlwe-n").attr("checked", false);
        $("#actMdl-vlwe-y").attr("checked", true);
      } else {
        $("#actMdl-vlwe-y").attr("checked", false);
        $("#actMdl-vlwe-n").attr("checked", true);
      }
      if (activityDetail.ENROLLMENTSTATUS == 1) {
        enrollStatus = "Closed";
      } else {
        enrollStatus = "In Progress";
      }
      var modifyTxt =
        activityDetail.ModifyDate + " by " + activityDetail.ModifyUserName;
      var createTxt =
        activityDetail.CreateDate + " by " + activityDetail.CreateUserName;
      $("#actMdl-modifiedBy").html(modifyTxt);
      $("#actMdl-createdBy").html(createTxt);
      $("#actMdl-enrSts").html(enrollStatus);
      $(".actMdl-term").html(activityDetail.SemesterName);
      GetEnrollMemberByActivityId(
        activityDetail.activityId,
        activityDetail.termId
      );
    }
  }
}


function getDetailofTranscriptRequest(dataid, globalres) {
  $("#physicalCopy-extra").hide();
  for (let i = 0; i < globalres.length; i++) {
    let transcriptRequestDetail = globalres[i];
    if (transcriptRequestDetail.RequestID == dataid) {
      $("#RequestID").val(dataid);
      $("#transcriptRequestModal-student-img").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
        transcriptRequestDetail.StudentID +
        ".jpg"
      );
      $('#transcriptRequestModal-preStatus-hidden').val(transcriptRequestDetail.Status);
      var fulln = createFullName(transcriptRequestResponse.EnglishName, transcriptRequestDetail.FirstName, transcriptRequestDetail.LastName);
      $("#studentID").val(transcriptRequestDetail.StudentID);
      $("#studentName").val(fulln);
      $("#requestDate").val(transcriptRequestDetail.RequestDate);
      $("#deadLine").val(transcriptRequestDetail.Deadline);
      $("#applyTo").val(transcriptRequestDetail.ApplyTo);
      $("#aplicationNumber").val(transcriptRequestDetail.ApplicationID);
      $("#UniversityName").val(transcriptRequestDetail.SchoolName);
      $("#Address").val(transcriptRequestDetail.Address);

      $("#transcriptRequestModal-status").val(transcriptRequestDetail.Status).change();
      $("#transcriptRequestModal-paid").val(transcriptRequestDetail.Paid).change();

      if (transcriptRequestDetail.CopyType == 'First Copy') {
        $("#copytype-in").attr("checked", true);
        $("#copytype-up").attr("checked", false);
      } else {
        $("#copytype-in").attr("checked", false);
        $("#copytype-up").attr("checked", true);
      }

      if (transcriptRequestDetail.PhysicalCopy == 'Y') {
        $(".physicalCopy-extra").show();
        $("#physicalcopy-n").attr("checked", false);
        $("#physicalcopy-y").attr("checked", true);
      } else {
        $(".physicalCopy-extra").hide();
        $("#physicalcopy-y").attr("checked", false);
        $("#physicalcopy-n").attr("checked", true);
      }

      $("input[name=mailingMethod][value='"+transcriptRequestDetail.MailingMethod+"']").prop("checked",true);



    }
  }
}

function GetEnrollMemberByActivityId(dataid, termId) {
  $("#actMdl-student-table tbody").html("");
  $.ajax({
    url: "../ajax_php/a.getEnrollMemberByStudentId.php",
    type: "POST",
    dataType: "json",
    data: {
      SemesterID: termId,
      ActivityId: dataid,
    },
    success: function (response) {
      if (response.result == 0) {} else {
        var tr;
        var chkbox;
        var engName;
        for (let i = 0; i < response.length; i++) {
          if (response[i].activityStatus !== "90") {
            chkbox =
              '<input class="individual-activity-member-chk" type="checkbox" value="' +
              response[i].studentActivityId +
              '">';
          } else {
            chkbox = "";
          }

          if (response[i].EnglishName) {
            engName = " (" + response[i].EnglishName + ")";
          } else {
            engName = "";
          }
          var fullName =
            response[i].FirstName + " " + response[i].LastName + engName;

          tr +=
            "<tr><td class='text-center'>" +
            chkbox +
            '</td><td class="text-center"><span class="redirect-admin-studentid">' +
            response[i].studentId +
            "</span></td><td>" +
            fullName +
            "</td><td class='text-center'>" +
            GetStatusIcon(response[i].activityStatus) +
            "</td></tr>";
        }
        $("#actMdl-student-table tbody").html(tr);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getDetailofSelfSubmithour(dataid, selfsubmitResponse) {
  for (let i = 0; i < selfsubmitResponse.length; i++) {
    let selfsubmitDetail = selfsubmitResponse[i];
    var fullName;
    if (selfsubmitDetail.StudentActivityID == dataid) {
      // $(".sSubmitMdl-term").html(selfsubmitDetail.SemesterName);
      if (selfsubmitDetail.EnglishName) {
        fullName =
          selfsubmitDetail.FirstName +
          " (" +
          selfsubmitDetail.EnglishName +
          ") " +
          selfsubmitDetail.LastName;
      } else {
        fullName = selfsubmitDetail.FirstName + " " + selfsubmitDetail.LastName;
      }
      $("#sSubmitMdl-student-name").val(fullName);
      $("#sSubmitMdl-student-img").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
        selfsubmitDetail.StudentID +
        ".jpg"
      );
      $("#sSubmitMdl-studentId").val(selfsubmitDetail.StudentID);
      $("#sSubmitMdl-studentId-hidden").val(selfsubmitDetail.StudentID);
      $("#sSubmitMdl-studentActivityId-hidden").val(
        selfsubmitDetail.StudentActivityID
      );
      $("#sSubmitMdl-title").val(selfsubmitDetail.Title);
      $("#sSubmitMdl-description").val(selfsubmitDetail.Body);
      $("#sSubmitMdl-category").val(selfsubmitDetail.ActivityCategory).change();
      $("#sSubmitMdl-description").val(selfsubmitDetail.Body);
      if (selfsubmitDetail.VLWE == 1) {
        $("#sSubmitMdl-vlwe-n").attr("checked", false);
        $("#sSubmitMdl-vlwe-y").attr("checked", true);
      } else {
        $("#sSubmitMdl-vlwe-y").attr("checked", false);
        $("#sSubmitMdl-vlwe-n").attr("checked", true);
      }
      $("#sSubmitMdl-location").val(selfsubmitDetail.Location);
      $("#sSubmitMdl-sDate").val(selfsubmitDetail.SDate.substring(0, 10));
      $("#sSubmitMdl-eDate").val(selfsubmitDetail.EDate.substring(0, 10));
      if (selfsubmitDetail.Hours == ".5") {
        var hours = "0.5";
      } else {
        var hours = selfsubmitDetail.Hours;
      }
      $("#sSubmitMdl-hours").val(hours);
      $("#sSubmitMdl-witness").val(selfsubmitDetail.SelfSubmitWitness);
      $("#sSubmitMdl-apprStaff").val(selfsubmitDetail.ApproverStaffID).change();
      var imgsrc =
        "https://asset.bodwell.edu/OB4mpVpg/staff/" +
        selfsubmitDetail.ApproverStaffID +
        ".jpg";
      $("#sSubmitMdl-approverPic").attr("src", imgsrc);
      $("#sSubmitMdl-preStatus-hidden").val(selfsubmitDetail.ActivityStatus);
      $("#sSubmitMdl-status").val(selfsubmitDetail.ActivityStatus).change();
      $("#sSubmitMdl-aprComment").val(selfsubmitDetail.ApproverComment1);
      $("#sSubmitMdl-stuComment1").val(selfsubmitDetail.SELFComment1);
      $("#sSubmitMdl-stuComment2").val(selfsubmitDetail.SELFComment2);
      $("#sSubmitMdl-stuComment3").val(selfsubmitDetail.SELFComment3);
      var ModifyUserName = getUserFullName(selfsubmitDetail.ModifyUserID);
      var CreateUserName = getUserFullName(selfsubmitDetail.CreateUserID);
      var modifyTxt = selfsubmitDetail.ModifyDate + " by " + ModifyUserName;
      var createTxt = selfsubmitDetail.CreateDate + " by " + CreateUserName;
      $("#sSubmitMdl-modifiedBy").html(modifyTxt);
      $("#sSubmitMdl-createdBy").html(createTxt);
    }
  }
}

function getDetailofSearchStudent(dataid, searchStudentResponse) {
  for (let i = 0; i < searchStudentResponse.length; i++) {
    let searchStudentDetail = searchStudentResponse[i];
    var fullName;
    if (searchStudentDetail.StudentActivityID == dataid) {
      $(".sStudentMdl-term").html(searchStudentDetail.SemesterName);
      if (searchStudentDetail.EnglishName) {
        fullName =
          searchStudentDetail.FirstName +
          " (" +
          searchStudentDetail.EnglishName +
          ") " +
          searchStudentDetail.LastName;
      } else {
        fullName =
          searchStudentDetail.FirstName + " " + searchStudentDetail.LastName;
      }
      $("#sStudentMdl-student-name").val(fullName);
      $("#sStudentMdl-student-img").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
        searchStudentDetail.StudentID +
        ".jpg"
      );
      $("#sStudentMdl-studentId").val(searchStudentDetail.StudentID);
      $("#sStudentMdl-studentId-hidden").val(searchStudentDetail.StudentID);
      $("#sStudentMdl-studentActivityId-hidden").val(
        searchStudentDetail.StudentActivityID
      );
      $("#sStudentMdl-title").val(searchStudentDetail.Title);
      $("#sStudentMdl-description").val(searchStudentDetail.Body);
      $("#sStudentMdl-category")
        .val(searchStudentDetail.ActivityCategory)
        .change();
      $("#sStudentMdl-description").val(searchStudentDetail.Body);
      if (searchStudentDetail.VLWE == 1) {
        $("#sStudentMdl-vlwe-n").attr("checked", false);
        $("#sStudentMdl-vlwe-y").attr("checked", true);
      } else {
        $("#sStudentMdl-vlwe-y").attr("checked", false);
        $("#sStudentMdl-vlwe-n").attr("checked", true);
      }
      $("#sStudentMdl-location").val(searchStudentDetail.Location);
      $("#sStudentMdl-sDate").val(searchStudentDetail.SDate.substring(0, 10));
      $("#sStudentMdl-eDate").val(searchStudentDetail.EDate.substring(0, 10));
      if (searchStudentDetail.Hours == ".5") {
        var hours = "0.5";
      } else {
        var hours = searchStudentDetail.Hours;
      }
      $("#sStudentMdl-hours").val(hours);
      $("#sStudentMdl-witness").val(searchStudentDetail.SelfSubmitWitness);
      $("#sStudentMdl-apprStaff")
        .val(searchStudentDetail.ApproverStaffID)
        .change();
      var imgsrc =
        "https://asset.bodwell.edu/OB4mpVpg/staff/" +
        searchStudentDetail.ApproverStaffID +
        ".jpg";
      $("#sStudentMdl-approverPic").attr("src", imgsrc);
      $("#sStudentMdl-preStatus-hidden").val(
        searchStudentDetail.ActivityStatus
      );
      $("#sStudentMdl-status").val(searchStudentDetail.ActivityStatus).change();
      $("#sStudentMdl-aprComment").val(searchStudentDetail.ApproverComment1);
      $("#sStudentMdl-stuComment1").val(searchStudentDetail.SELFComment1);
      $("#sStudentMdl-stuComment2").val(searchStudentDetail.SELFComment2);
      $("#sStudentMdl-stuComment3").val(searchStudentDetail.SELFComment3);
      var ModifyUserName = getUserFullName(searchStudentDetail.ModifyUserID);
      var CreateUserName = getUserFullName(searchStudentDetail.CreateUserID);
      var modifyTxt = searchStudentDetail.ModifyDate + " by " + ModifyUserName;
      var createTxt = searchStudentDetail.CreateDate + " by " + CreateUserName;
      $("#sStudentMdl-modifiedBy").html(modifyTxt);
      $("#sStudentMdl-createdBy").html(createTxt);
    }
  }
}

function searchStudentByName(id) {
  var input = $(id).val();

  $("#searchStuMdl-table tbody").html("");
  if (input == "") {
    showSwal("error", "Please enter search keyword(s)");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getStudentListFromSearch.php",
    type: "POST",
    dataType: "json",
    data: {
      param: input,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("No data");
      } else {
        var tr;
        for (let i = 0; i < response.length; i++) {
          var name = "";
          if (response[i].EnglishName) {
            name =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") " +
              response[i].LastName;
          } else {
            name = response[i].FirstName + " " + response[i].LastName;
          }
          tr +=
            '<tr class="hoverShowPic searchStudentTr" data-id="' +
            response[i].StudentID +
            '" data-full-name="' +
            name +
            '"><td>' +
            name +
            "</td></tr>";
        }
        $("#searchStuMdl-table tbody").html(tr);
        $("#searchStudentModal").modal();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function searchStudentByNameV2(id) {
  var input = $(id).val();

  $("#searchStuMdl-table tbody").html("");
  if (input == "") {
    showSwal("error", "Please enter search keyword(s)");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getStudentListFromSearch.php",
    type: "POST",
    dataType: "json",
    data: {
      param: input,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("No data");
      } else {
        var tr;
        for (let i = 0; i < response.length; i++) {
          var name = "";
          if (response[i].EnglishName) {
            name =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") " +
              response[i].LastName;
          } else {
            name = response[i].FirstName + " " + response[i].LastName;
          }
          tr +=
            '<tr class="hoverShowPic searchStudentTrV2" data-id="' +
            response[i].StudentID +
            '" data-full-name="' +
            name +
            '"><td>' +
            name +
            "</td></tr>";
        }
        $("#searchStuMdl-table tbody").html(tr);
        $("#searchStudentModal").modal();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function searchStudentByName_report(id) {
  var input = $(id).val();
  $("#searchStuMdlReport-table tbody").html("");
  if (input == "") {
    showSwal("error", "Please enter search keyword(s)");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getStudentListFromSearchForReport.php",
    type: "POST",
    dataType: "json",
    data: {
      param: input,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("No data");
      } else {
        var tr;
        for (let i = 0; i < response.length; i++) {
          var name = "";
          if (response[i].EnglishName) {
            name =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") " +
              response[i].LastName;
          } else {
            name = response[i].FirstName + " " + response[i].LastName;
          }
          tr +=
            '<tr data-id="' +
            response[i].StudentID +
            '" data-full-name="' +
            name +
            '" data-status="' +
            response[i].CurrentStatus +
            '"><td class="text-center">' +
            response[i].StudentID +
            "</td><td>" +
            name +
            "</td><td class='text-center'>" +
            response[i].CurrentStatus +
            "</td></tr>";
        }
        $("#searchStuMdlReport-table tbody").html(tr);
        $("#searchStudentModal_report").modal();
        $("#pageId-comeFrom").val(id);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function searchStudentByName_career(id) {
  var input = $(id).val();
  $("#searchStuMdlCareer-table tbody").html("");
  if (input == "") {
    showSwal("error", "Please enter search keyword(s)");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getStudentListFromSearchForCareer.php",
    type: "POST",
    dataType: "json",
    data: {
      param: input,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("No data");
      } else {
        for (let i = 0; i < response.length; i++) {
          var name = "";
          var tr;
          if (response[i].EnglishName) {
            name =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") " +
              response[i].LastName;
          } else {
            name = response[i].FirstName + " " + response[i].LastName;
          }

          if (response[i].courseId == 0) {
            tr +=
              '<tr data-id="' +
              response[i].StudentID +
              '" data-full-name="' +
              name +
              '" data-course-id="' +
              response[i].courseId +
              '" class="grey-backbround cursor-notAllowed"><td class="text-center">' +
              response[i].StudentID +
              "</td><td>" +
              name +
              "</td><td class='text-center'>" +
              response[i].courseName +
              "</td></tr>";
          } else {
            tr +=
              '<tr data-id="' +
              response[i].StudentID +
              '" data-full-name="' +
              name +
              '" data-course-id="' +
              response[i].courseId +
              '"><td class="text-center">' +
              response[i].StudentID +
              "</td><td>" +
              name +
              "</td><td class='text-center'>" +
              response[i].courseName +
              "</td></tr>";
          }
        }
        $("#searchStuMdlCareer-table tbody").html(tr);
        $("#searchStudentModal_career").modal();
        $("#pageId-comeFrom").val(id);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function editSchoolActivityDetail(formArr) {
  // return;
  $.ajax({
    url: "../ajax_php/a.editSchoolActivityDetail.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        showSwal("success");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function updateStudentActivityStatus(val, chk) {
  var activityId = $("#actMdl-ActivityID").val();
  $.ajax({
    url: "../ajax_php/a.UpdateStudentActivityStatus.php",
    type: "POST",
    dataType: "json",
    data: {
      studentActivityId: val,
      type: chk,
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        showSwal("success");
        updateActivityEnrollMember(activityId);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function updateActivityEnrollMember(val) {
  $.ajax({
    url: "../ajax_php/a.updateActivityEnrollMember.php",
    type: "POST",
    dataType: "json",
    data: {
      ActivityId: val,
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        console.log(response);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function actMdlsearchStudentByName() {
  var input = $("#addEnr-stu-text").val();
  $("#addEnrollMdl-table tbody").html("");
  if (input == "") {
    showSwal("error", "Please enter search keyword(s)");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getStudentListFromSearch.php",
    type: "POST",
    dataType: "json",
    data: {
      param: input,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("No data");
      } else {
        var tr;
        for (let i = 0; i < response.length; i++) {
          var fullName = response[i].FirstName + " " + response[i].LastName;
          var name = "";
          if (response[i].EnglishName.length > 0) {
            name =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") " +
              response[i].LastName;
          } else {
            name = response[i].FirstName + " " + response[i].LastName;
          }
          tr +=
            '<tr data-id="' +
            response[i].StudentID +
            '" data-full-name="' +
            fullName +
            '"><td>' +
            name +
            "</td></tr>";
        }
        $("#addEnrollMdl-table tbody").html(tr);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function insertActivityRecordByStaff(dataid) {
  var activityId = $("#actMdl-ActivityID").val();
  $.ajax({
    url: "../ajax_php/a.insertActivityRecordByStaff.php",
    type: "POST",
    dataType: "json",
    data: {
      studentId: dataid,
      activityId: activityId,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        $("#addEnrollModal").modal("toggle");
        updateActivityEnrollMember(activityId);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function deleteSchoolActivity() {
  var ActivityId = $("#actMdl-ActivityID").val();
  $.ajax({
    url: "../ajax_php/a.deleteSchoolActivity.php",
    type: "POST",
    dataType: "json",
    data: {
      ActivityId: ActivityId,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        showSwal("success");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function addAcitivityByStaff(formArr) {
  $.ajax({
    url: "../ajax_php/a.addAcitivityByStaff.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        showSwal("success");
        // location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function editSelfsubmitByStaff(formArr) {
  $.ajax({
    url: "../ajax_php/a.editSelfsubmitByStaff.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      toggleSpinner();
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        showSwal("success");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function editSearchStudentByStaff(formArr) {
  $.ajax({
    url: "../ajax_php/a.editSelfsubmitByStaff.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      toggleSpinner();
      if (response.result == 0) {
        showSwal2("error", "Something went wrong!");
      } else {
        showSwal2("success", null, "#sStudentModal");
        var fullName = $(".report-redirect-a").html();
        var id = $(".searchstudent-session-sid").val();
        createSearchStudentTable(id, fullName, globalSemesterList);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getUserFullName(id) {
  var firstCharid = id.charAt(0);
  var name;
  if (!isNaN(firstCharid)) {
    var type = "student";
  } else {
    var type = "staff";
  }

  $.ajax({
    url: "../ajax_php/a.getUserFullName.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      id: id,
      type: type,
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("contact IT");
      } else {
        name = response[0].FullName;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
  return name;
}

function addVlweHoursByStaff() {
  $("#addVlweMdl-add-btn").attr("disabled", "disabled");
  var vlweStudentId = $("#addVlweMdl-studentId").val();
  var vlweName = $("#addVlweMdl-title").val();
  var vlweDescription = $("#addVlweMdl-description").val();
  var vlweCategory = 21;
  var vlweLocation = $("#addVlweMdl-location").val();
  var vlweSDate = $("#addVlweMdl-date").val();
  var vlweHours = $("#addVlweMdl-hours").val();
  var vlweVLWE = 1;
  var vlweSupervisor = $("#addVlweMdl-supervisor").val();
  var vlweApprover = $("#addVlweMdl-apprStaff").val();
  var vlweComment = $("#addVlweMdl-comment").val();
  $.ajax({
    url: "../ajax_php/a.addVlweRecord.php",
    type: "POST",
    dataType: "json",
    data: {
      vlweStudentId: vlweStudentId,
      vlweName: vlweName,
      Body: vlweDescription,
      vlweCategory: vlweCategory,
      vlweLocation: vlweLocation,
      vlweSDate: vlweSDate,
      vlweHours: vlweHours,
      vlweVLWE: vlweVLWE,
      vlweSupervisor: vlweSupervisor,
      vlweApprover: vlweApprover,
      vlweComment: vlweComment,
    },
    success: function (response) {
      if (response[0].result == 1) {
        location.reload();
      } else {
        showSwal("error", "Something went wrong!");
        location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getDetailofVlweHour(dataid, vlweResponse) {
  for (let i = 0; i < vlweResponse.length; i++) {
    let vlweDetail = vlweResponse[i];
    if (vlweDetail.StudentActivityID == dataid) {
      $(".vlweMdl-term").html(vlweDetail.SemesterName);
      $("#vlweMdl-student-name").html(
        vlweDetail.FirstName + " " + vlweDetail.LastName
      );
      $("#vlweMdl-student-img").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
        vlweDetail.StudentID +
        ".jpg"
      );
      $("#vlweMdl-studentId").html(vlweDetail.StudentID);
      $("#vlweMdl-studentId-hidden").val(vlweDetail.StudentID);
      $("#vlweMdl-studentActivityId-hidden").val(vlweDetail.StudentActivityID);
      $("#vlweMdl-title").val(vlweDetail.Title);
      $("#vlweMdl-description").val(vlweDetail.Body);
      $("#vlweMdl-location").val(vlweDetail.Location);
      $("#vlweMdl-date").val(vlweDetail.SDate);
      $("#vlweMdl-hours").val(vlweDetail.Hours);
      $("#vlweMdl-supervisor").val(vlweDetail.VLWESupervisor);
      $("#vlweMdl-apprStaff").val(vlweDetail.ApproverStaffID).change();
      var selfIcon = GetStatusIcon(vlweDetail.ActivityStatus);
      $("#vlweMdl-status").html(selfIcon);
      $("#vlweMdl-comment").val(vlweDetail.Comment);
      var ModifyUserName = getUserFullName(vlweDetail.ModifyUserID);
      var CreateUserName = getUserFullName(vlweDetail.CreateUserID);
      var modifyTxt = vlweDetail.ModifyDate + " by " + ModifyUserName;
      var createTxt = vlweDetail.CreateDate + " by " + CreateUserName;
      $("#vlweMdl-modifiedBy").html(modifyTxt);
      $("#vlweMdl-createdBy").html(createTxt);
    }
  }
}

function getDetailofLeaveRequest(dataid, leaveRequestResponse) {


  for (let i = 0; i < leaveRequestResponse.length; i++) {
    let leaveRequestDetail = leaveRequestResponse[i];
    if (leaveRequestDetail.LeaveID == dataid) {
      // alert(leaveRequestDetail.ApprovalStaff);
      $("#leaveRequestMdl-apprStaff").val(leaveRequestDetail.ApprovalStaff).change();

      $("#leaveRequestMdl-student-name").val(leaveRequestDetail.StudentFullName);
      $("#leaveRequestMdl-student-img").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/student/bhs" +
        leaveRequestDetail.StudentID +
        ".jpg"
      );
      $("#leaveRequestMdl-approverPic").attr(
        "src",
        "https://asset.bodwell.edu/OB4mpVpg/staff/" +
        leaveRequestDetail.ApprovalStaff +
        ".jpg"
      );
      $("#leaveRequestMdl-studentId").val(leaveRequestDetail.StudentID);
      $("#leaveRequestMdl-studentId-hidden").val(leaveRequestDetail.StudentID);
      $("#leaveRequestMdl-leaveId-hidden").val(leaveRequestDetail.LeaveID);

      $("#leaveRequestMdl-status").val(leaveRequestDetail.LeaveStatus).change();
      $("#leaveRequestMdl-sDate").val(leaveRequestDetail.SDate);
      $("#leaveRequestMdl-eDate").val(leaveRequestDetail.EDate);

      $("#leaveRequestMdl-InDate").val(leaveRequestDetail.InDate);
      $("#leaveRequestMdl-OutDate").val(leaveRequestDetail.OutDate);
      if(leaveRequestDetail.InDate){
        $('#leaveRequestMdl-InDate').prop('disabled', true );
      } else {
        $('#leaveRequestMdl-InDate').prop('disabled', false );
      }

      if(leaveRequestDetail.OutDate){
        $('#leaveRequestMdl-OutDate').prop('disabled', true);
      } else{
        $('#leaveRequestMdl-OutDate').prop('disabled', false );
      }

      $("#leaveRequestMdl-Reason").val(leaveRequestDetail.Reason).change();
      $("#leaveRequestMdl-ToDo").val(leaveRequestDetail.ToDo);
      $("#leaveRequestMdl-Comment").val(leaveRequestDetail.Comment);
      $("#leaveRequestMdl-stfComment").val(leaveRequestDetail.StaffComment);

      var ModifyUserName = getUserFullName(leaveRequestDetail.ModifyUserID);
      var CreateUserName = getUserFullName(leaveRequestDetail.CreateUserID);
      var modifyTxt = leaveRequestDetail.ModifyDate + " by " + ModifyUserName;
      var createTxt = leaveRequestDetail.CreateDate + " by " + CreateUserName;
      $("#leaveRequestMdl-modifiedBy").html(modifyTxt);
      $("#leaveRequestMdl-createdBy").html(createTxt);
    }
  }
}

function editVlweByStaff(formArr) {
  $.ajax({
    url: "../ajax_php/a.editVlweByStaff.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      if (response.result == 0) {
        showSwal("error", "Something went wrong!");
      } else {
        showSwal("success");
        location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function generateTermList(select, globalSemesterList) {
  var options = "";
  options += '<option value="">All</option>';
  for (let i = 0; i < globalSemesterList.length; i++) {
    if (i == 0) {
      options +=
        '<option value="' +
        globalSemesterList[i].SemesterID +
        '" selected>' +
        globalSemesterList[i].SemesterName +
        "</option>";
    } else {
      options +=
        '<option value="' +
        globalSemesterList[i].SemesterID +
        '">' +
        globalSemesterList[i].SemesterName +
        "</option>";
    }

  }
  $(select).html(options);
}

function generateTermListForCareer(select, globalSemesterList, SemesterID) {
  var options = "";
  options += '<option value="">All</option>';
  for (let i = 0; i < globalSemesterList.length; i++) {
    if (globalSemesterList[i].SemesterID >= SemesterID) {
      options +=
        '<option value="' +
        globalSemesterList[i].SemesterID +
        '">' +
        globalSemesterList[i].SemesterName +
        "</option>";
    }
  }
  $(select).html(options);
}

function redirectToSp(studentId) {
  if (!studentId) {
    alert("Try Again");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getUserAuth.php",
    type: "POST",
    dataType: "json",
    data: {
      studentId: studentId,
    },
    success: function (response) {
      // console.log(response);
      if (response.result == 0) {
        alert("Error");
      } else {
        openWindowWithPost(
          "https://student.bodwell.edu/ajax_php/a.login_process.php", {
            log: response[0].LoginID,
            pwd: response[0].PW3,
            chk: "admin",
            staffId: response[0].staffId,
          }
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function redirectToMc(studentId) {
  if (!studentId) {
    alert("Try Again");
    return;
  }
  $.ajax({
    url: "../ajax_php/a.getUserAuth.php",
    type: "POST",
    dataType: "json",
    data: {
      studentId: studentId,
    },
    success: function (response) {
      if (response.result == 0) {
        alert("Error");
      } else {
        openWindowWithPost(
          "https://mychild.bodwell.edu/ajax_php/a.login_process.php", {
            log: response[0].LoginIDParent,
            pwd: response[0].PW2,
            chk: "admin",
            staffId: response[0].staffId,
          }
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxToCareerStaffList(id, termId) {
  $.ajax({
    url: "../ajax_php/a.careerLifeStaffList.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      SemesterID: termId,
    },
    success: function (response) {
      for (var i = 0; i < response.length; i++) {
        let staffId = response[i].TeacherID;
        let fullName = response[i].FullName;
        $(id).append(
          '<option value="' + staffId + '">' + fullName + "</option>"
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function openWindowWithPost(url, data) {
  var form = document.createElement("form");
  form.target = "_blank";
  form.method = "POST";
  form.action = url;
  form.style.display = "none";

  for (var key in data) {
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = key;
    input.value = data[key];
    form.appendChild(input);
  }
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

function updateCareerLifeStatus(val, chk) {
  $.ajax({
    url: "../ajax_php/a.updateCareerLifeStatus.php",
    type: "POST",
    dataType: "json",
    data: {
      projectId: val[0].projectId,
      studentId: val[0].studentId,
      info: val[0].info,
      type: chk,
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        showSwal("success");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxToUpdateCareerLife(paramsObject) {
  for (let i = 0; i < careerObj.length; i++) {
    if (paramsObject.course == careerObj[i].SubjectID) {
      paramsObject["teacherID"] = careerObj[i].TeacherID;
      paramsObject["subjectName"] = careerObj[i].SubjectName;
    }
  }
  paramsObject["projectId"] = $("#hidden-projectId").val();

  $.ajax({
    url: "../ajax_php/a.updateCareerLife.php",
    type: "POST",
    dataType: "json",
    data: paramsObject,
    success: function (response) {
      if (response[0].result == 1) {
        location.reload();
      } else {
        alert("Contact IT");
        location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxToAddCareerLife(paramsObject) {
  $.ajax({
    url: "../ajax_php/a.addCareerLife.php",
    type: "POST",
    dataType: "json",
    data: paramsObject,
    success: function (response) {
      if (response[0].result == 1) {
        location.reload();
      } else {
        alert("Contact IT");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxtostudentinfo(studentid) {
  $.ajax({
    url: '../ajax_php/a.studentInfo.php',
    type: 'POST',
    data: {
      studentid: studentid,
    },
    async: false,
    dataType: "json",
    success: function (response) {
      console.log(response);
      var fullName;
      if (response[0].englishName) {
        fullName = response[0].lastName + ', ' + response[0].firstName + ' (' + response[0].englishName + ')';
      } else {
        fullName = response[0].lastName + ', ' + response[0].firstName;
      }
      $('.dashboard-fullName').html(fullName);
      $('#student-inf .dashboard-studentId').html(response[0].studentId);
      // var imgsrc = response[0].imgsrc;
      $('.dashboard-userPic').attr("src", 'https://asset.bodwell.edu/OB4mpVPg/student/bhs' + studentid + '.jpg');
      $('#student-inf .dashboard-pen').html(response[0].pen);
      $('#student-inf .dashboard-grade').html(response[0].currentGrade);
      $('#student-inf .dashboard-Counsellor').html(response[0].counsellor);
      var location = chkLocation(response[0].residence, response[0].homestay);
      $('#student-inf .dashboard-location').html(location);
      $('#student-inf .dashboard-house').html(response[0].houses);
      $('#student-inf .dashboard-hall').html(response[0].halls);
      $('#student-inf .dashboard-room').html(response[0].roomNo);
      $('#student-inf .dashboard-advisor1').html(response[0].youthAdvisor);
      $('#student-inf .dashboard-advisor2').html(response[0].youthAdvisor2);
      $('#student-inf .dashboard-mentor').html(response[0].mentor);
      $('#student-inf .dashboard-terms').html(response[0].numTerms);
      $('#student-inf .dashboard-aepTerms').html(response[0].numOfAepTerm);
      // ajaxtoEnrollTerm(response[0].EnrollmentDate);
      // ajaxtoMyParticipation(StartDate, NextStartDate, response[0].EnrollmentDate);

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function editLeaveRequest(paramsObject) {
  $.ajax({
    url: "../ajax_php/a.editLeaveRequest.php",
    type: "POST",
    dataType: "json",
    data: paramsObject,
    success: function (response) {
      console.log(response);
      if (response.result == 1) {
        showSwal2("success","success","#leaveRequestMdl");
        $('#leaveRequestMdl').modal('toggle');
        getStudentLeaveRequest();
      } else {
        alert("Contact IT");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getDetailofSelfassessments(dataid,name, grade,selfAssessmentsResponse){
  $('#selfAssessmentsModal  .selfAssessments-wrapper').html('');
  $('span.studentName').html(name);
  $('span.grade').html(grade);


  for (let i = 0; i < selfAssessmentsResponse.length; i++) {
    let selfAssessmentsDetail = selfAssessmentsResponse[i];
    if (selfAssessmentsDetail.AssessmentID == dataid) {
      $('#selfAssessmentsModal  .selfAssessments-wrapper').html(selfAssessmentsDetail.FormHtml);

      if(selfAssessmentsDetail.Grade == '10,11,12') {
        displayStudentAssessment10(selfAssessmentsDetail);
      } else if (selfAssessmentsDetail.Grade == '8,9') {
        displayStudentAssessment8(selfAssessmentsDetail);
      } else {
        alert('Contact IT');
      }

    }
  }
}

function getDetailofLeaveBan(dataid, studentLeaveBanResponse){
  $('#LeaveBanDetailMdl input').val('');

  for (let i = 0; i < studentLeaveBanResponse.length; i++) {
    let leaveBanDetail = studentLeaveBanResponse[i];
    if (leaveBanDetail.BanID == dataid) {
      $('#LeaveBanDetailMdl-studentName').val(leaveBanDetail.FirstName + ' ' + leaveBanDetail.LastName + ' ' + leaveBanDetail.EnglishName);
      $('#LeaveBanDetailMdl-studentID').val(leaveBanDetail.StudentID);
      $('#LeaveBanDetailMdl-sDate').val(leaveBanDetail.FromDate);
      $('#LeaveBanDetailMdl-eDate').val(leaveBanDetail.ToDate);
      $('#LeaveBanDetailMdl-BanID').val(leaveBanDetail.BanID);
      $('#LeaveBanMdl-comment').val(leaveBanDetail.Comment);
      $("#LeaveBanDetailMdl-status").val(leaveBanDetail.Status).change();


    }
  }
}

function editLeaveBan(leaveFormObject) {
  $.ajax({
    url: "../ajax_php/a.editLeaveBan.php",
    type: "POST",
    dataType: "json",
    data: leaveFormObject,
    success: function (response) {
      if (response[0].result == 1) {
        showSwal2("success","success","#LeaveBanDetailMdl");
        $('#LeaveBanDetailMdl').modal('toggle');
        getStudentLeaveBan();
      } else {
        alert("Contact IT");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function saveTranscriptRequest(transcriptRequestObj) {

  $.ajax({
    url: "../ajax_php/a.saveTranscriptRequest.php",
    type: "POST",
    dataType: "json",
    data: transcriptRequestObj,
    success: function (response) {
      if (response[0].result == 1) {
        showSwal2("success","success","#transcriptRequestModal");
        $('#transcriptRequestModal').modal('toggle');
        getTranscriptRequest();
      } else {
        alert("Contact IT");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}
