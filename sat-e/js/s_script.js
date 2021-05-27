var numberofactivityandself;
var globalApprovalList;

function dashBoard_my_activities() {
  $.ajax({
    url: "../ajax_php/a.getMynumberActivity.php",
    type: "POST",
    async: true,
    dataType: "json",
    success: function (response) {
      numberofactivityandself = response;
      if (response.result == 0) {
        console.log("IT");
      } else {
        dashBoard_my_selfsubmit_activities();
        var totalActivity = 0;
        var myActivitiesResponse = response["myActivities"];
        for (var i = 0; i < myActivitiesResponse.length; i++) {
          totalActivity += parseInt(myActivitiesResponse[i].NumberOfActivity);
          $(".dashboard-" + myActivitiesResponse[i].Title + "-myActivities").html(myActivitiesResponse[i].NumberOfActivity);
        }
        $(".dashboard-TOTAL-myActivities").html(totalActivity);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

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
      // alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoApprovalListSATE(id) {
  $.ajax({
    url: "../ajax_php/a.ApprovalListSATE.php",
    type: "POST",
    dataType: "json",
    async: false,
    success: function(response) {
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
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}
