var numberofactivityandself;
var globalApprovalList;

function dashBoard_my_selfsubmit_activities() {
  $.ajax({
    url: "../ajax_php/a.getMyselfnumberActivity.php",
    type: "POST",
    async: true,
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        var totalSelfApprove = 0;
        var totalSelfReject = 0;
        var totalSelfPending = 0;
        if (response) {
          for (var i = 0; i < response.length; i++) {
            totalSelfApprove += parseInt(response[i].APPROVE);
            totalSelfReject += parseInt(response[i].REJECT);
            totalSelfPending += parseInt(response[i].PENDING);
            $(".dashboard-" + response[i].Title + "-selfActivities-approve").html(response[i].APPROVE);
            $(".dashboard-" + response[i].Title + "-selfActivities-reject").html(response[i].REJECT);
            $(".dashboard-" + response[i].Title + "-selfActivities-pending").html(response[i].PENDING);
          }
          $(".dashboard-TOTAL-selfActivities-approve").html(totalSelfApprove);
          $(".dashboard-TOTAL-selfActivities-reject").html(totalSelfReject);
          $(".dashboard-TOTAL-selfActivities-pending").html(totalSelfPending);
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function generateTermListV2(select, globalSemesterList, val = 0) {
  var options = "";
  for (let i = 0; i < globalSemesterList.length; i++) {
    options += '<option value="' + globalSemesterList[i].SemesterID + '">' + globalSemesterList[i].SemesterName + "</option>";
  }
  $(select).html(options);
}

function getMyCourseListV2(semesterID, teacherId) {
  $.ajax({
    url: "../ajax_bogs/a.getMyCourseList.php",
    type: "POST",
    dataType: "json",
    data: {
      semesterID: semesterID,
      teacherId: teacherId
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseListDashboard(response);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}