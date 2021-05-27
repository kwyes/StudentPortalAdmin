function show_actModal_student() {
  var table = $("#actMdl-student-table").dataTable({
    stateSave: true,
    order: [
      1, "asc"
    ],
    searching: false,
    paging: false,
    info: false,
    responsive: true,
    columnDefs: [
      {
        targets: 0,
        orderable: false
      }
    ]
  });
}

function createFilterV2(table, select, num1, num2, way) {
  var sVal = [];
  var rVal = [];
  var result = [];
  var s = 0;
  var t = 0;
  var final;
  for (var i = num1; i <= num2; i++) {
    table.column(i).cache("search").unique().each(function (d) {
      if (i == num2) {
        sVal.push(d);
        sVal[s] = {
          id: d
        };
        s++;
      } else {
        rVal[t] = {
          text: d
        };
        t++;
      }
    });
  }

  for (var w = 0; w < sVal.length; w++) {
    result[w] = {
      id: sVal[w].id,
      text: rVal[w].text
    };
  }
  if (way == "asc") {
    final = result.slice(0);
    final.sort(function (a, b) {
      return a.id - b.id;
    });
  } else {
    final = result;
  }

  console.log(final);
  for (var j = 0; j < final.length; j++) {
    select.append($('<option value="' + final[j].id + '">' + final[j].text + "</option>"));
  }
}

function createCurrentStudentListTable(name) {
  var table = $("#datatables-currentStudentList").DataTable();
  var html = "";
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.getMyStudentList.php",
    type: "POST",
    dataType: "json",
    data: {
      name: name
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
          var icon = '<span class="cursor-pointer" onclick="redirectToSp(' + studentObj[i].StudentID + ')"><i class="material-icons-outlined">assignment_ind</i></span>';

          if (response.source == "admin") {
            atag = '<a href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' + studentObj[i].StudentID + '" target="_blank">';
          } else {
            atag = '<a href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' + studentObj[i].StudentID + '" target="_blank">';
          }

          if (studentObj[i].EnglishName.length > 0) {
            name = atag + studentObj[i].FirstName + " (" + studentObj[i].EnglishName + ") " + studentObj[i].LastName + "</a>";
          } else {
            name = atag + studentObj[i].FirstName + " " + studentObj[i].LastName + "</a>";
          }

          eData.push([
            name, icon, studentObj[i].Origin,
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
            studentObj[i].MentorTeacher
          ]);
        }
        table = $("#datatables-currentStudentList").DataTable({
          data: eData, deferRender: true, bDestroy: true, autoWidth: true,
          // responsive: true,
          scrollX: true,
          order: [
            [0, "asc"]
          ],
          pagingType: "simple_numbers",
          lengthMenu: [
            [
              100, 250, 500, -1
            ],
            [
              100, 250, 500, "All"
            ]
          ],
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>' // or '←'
            }
          },
          dom: '<"row"<"col-md-6"f><"col-md-6"l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          columnDefs: []
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}
