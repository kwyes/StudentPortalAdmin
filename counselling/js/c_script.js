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

function generateWAdata() {
  var term = $('#sSubmit-term-select').val();
  var combineddate = $("#weeklyDatePicker3").val();
  var dateArr = combineddate.split("   -   ");
  var studentId = $('.dashboard-studentId').html();
  var eData = [];
  var table = $("#waDetail").DataTable();
  var num_incomp = 0;
  var num_parComp = 0;
  var num_comp = 0;
  var teacherSubjList = [];
  $('#waDetail').html('');
  $.ajax({
    url: "../ajax_php/a.getWeeklyAssignmentData.php",
    type: "POST",
    async: true,
    data: {
      term: term,
      from: dateArr[0],
      to: dateArr[1],
      studentId: studentId,
    },
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT no week");
        table.clear();
      } else {
        var waList = response;
        table.clear();

        for (let i = 0; i < waList.length; i++) {
          var teacherName = '';
          var subjectName = '';
          var week = '';
          var waStatus = '';
          var assignments = "<div class='row'>"
          var pre_subjectId = '';

          subjectName = waList[i].SubjectName;

          teacherSubjList.push({
            subjectId: waList[i].SubjectID,
            subjectName: subjectName,
            teacherName: waList[i].FirstName + ' ' + waList[i].LastName
          })

          week = getWeekDate(new Date(waList[i].AssignDate));

          var flg = 0;
          do {
            if (waList[i].SubjectID != pre_subjectId && pre_subjectId != '') {
              i--;
              break;
            }

            switch (waList[i].Status) {
              case '1':
                waStatus = '<i class="material-icons font-12 color-red">clear</i>'
                num_incomp += 1;
                break;
              case '2':
                waStatus = '<i class="material-icons font-12 color-yellow">not_interested</i>'
                num_parComp += 1;
                break;
              case '3':
                waStatus = '<i class="material-icons font-12 color-blue">done</i>'
                num_comp += 1;
                break;
              default:
                break;
            }

            assignments +=
              "<div class='col-md-12 row row-eq-height' >" +
              "<div class='col-md-2 text-center'>" + waList[i].Seq + "</div>" +
              "<div class='col-md-8 text-left'>" + waList[i].Title + "</div>" +
              "<div class='col-md-2 text-center'>" + waStatus + "</div>" +
              "</div>"


            if (waList[i].SubjectID == pre_subjectId || pre_subjectId == '') {
              if (i >= waList.length - 1) {
                flg = 1;
                break;
              } else {
                pre_subjectId = waList[i].SubjectID;
                i++;
              }
            } else {
              flg = 1;
              break;
            }
          } while (flg == 0);


          assignments += "</div>"

          eData.push([
            waList[i].FirstName + ' ' + waList[i].LastName,
            subjectName,
            week,
            assignments
          ])
        }
        table = $("#waDetail").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          bPaginate: false,
          // pagingType: "simple_numbers",
          // language: {
          //   paginate: {
          //     next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
          //     previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
          //   },
          // },
          // lengthMenu: [
          //   [10, 25, 50, -1],
          //   [10, 25, 50, "All"],
          // ],
          order: [0, "desc"],
          columnDefs: [{
              width: "20%",
              targets: 0,
              className: "text-left"
            },
            {
              width: "20%",
              targets: 1,
              className: "text-left"
            },
            {
              width: "20%",
              targets: 2
            },
            {
              width: "40%",
              targets: 3,
            }
          ],
          // dom: '<"row"<"col-md-6"><"col-md-6">>t<"row"<"col-md-6"i><"col-md-6"p>>',
          dom: '<"row"<"col-md-6"><"col-md-6">>t<"row"<"col-md-6"><"col-md-6">>',
        });
        $("#wa-teacher").html('');
        $("#wa-course").html('');

        var hidden_subjId = $('#waDetailModal-subjId').val();
        var subjName = '';
        var teacherName = '';
        for (let i = 0; i < teacherSubjList.length; i++) {
          if (hidden_subjId == teacherSubjList[i].subjectId) {
            subjName = teacherSubjList[i].subjectName;
            teacherName = teacherSubjList[i].teacherName;
            break;
          }
        }

        table.column(0).every(function () {
          var column = this;
          var select = $(
              '<select class="form-control custom-form mg-lr-7"><option value="">All</option></select>'
            )
            .prependTo($("#wa-teacher"))
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              select.append('<option value="' + d + '">' + d + "</option>");
            });
        });

        table.column(1).every(function () {
          var column = this;
          var select = $(
              '<select class="form-control custom-form mg-lr-7"><option value="">All</option></select>'
            )
            .prependTo($("#wa-course"))
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
                select.append('<option value="' + d + '">' + d + "</option>");
            });
        });

        var num_total = num_incomp + num_parComp + num_comp;

        $('.incomp-num').html(num_incomp);
        $('.pComp-num').html(num_parComp);
        $('.comp-num').html(num_comp);
        $('.wa-total-num').html(num_total);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}
