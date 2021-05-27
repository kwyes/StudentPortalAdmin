var globalres;
var selfsubmitResponse;
var searchStudentResponse;
var vlweResponse;
var myStudentList;
var leaveRequestResponse;
var selfAssessmentsResponse;
var transcriptRequestResponse;
function show_school_activities() {
  var from = $("#act-date-from").val();
  var to = $("#act-date-to").val();
  var staffid = $("#act-stfLeader-select").val();
  var table = $("#datatables-activities").DataTable();
  var eData = [];

  $.ajax({
    url: "../ajax_php/a.showActivities.php",
    type: "POST",
    dataType: "json",
    data: {
      from: from,
      to: to,
      staffid: staffid,
    },
    cache: false,
    async: true,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        globalres = response;
        table.clear();
        for (var i = 0; i < response.length; i++) {
          var title =
            '<a href="" data-toggle="modal" class="actTitleLink" data-id="' +
            response[i].activityId +
            '">' +
            response[i].title +
            "</a>";
          var curmax = response[i].curEnroll + " / " + response[i].maxEnroll;
          var enrollStatus;
          if (response[i].ENROLLMENTSTATUS == 1) {
            enrollStatus = "Closed";
          } else {
            enrollStatus = "In Progress";
          }
          var categoryIcon = GetCategoryIcon(response[i].ActivityCategory);
          var vlweIcon = GetVlweIcon(response[i].workExp);
          eData.push([
            response[i].activityId,
            title,
            response[i].startDate.substring(0, 10),
            formatDecimal(response[i].baseHours),
            response[i].staffName,
            response[i].EnrollType,
            categoryIcon,
            vlweIcon,
            curmax,
            enrollStatus,
            response[i].categoryTitle,
          ]);
        }
        table = $("#datatables-activities").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          order: [
            [2, "desc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          columnDefs: [{
              targets: 0,
              visible: false,
            },
            {
              width: "8%",
              targets: 2,
              className: "text-center",
            },
            {
              width: "8%",
              targets: 3,
              className: "text-right",
            },
            {
              width: "10%",
              targets: 4,
            },
            {
              width: "8%",
              targets: 5,
              className: "text-center",
            },
            {
              width: "8%",
              targets: 6,
              className: "text-center",
            },
            {
              width: "6%",
              targets: 7,
              className: "text-center",
            },
            {
              width: "10%",
              targets: 8,
              className: "text-center",
            },
            {
              width: "8%",
              targets: 9,
              className: "text-center",
            },
            {
              visible: false,
              targets: 10,
            },
          ],
        });
        $("#activity-cateSelect").html("");
        table.column(10).every(function () {
          var that = this;

          // Create the select list and search operation
          var select = $('<select class="form-control custom-form mg-lr-7" />')
            .prependTo("#activity-cateSelect")
            .on("change", function () {
              that.search($(this).val()).draw();
            });

          // Get the search data for the first column and add to the select list
          select.append($('<option value="">All Categories</option>'));

          this.cache("search")
            .sort()
            .unique()
            .each(function (d) {
              select.append($('<option value="' + d + '">' + d + "</option>"));
            });
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });

  $("#datatables-activities tbody").on("click", "tr", function (event) {
    var target = $(event.target);
    if (!target.hasClass("actTitleLink")) {
      $(this).toggleClass("tr-selected");
    }
  });
}

function get_selfsubmit_rows() {
  var from = $("#self-date-from").val();
  var to = $("#self-date-to").val();
  var staffid = $("#sSubmit-stfLeader-select").val();
  var table = $("#datatables-selfsubmit").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.GetSelfSubmitHours.php",
    type: "POST",
    cache: false,
    data: {
      from: from,
      to: to,
      staffid: staffid,
    },
    dataType: "json",
    async: true,
    success: function (response) {
      selfsubmitResponse = response;
      console.log(response);
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        $(".selectAll").prop("checked", "");
        $(".selectAll").removeClass("allChecked");
        var atag;
        for (var i = 0; i < response.length; i++) {
          var LastName = response[i].LastName;
          var FirstName = response[i].FirstName;
          var EnglishName = response[i].EnglishName;

          var chkbox =
            '<input class="self-submit-chk" type="checkbox" value="' +
            response[i].StudentActivityID +
            '">';
          var title =
            '<a href="" data-id="' +
            response[i].StudentActivityID +
            '" data-toggle="modal" class="sSubmitNameLink" id="">' +
            response[i].Title +
            "</a>";
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          var categoryIcon = GetCategoryIcon(response[i].ActivityCategory);
          var vlweIcon = GetVlweIcon(response[i].VLWE);
          var date = response[i].SDate.substring(0, 10);
          if (response[0].source == "admin") {
            atag =
              '<a class="hoverShowPic selfSubmitPic" data-id="' +
              response[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              response[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic selfSubmitPic" data-id="' +
              response[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              response[i].StudentID +
              '" target="_blank">';
          }
          var fullName;
          if (EnglishName) {
            fullName =
              atag + FirstName + " (" + EnglishName + ") " + LastName + "</a>";
          } else {
            fullName = atag + FirstName + " " + LastName + "</a>";
          }
          eData.push([
            chkbox,
            date,
            fullName,
            title,
            response[i].ProgramSource,
            categoryIcon,
            response[i].ActivityCategory,
            vlweIcon,
            formatDecimal(response[i].Hours),
            response[i].StaffFullName,
            StatusIcon,
            response[i].SemesterName,
            response[i].SemesterID,
            response[i].ActivityStatus,
          ]);
        }
        table.clear();
        table = $("#datatables-selfsubmit").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          pagingType: "simple_numbers",
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          order: [1, "desc"],
          columnDefs: [{
              width: "3%",
              targets: 0,
              orderable: false,
            },
            {
              width: "9%",
              targets: 1,
              className: "text-center",
            },
            {
              width: "18%",
              targets: 2,
            },
            {
              width: "25%",
              targets: 3,
            },
            {
              width: "5%",
              targets: 4,
              className: "text-center",
            },
            {
              width: "9%",
              targets: 5,
              className: "text-center",
            },
            {
              visible: false,
              targets: 6,
            },
            {
              width: "6%",
              targets: 7,
              className: "text-center",
            },
            {
              width: "5%",
              targets: 8,
              className: "text-center",
            },
            {
              width: "13%",
              targets: 9,
            },
            {
              width: "8%",
              targets: 10,
              className: "text-center",
            },
            {
              visible: false,
              targets: 11,
            },
            {
              visible: false,
              targets: 12,
            },
            {
              visible: false,
              targets: 13,
            },
          ],
          dom: '<"row"<"col-md-12 selfsubmit-filter-wrapper"f l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
            null,
            null,
          ],
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        var val = $("#sSubmit-category-select").val();
        table
          .column(6)
          .search(val ? "^" + val + "$" : "", true, false)
          .draw();

        table.columns().every(function (index) {
          if (index == 6) {
            var that = this;

            $("#sSubmit-category-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });

        var val1 = $("#sSubmit-term-select").val();
        table
          .column(12)
          .search(val1 ? "^" + val1 + "$" : "", true, false)
          .draw();

        table.columns().every(function (index) {
          if (index == 12) {
            var that = this;

            $("#sSubmit-term-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });

        var val2 = $("#sSubmit-status-select").val();
        table
          .column(13)
          .search(val2 ? "^" + val2 + "$" : "", true, false)
          .draw();

        table.columns().every(function (index) {
          if (index == 13) {
            var that = this;

            $("#sSubmit-status-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function get_vlwe_rows() {
  var from = $("#vlwe-date-from").val();
  var to = $("#vlwe-date-to").val();
  var staffid = $("#vlwe-stfLeader-select").val();
  var table = $("#datatables-vlwe").DataTable();

  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getVlweHours.php",
    type: "POST",
    data: {
      from: from,
      to: to,
      staffid: staffid,
    },
    dataType: "json",
    async: true,
    success: function (response) {
      vlweResponse = response;
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        for (var i = 0; i < response.length; i++) {
          var LastName =
            '<a href="" data-id="' +
            response[i].StudentActivityID +
            '" data-toggle="modal" class="vlweNameLink" id="">' +
            response[i].LastName +
            "</a>";
          var FirstName =
            '<a href="" data-id="' +
            response[i].StudentActivityID +
            '" data-toggle="modal" class="vlweNameLink" id="">' +
            response[i].FirstName +
            "</a>";
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          eData.push([
            response[i].StudentID,
            LastName,
            FirstName,
            response[i].EnglishName,
            response[i].Title,
            response[i].SDate,
            formatDecimal(response[i].Hours),
            response[i].StaffFullName,
            response[i].VLWESupervisor,
            StatusIcon,
          ]);
        }
        table.clear();
        table = $("#datatables-vlwe").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          pagingType: "simple_numbers",
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          order: [6, "desc"],
          columnDefs: [{
              width: "8%",
              targets: 0,
              className: "text-center",
            },
            {
              width: "12%",
              targets: 1,
            },
            {
              width: "12%",
              targets: 2,
            },
            {
              width: "11%",
              targets: 3,
            },
            {
              width: "13%",
              targets: 4,
            },
            {
              width: "13%",
              targets: 5,
              className: "text-center",
            },
            {
              width: "5%",
              targets: 6,
              className: "text-right",
            },
            {
              width: "10%",
              targets: 7,
            },
            {
              width: "10%",
              targets: 8,
            },
            {
              width: "6%",
              targets: 9,
              className: "text-center",
            },
          ],
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
          ],
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getMyStudentList(name) {
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getMyStudentList.php",
    type: "POST",
    dataType: "json",
    data: {
      name: name,
    },
    success: function (response) {
      myStudentList = response;
      var tr;
      if (response.result == 0) {
        tr = '<tr><td colspan="6">No Record</td></tr>';
      } else {
        var studentObj = response["data"];
        for (let i = 0; i < studentObj.length; i++) {
          var fullName = studentObj[i].FirstName + " " + studentObj[i].LastName;
          var name = "";
          var icon =
            '<span class="cursor-pointer" onclick="redirectToSp(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">account_circle</i></span>';
          if (response.source == "admin") {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          }

          if (studentObj[i].EnglishName.length > 0) {
            name =
              atag +
              studentObj[i].FirstName +
              " (" +
              studentObj[i].EnglishName +
              ") " +
              studentObj[i].LastName +
              "</a>";
          } else {
            name =
              atag +
              studentObj[i].FirstName +
              " " +
              studentObj[i].LastName +
              "</a>";
          }

          var flag = getNationalFlag(studentObj[i].flag, studentObj[i].Origin);

          eData.push([
            name,
            icon,
            flag,
            studentObj[i].Boarding,
            studentObj[i].RoomNo,
            studentObj[i].Hall,
          ]);
        }
        table = $("#dashboard-studentlist").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // responsive: true,
          scrollX: true,
          // order: [[0, "asc"]],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          columnDefs: [],
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function createStudentListTable(name) {
  var table = $("#datatables-myStudentList").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getMyStudentList.php",
    type: "POST",
    dataType: "json",
    data: {
      name: name,
    },
    cache: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        table.clear();
        var studentObj = response["data"];
        for (var i = 0; i < studentObj.length; i++) {
          var name = "";

          var icon =
            '<span class="cursor-pointer" onclick="redirectToSp(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">account_circle</i></span>';
          var icon2 =
            '<span class="cursor-pointer" onclick="redirectToMc(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">supervised_user_circle</i></span>';

          var icon3 =
            '<a href="mailto:' +
            studentObj[i].SchoolEmail +
            '" class="mailLink"><i class="material-icons-outlined">mail</i></a>';

          if (response.source == "admin") {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          }

          var flag = getNationalFlag(studentObj[i].flag, studentObj[i].Origin);

          if (studentObj[i].EnglishName.length > 0) {
            name =
              atag +
              studentObj[i].FirstName +
              " (" +
              studentObj[i].EnglishName +
              ") " +
              studentObj[i].LastName +
              "</a>";
          } else {
            name =
              atag +
              studentObj[i].FirstName +
              " " +
              studentObj[i].LastName +
              "</a>";
          }
          var t = "t";

          eData.push([
            name,
            icon,
            icon2,
            icon3,
            flag,
            studentObj[i].Boarding,
            studentObj[i].RoomNo,
            studentObj[i].Hall,
            studentObj[i].House,
            studentObj[i].HallAdvisor,
            studentObj[i].HallAdvisor2,
            studentObj[i].Tutor,
            studentObj[i].TutorRoom,
            studentObj[i].FOBID,
            studentObj[i].StudentID,
            studentObj[i].EnrolledSince,
            studentObj[i].Counsellor,
            studentObj[i].MentorTeacher,
          ]);
        }
        table = $("#datatables-myStudentList").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: true,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "asc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [100, 250, 500, -1],
            [100, 250, 500, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          dom: '<"row"<"col-md-6"f><"col-md-6"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          columnDefs: [{
              targets: 0,
              width: "3%",
            },
            {
              targets: 1,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 2,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 3,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 4,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 5,
              className: "text-center",
              width: "5%",
            },
            {
              targets: 6,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 7,
              width: "3%",
            },
            {
              targets: 8,
              width: "3%",
            },
            {
              targets: 9,
              width: "3%",
            },
            {
              targets: 10,
              width: "3%",
            },
            {
              targets: 11,
              width: "3%",
            },
            {
              targets: 12,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 13,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 14,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 15,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 16,
              width: "3%",
            },
            {
              targets: 17,
              width: "3%",
            },
          ],
          aoColumns: [
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
          ],
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxToCareerRecordList(SemesterID) {
  var TeacherID = $("#career-stfLeader-select").val();
  var table = $("#datatables-careerlife").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getCareerRecordList.php",
    type: "POST",
    dataType: "json",
    data: {
      TeacherID: TeacherID,
    },
    cache: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        table.clear();
        careerObj = response["data"];
        for (var i = 0; i < careerObj.length; i++) {
          var chkbox =
            '<input class="career-submit-chk" type="checkbox" value="' +
            careerObj[i].ProjectID +
            '">';
          var name = "";
          var atag = "";
          var topic =
            '<a href="" data-toggle="modal" class="career-link" data-id="' +
            careerObj[i].ProjectID +
            '">' +
            careerObj[i].ProjectTopic +
            "<br /></a>";

          if (response.source == "admin") {
            atag =
              '<a class="hoverShowPic careerLifePic" data-id="' +
              careerObj[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              careerObj[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic careerLifePic" data-id="' +
              careerObj[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              careerObj[i].StudentID +
              '" target="_blank">';
          }

          if (careerObj[i].SEnglishName) {
            name =
              atag +
              careerObj[i].SFirstName +
              " (" +
              careerObj[i].SEnglishName +
              ") " +
              careerObj[i].SLastName +
              "</a>";
          } else {
            name =
              atag +
              careerObj[i].SFirstName +
              " " +
              careerObj[i].SLastName +
              "</a>";
          }
          var shortSubjectName = getFirstCharacter(careerObj[i].SubjectName);
          var StatusIcon = GetStatusIcon(careerObj[i].ApprovalStatus);
          var TeacherName =
            careerObj[i].FirstName + " " + careerObj[i].LastName;
          eData.push([
            chkbox,
            careerObj[i].CreateDateV,
            shortSubjectName,
            TeacherName,
            name,
            careerObj[i].ProjectCategory,
            topic,
            StatusIcon,
            careerObj[i].TeacherID,
            careerObj[i].SemesterID,
            careerObj[i].ApprovalStatus,
            careerObj[i].CourseCd,
          ]);
        }
        table = $("#datatables-careerlife").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          order: [
            [1, "desc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [100, 250, 500, -1],
            [100, 250, 500, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          dom: '<"row"<"col-md-2"f><"col-md-10"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          columnDefs: [{
              width: "3%",
              targets: 0,
              className: "text-center",
              orderable: false,
            },
            {
              width: "8%",
              targets: 1,
              className: "text-center",
            },
            {
              width: "10%",
              targets: 2,
              className: "text-center",
            },
            {
              width: "18%",
              targets: 3,
            },
            {
              width: "20%",
              targets: 4,
            },
            {
              width: "10%",
              targets: 5,
            },
            {
              width: "23%",
              targets: 6,
            },
            {
              width: "8%",
              targets: 7,
              className: "text-center",
            },
            {
              targets: 8,
              visible: false,
            },
            {
              targets: 9,
              visible: false,
            },
            {
              targets: 10,
              visible: false,
            },
            {
              targets: 11,
              visible: false,
            },
          ],
        });

        table.columns().every(function (index) {
          if (index == 8) {
            var that = this;
            $("#career-stfLeader-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 9) {
            var that = this;
            $("#career-term-select").val(SemesterID).change();

            that
              .search(SemesterID ? "^" + SemesterID + "$" : "", true, false)
              .draw();

            $("#career-term-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 10) {
            var that = this;
            $("#career-status-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 11) {
            var that = this;
            $("#career-category-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function ajaxToGetListCareerSubejct(SemesterID, id) {
  $.ajax({
    url: "../ajax_php/a.getListCareerSubject.php",
    type: "POST",
    data: {
      SemesterID: SemesterID,
    },
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        careerSubjectList = response["data"];
        $(id).append('<option value="">Select..</option>');
        for (var i = 0; i < careerSubjectList.length; i++) {
          let TeacherID = careerSubjectList[i].TeacherID;
          let FullName = careerSubjectList[i].FullName;
          let SubjectID = careerSubjectList[i].SubjectID;
          let SubjectName = careerSubjectList[i].SubjectName;
          $(id).append(
            '<option value="' +
            SubjectID +
            '">' +
            SubjectName +
            " (" +
            FullName +
            ")" +
            "</option>"
          );
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function createEntireCurrentStudentListTable() {
  var table = $("#datatables-entireStudentList").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getEntireStudentList.php",
    type: "POST",
    dataType: "json",
    cache: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        table.clear();
        var studentObj = response["data"];
        for (var i = 0; i < studentObj.length; i++) {
          var name = "";
          var icon =
            '<span class="cursor-pointer" onclick="redirectToSp(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">account_circle</i></span>';
          var icon2 =
            '<span class="cursor-pointer" onclick="redirectToMc(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">supervised_user_circle</i></span>';

          var icon3 =
            '<a href="mailto:' +
            studentObj[i].SchoolEmail +
            '" class="mailLink"><i class="material-icons-outlined">mail</i></a>';
          if (response.source == "admin") {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          }
          var flag = getNationalFlag(studentObj[i].flag, studentObj[i].Origin);
          var age = getAge(studentObj[i].DOB);
          if (studentObj[i].EnglishName.length > 0) {
            name =
              atag +
              studentObj[i].FirstName +
              " (" +
              studentObj[i].EnglishName +
              ") " +
              studentObj[i].LastName +
              "</a>";
          } else {
            name =
              atag +
              studentObj[i].FirstName +
              " " +
              studentObj[i].LastName +
              "</a>";
          }
          var gender = getGenderIcon(studentObj[i].Sex);
          var house = getHouseIcon(studentObj[i].House);

          eData.push([
            name,
            icon,
            icon2,
            icon3,
            flag,
            gender,
            age,
            studentObj[i].CurrentGrade,
            studentObj[i].EnrolledIn,
            studentObj[i].numTerms,
            studentObj[i].Counsellor,
            studentObj[i].MentorTeacher,
            studentObj[i].Boarding,
            house,
            studentObj[i].Hall,
            studentObj[i].RoomNo,
            studentObj[i].HallAdvisor,
            studentObj[i].HallAdvisor2,
          ]);
        }
        table = $("#datatables-entireStudentList").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: true,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "asc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [100, 250, 500, -1],
            [100, 250, 500, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          dom: '<"row"<"col-md-6"f><"col-md-6"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          columnDefs: [{
              targets: 0,
              width: "6%",
            },
            {
              targets: 1,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 2,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 3,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 4,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 5,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 6,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 7,
              width: "6%",
            },
            {
              targets: 8,
              width: "6%",
            },
            {
              targets: 9,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 10,
              width: "6%",
            },
            {
              targets: 11,
              width: "6%",
            },
            {
              targets: 12,
              width: "6%",
            },
            {
              targets: 13,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 14,
              width: "6%",
            },
            {
              targets: 15,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 16,
              width: "6%",
            },
            {
              targets: 17,
              width: "6%",
            },
          ],
          aoColumns: [
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
            {
              sType: "num-html",
            },
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
            null,
            null,
            null,
            null,
          ],
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function generateVLWEReport(studentid, globalSemesterList) {
  var table = $("#datatables-vlwe-report").DataTable();
  var html = "";
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getVLWEReport.php",
    type: "POST",
    dataType: "json",
    data: {
      studentid: studentid,
    },
    cache: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        var haHours = 0;
        var paHours = 0;
        var rHours = 0;
        for (var i = 0; i < response.length; i++) {
          if (response[i].ActivityStatus == "60") {
            paHours += parseFloat(response[i].Hours);
          } else if (response[i].ActivityStatus == "80") {
            haHours += parseFloat(response[i].Hours);
          } else if (response[i].ActivityStatus == "90") {
            rHours += parseFloat(response[i].Hours);
          }
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          var categoryIcon = GetCategoryIcon(response[i].ActivityCategory);
          var vlweIcon = GetVlweIcon(response[i].VLWE);
          eData.push([
            response[i].SDate,
            response[i].Title,
            response[i].ProgramSource,
            categoryIcon,
            vlweIcon,
            formatDecimal(response[i].Hours),
            response[i].CreateUserName,
            response[i].ApproverStaffName,
            response[i].VLWESupervisor,
            StatusIcon,
            response[i].SemesterID,
            response[i].ActivityCategory,
            response[i].ActivityStatus,
          ]);
        }
        $("#report-approved").html(haHours.toFixed(1));
        $("#report-pending").html(paHours.toFixed(1));
        $("#report-rejected").html(rHours.toFixed(1));
        table.clear();
        table = $("#datatables-vlwe-report").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          pagingType: "simple_numbers",
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          order: [0, "desc"],
          columnDefs: [{
              width: "7%",
              targets: 0,
              className: "text-center",
            },
            {
              width: "19%",
              targets: 1,
            },
            {
              width: "7%",
              targets: 2,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 3,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 4,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 5,
              className: "text-center",
            },
            {
              width: "13%",
              targets: 6,
            },
            {
              width: "13%",
              targets: 7,
            },
            {
              width: "13%",
              targets: 8,
            },
            {
              width: "7%",
              targets: 9,
              className: "text-center",
            },
            {
              targets: 10,
              visible: false,
            },
            {
              targets: 11,
              visible: false,
            },
            {
              targets: 12,
              visible: false,
            },
          ],
          dom: '<"row"<"col-md-8"f><"col-md-4"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
          ],
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });
        $("#datatables-vlwe-report_filter").append(
          '<label class="mg-r-10">Term :<div class="semester_filter"><select id="report-term-select" class="select-term form-control custom-form report-term-list"></select></div></label>'
        );
        $("#datatables-vlwe-report_filter").append(
          '<label class="mg-r-10">Category :<select id="report-category-select" class="select-category form-control custom-form"><option value ="">All</option><option value="10">PORE</option><option value="11">AISD</option><option value="12">CILE</option><option value="13">ACLE</option></select></label>'
        );
        $("#datatables-vlwe-report_filter").append(
          '<label class="mg-r-10">Status :<select id="report-status-select" class="select-category form-control custom-form"><option value="">All</option><option value="60">Pending Approval</option><option value="80">Hours Approved</option><option value="90">Rejected</option></select></label>'
        );
        $("#datatables-vlwe-report_filter").append(
          '<button type="button" class="btn btn-fill btn-default btn-sm btn-report-reset">Reset</button>'
        );
        generateTermList(".report-term-list", globalSemesterList);

        table.columns().every(function (index) {
          if (index == 10) {
            var that = this;
            $("#report-term-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 11) {
            var that = this;
            $("#report-category-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 12) {
            var that = this;
            $("#report-status-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function studentSearchAllActivityList(studentid, globalSemesterList) {
  var table = $("#datatables-student-search").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getSelfSubmitByStudent.php",
    type: "POST",
    dataType: "json",
    data: {
      studentid: studentid,
    },
    cache: false,
    success: function (response) {
      searchStudentResponse = response;
      if (response.result == "0") {
        console.log("IT");
        table.clear().draw();
      } else {
        var haHours = 0;
        var paHours = 0;
        var rHours = 0;
        for (var i = 0; i < response.length; i++) {
          if (response[i].ActivityStatus == "60") {
            paHours += parseFloat(response[i].Hours);
          } else if (response[i].ActivityStatus == "80") {
            haHours += parseFloat(response[i].Hours);
          } else if (response[i].ActivityStatus == "90") {
            rHours += parseFloat(response[i].Hours);
          }
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          var categoryIcon = GetCategoryIcon(response[i].ActivityCategory);
          var vlweIcon = GetVlweIcon(response[i].VLWE);
          var newTitle = "";
          newTitle = response[i].Title.replace("YYY", "");
          newTitle = response[i].Title.replace("ZZZ", "");

          if (response[i].ProgramSource == "SELF") {
            var title =
              '<a href="" data-id="' +
              response[i].StudentActivityID +
              '" data-toggle="modal" class="searchStuTitleLink" id="">' +
              newTitle +
              "</a>";
          } else {
            var title = newTitle;
          }
          eData.push([
            response[i].SDate,
            title,
            response[i].ProgramSource,
            categoryIcon,
            vlweIcon,
            formatDecimal(response[i].Hours),
            response[i].CreateUserName,
            response[i].ApproverStaffName,
            response[i].VLWESupervisor,
            StatusIcon,
            response[i].SemesterID,
            response[i].ActivityCategory,
            response[i].ActivityStatus,
          ]);
        }
        table.clear();
        table = $("#datatables-student-search").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          pagingType: "simple_numbers",
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          order: [0, "desc"],
          columnDefs: [{
              width: "7%",
              targets: 0,
              className: "text-center",
            },
            {
              width: "19%",
              targets: 1,
            },
            {
              width: "7%",
              targets: 2,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 3,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 4,
              className: "text-center",
            },
            {
              width: "7%",
              targets: 5,
              className: "text-center",
            },
            {
              width: "13%",
              targets: 6,
            },
            {
              width: "13%",
              targets: 7,
            },
            {
              width: "13%",
              targets: 8,
            },
            {
              width: "7%",
              targets: 9,
              className: "text-center",
            },
            {
              targets: 10,
              visible: false,
            },
            {
              targets: 11,
              visible: false,
            },
            {
              targets: 12,
              visible: false,
            },
          ],
          dom: '<"row"<"col-md-8"f><"col-md-4"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
          ],
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });
        $("#datatables-student-search_filter").append(
          '<label class="mg-r-10">Term :<div class="semester_filter"><select id="report-term-select" class="select-term form-control custom-form report-term-list"></select></div></label>'
        );
        $("#datatables-student-search_filter").append(
          '<label class="mg-r-10">Category :<select id="report-category-select" class="select-category form-control custom-form"><option value ="">All</option><option value="10">PORE</option><option value="11">AISD</option><option value="12">CILE</option><option value="13">ACLE</option></select></label>'
        );
        $("#datatables-student-search_filter").append(
          '<label class="mg-r-10">Status :<select id="report-status-select" class="select-category form-control custom-form"><option value="">All</option><option value="60">Pending Approval</option><option value="80">Hours Approved</option><option value="90">Rejected</option></select></label>'
        );
        $("#datatables-student-search_filter").append(
          '<button type="button" class="btn btn-fill btn-default btn-sm btn-search-reset">Reset</button>'
        );
        generateTermList(".report-term-list", globalSemesterList);

        table.columns().every(function (index) {
          if (index == 10) {
            var that = this;
            $("#report-term-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 11) {
            var that = this;
            $("#report-category-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          } else if (index == 12) {
            var that = this;
            $("#report-status-select").on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function createG8G9WeeklyAssignmentListTable(userName) {
  var table = $("#datatables-entireStudentList").DataTable();
  var eData = [];
  var combineddate = $("#weeklyDatePicker").val();
  var dateArr = combineddate.split("   -   ");
  $.ajax({
    url: "../ajax_php/a.getEntireStudentListG8G9.php",
    type: "POST",
    dataType: "json",
    cache: false,
    data: {
      from:dateArr[0],
      to:dateArr[1],
    },
    // async: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        table.clear().draw();
        var studentObj = response["data"];
        for (var i = 0; i < studentObj.length; i++) {
          var name = "";
          var icon =
            '<span class="cursor-pointer" onclick="redirectToSp(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">account_circle</i></span>';
          var icon2 =
            '<span class="cursor-pointer" onclick="redirectToMc(' +
            studentObj[i].StudentID +
            ')"><i class="material-icons-outlined">supervised_user_circle</i></span>';

          var icon3 =
            '<a href="#weeklyAssignmentModal" data-target="#weeklyAssignmentModal" data-toggle="modal" class="waLink"><i data-id="' +
            studentObj[i].StudentID +
            '" class="material-icons-outlined">date_range</i></a>';
          if (response.source == "admin") {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          } else {
            atag =
              '<a class="hoverShowPic" data-id="' +
              studentObj[i].StudentID +
              '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
              studentObj[i].StudentID +
              '" target="_blank">';
          }
          var flag = getNationalFlag(studentObj[i].flag, studentObj[i].Origin);
          var age = getAge(studentObj[i].DOB);
          if (studentObj[i].EnglishName.length > 0) {
            name =
              atag +
              studentObj[i].FirstName +
              " (" +
              studentObj[i].EnglishName +
              ") " +
              studentObj[i].LastName +
              "</a>";
          } else {
            name =
              atag +
              studentObj[i].FirstName +
              " " +
              studentObj[i].LastName +
              "</a>";
          }
          var gender = getGenderIcon(studentObj[i].Sex);
          var gen_txt = "";
          if (studentObj[i].Sex == "M") {
            gen_txt = "Male";
          } else {
            gen_txt = "Female";
          }
          var house = getHouseIcon(studentObj[i].House);

          eData.push([
            name,
            icon,
            icon2,
            icon3,
            studentObj[i].comp_count,
            studentObj[i].incomp_count,
            studentObj[i].part_count,
            flag,
            gender,
            studentObj[i].CurrentGrade,
            studentObj[i].Counsellor,
            studentObj[i].Origin,
            gen_txt,
          ]);
        }
        table = $("#datatables-entireStudentList").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: true,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "asc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [100, 250, 500, -1],
            [100, 250, 500, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          dom: '<"row"<"col-md-6"f><"col-md-6"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          columnDefs: [{
              targets: 0,
              width: "10%",
            },
            {
              targets: 1,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 2,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 3,
              orderable: false,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 4,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 5,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 6,
              className: "text-center",
              width: "3%",
            },
            {
              targets: 7,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 8,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 9,
              className: "text-center",
              width: "6%",
            },
            {
              targets: 10,
              width: "10%",
            },
            {
              targets: 11,
              visible: false,
            },
            {
              targets: 12,
              visible: false,
            },
          ],
          aoColumns: [
            null,
            null,
            null,
            null,
            {
              sType: "num-html",
            },
            {
              sType: "num-html",
            },
            null,
            null,
            null,
            null,
            null,
            null,
          ],
        });

        table.column(10).every(function () {
          var column = this;
          var select = $('.wa-counsellor-list');
          select.html('');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          select.append('<option value="">All</option>');
          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              select.append('<option value="' + d + '">' + d + "</option>");
              if (d == userName) {
                // select.append('<option value="' + d + '" selected>' + d + "</option>");
                column.search(d ? "^" + d + "$" : "", true, false).draw();
              }
            });

        });



        table.column(9).every(function () {
          var column = this;
          var select = $('.wa-grade-list');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

        });

        table.column(12).every(function () {
          var column = this;
          var select = $('.wa-gender-list');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
        });

        table.column(11).every(function () {
          var column = this;
        var select = $('.wa-country-list');
        select.html('');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
            select.append('<option value="">All</option>');

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              select.append('<option value="' + d + '">' + d + "</option>");
            });
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });

  // $("#wa-counsellor").val("Ayano Kaneko").change();
}

function ajaxtoMyCourses(studentid) {
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.MyCourses.php",
    type: "POST",
    async: false,
    dataType: "json",
    data: {
      studentid: studentid,
    },
    success: function (response) {
      console.log(response);
      // $("#wa-mycourses").DataTable().clear();
      var tr;
      var careerChk;
      var responseCourses = response["courses"];
      for (var i = 0; i < responseCourses.length; i++) {
        var courseType = responseCourses[i].courseType;
        var courseId = responseCourses[i].courseId;
        var studentCourseId = responseCourses[i].studentCourseId;
        var courseName = responseCourses[i].courseName;
        var courseCd = responseCourses[i].CourseCd;
        courseName = courseName.replace("YYY", "");
        courseName = courseName.replace("ZZZ", "");
        var credit = responseCourses[i].credit;
        var teacherName = responseCourses[i].teacherName;
        var roomNo = responseCourses[i].roomNo;
        var pGrade = "n/a";
        var lGrade = "n/a";
        var late = "0";
        var absense = "0";
        var trClass;
        var modalLink = "";

        if (
          courseType.toUpperCase() != "P" &&
          courseType.toUpperCase() != "N"
        ) {
          modalLink = '';
        } else {
          var modalLink = '<a href="#weeklyAssignmentDetailModal" data-target="#weeklyAssignmentDetailModal" data-toggle="modal" class="waDetailLink"><i data-id="' + courseId + '" class="material-icons-outlined">date_range</i></a>';
        }

        var pgrade = '<span class="' + courseId + '-p naText">' + pGrade + '</span>'
        var lgrade = '<span class="' + courseId + '-l naText">' + lGrade + '</span>'
        var lateNum = '<span class="' + studentCourseId + '-late">' + late + '</span>'
        var absNum = '<span class="' + studentCourseId + '-absense">' + absense + '</span>'
        eData.push([
          courseName,
          modalLink,
          responseCourses[i].comp_count,
          responseCourses[i].incomp_count,
          responseCourses[i].part_count,
          pgrade,
          lgrade,
          credit,
          teacherName,
          roomNo,
          lateNum,
          absNum
        ]);
      }

      table = $("#wa-mycourses").DataTable({
        data: eData,
        deferRender: true,
        bDestroy: true,
        autoWidth: false,
        responsive: true,
        pagingType: "simple_numbers",
        language: {
          paginate: {
            next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
            previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
          },
        },
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ],
        order: [4, "desc"],
        columnDefs: [{
            width: "15%",
            targets: 0,
            className: "text-left",
          },
          {
            width: "5%",
            targets: 1
          },
          {
            width: "5%",
            targets: 2
          },
          {
            width: "5%",
            targets: 3
          },
          {
            width: "5%",
            targets: 4,
          },
          {
            width: "10%",
            targets: 5,
          },
          {
            width: "10%",
            targets: 6,
          },
          {
            width: "15%",
            targets: 7,
            className: "text-left"
          },
          {
            width: "10%",
            targets: 8,
          },
          {
            width: "10%",
            targets: 9,
          },
          {
            width: "10%",
            targets: 10,
          }
        ]
      });
      ajaxtoMyGrades(studentid)
      ajaxtoMyAbsenseLate(response);
      // if (careerChk == "C") {
      //   ajaxtoMyCareerLife(SemesterID);
      // }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
  // only type p OR N = credit. except p Or N all non credit
}

function ajaxtoMyGrades(studentid) {
  $.ajax({
    url: '../ajax_php/a.MyGrades.php',
    type: 'POST',
    data: {
      studentid: studentid
    },
    async: true,
    dataType: "json",
    success: function (response) {
      for (var i = 0; i < response.length; i++) {
        var courseId = response[i].courseId;
        var courseRateScaled = response[i].courseRateScaled;
        var finalRate = (courseRateScaled * 100).toFixed(1) + '%';
        var finalLetter = getGradeLetter(courseRateScaled);

        $('.' + courseId + '-p').html(finalRate);
        $('.' + courseId + '-l').html(finalLetter);

        $('.' + courseId + '-p').removeClass('naText');
        $('.' + courseId + '-l').removeClass('naText');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function ajaxtoMyAbsenseLate(globalAbsense) {
  if (globalAbsense) {
    var response = globalAbsense["Absense"];
    for (var i = 0; i < response.length; i++) {
      var studentCourseId = response[i].studentCourseId;
      var absenceCount = response[i].absenceCount;
      var lateCount = response[i].lateCount;

      $("." + studentCourseId + "-absense").html(absenceCount);
      $("." + studentCourseId + "-late").html(lateCount);
    }
  }
}

function getStudentLeaveRequest(){
  var eData = [];
  var from = $("#leave-date-from").val();
  var to = $("#leave-date-to").val();
  console.log(from);
  var staffid = $("#leave-request-staff-select").val();
  $.ajax({
    url: "../ajax_php/a.getStudentLeaveRequest.php",
    type: "POST",
    dataType: "json",
    data: {
      from:from,
      to:to,
    },
    success: function (response) {
      console.log(response);
      leaveRequestResponse = response;
      var tr;
      if (response.result == 0) {
        var table = $('#datatables-leave-request').DataTable();
        table
            .clear()
            .draw();
      } else {
        for (let i = 0; i < response.length; i++) {

          var title =
            '<a href="" data-id="' +
            response[i].LeaveID +
            '" data-toggle="modal" class="leaveRequestMdlLink">' +
            response[i].LeaveID +
            "</a>";
            var LeaveStatus = GetStatusIconV2(response[i].LeaveStatus);
          eData.push([
            title,
            response[i].LeaveType,
            response[i].StudentFullName,
            response[i].SDate,
            response[i].EDate,
            response[i].CreateDate,
            response[i].StaffFullName,
            LeaveStatus,
            response[i].ApprovalStaff,
            response[i].LeaveStatus
          ]);
        }
        table = $("#datatables-leave-request").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // responsive: true,
          scrollX: true,
          // order: [[0, "asc"]],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          columnDefs: [{
              width: "10%",
              targets: 0,
              className: "text-center",
            },{
              width: "10%",
              targets: 7,
              className: "text-center",
            },{
              visible:false,
              targets: 8,
            },{
              visible:false,
              targets: 9,
            }],
        });

        table.column(9).every(function () {
          var column = this;
          var select = $('#leave-request-status-select');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
        });

        table
        .columns( 8 )
        .search( staffid )
        .draw();

        table.column(8).every(function () {
          var column = this;
          var select = $('#leave-request-staff-select');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());


              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
        });

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getSelfAssessments() {
  var eData = [];
  var term = $("#sAssessments-term-select").val();
  console.log(term);
  $.ajax({
    url: "../ajax_php/a.getSelfAssessments.php",
    type: "POST",
    dataType: "json",
    data: {
      term:term,
    },
    success: function (response) {
      selfAssessmentsResponse = response;
      var tr;
      if (response.result == 0) {
        tr = '<tr><td colspan="6">No Record</td></tr>';
      } else {
        console.log(response);
        for (let i = 0; i < response.length; i++) {
          var LastName = response[i].LastName;
          var FirstName = response[i].FirstName;
          var EnglishName = response[i].EnglishName;
          var fullName;
          if (EnglishName) {
            fullName =
              FirstName + " (" + EnglishName + ") " + LastName;
          } else {
            fullName = FirstName + " " + LastName;
          }


          var title =
            '<a href="" data-id="' +
            response[i].AssessmentID +
            '"data-name="' +
            fullName +
            '"data-grade="' +
            response[i].CurrentGrade +
            '" data-toggle="modal" class="selfAssessmentsMdlLink">' +
            fullName +
            "</a>";
          eData.push([
            response[i].CreateDate,
            response[i].SemesterName,
            response[i].StudentID,
            title,
            response[i].CurrentGrade,
            response[i].ModifyDate,
            response[i].SemesterID,
            response[i].GradeGroup
          ]);
        }
        table = $("#datatables-selfAssessments").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "desc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          columnDefs: [{
              width: "10%",
              targets: 0,
            },{
              width: "10%",
              targets: 1,
            },{
              width: "10%",
              targets: 2,
            },{
              width: "10%",
              targets: 4,
            },{
              width: "10%",
              targets: 5,
            },{
              visible: false,
              targets: 6,
            },{
              visible: false,
              targets: 7,
            }],
        });

      table.column(6).every(function () {
          var column = this;
          var select = $('#sAssessments-term-select');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());


              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
        });

        table.column(7).every(function () {
            var column = this;
            var select = $('#sAssessments-grade-select');

              select
              .on("change", function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());


                column.search(val ? "^" + val + "$" : "", true, false).draw();
              });
          });

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getTranscriptRequest() {
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getTranscriptRequest.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      console.log(response);
      var tr;
      if (response.result == 0) {
        tr = '<tr><td colspan="6">No Record</td></tr>';
      } else {
        console.log(response);
        transcriptRequestResponse = response;
        for (let i = 0; i < response.length; i++) {
          var LastName = response[i].LastName;
          var FirstName = response[i].FirstName;
          var EnglishName = response[i].EnglishName;
          var fullName;
          if (EnglishName) {
            fullName =
              FirstName + " (" + EnglishName + ") " + LastName;
          } else {
            fullName = FirstName + " " + LastName;
          }



          var title =
            '<a href="" data-id="' +
            response[i].RequestID +
            '" data-toggle="modal" class="transcriptRequestMdlLink">' +
            response[i].CreateUserID +
            "</a>";
          eData.push([
            title,
            fullName,
            response[i].RequestDate,
            response[i].Deadline,
            response[i].Paid,
            response[i].Status,
          ]);
        }
        table = $("#datatables-transcriptRequest ").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "desc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
            },
          },
          columnDefs: [{
              width: "10%",
              targets: 4,
              className: "text-center",
            },{
              width: "10%",
              targets: 5,
              className: "text-center",
            }],

        });

      table.column(4).every(function () {
          var column = this;
          var select = $('#transcriptRequest-paid-select');

            select
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());


              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });
        });

        table.column(5).every(function () {
            var column = this;
            var select = $('#transcriptRequest-status-select');

              select
              .on("change", function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());


                column.search(val ? "^" + val + "$" : "", true, false).draw();
              });
          });

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}
