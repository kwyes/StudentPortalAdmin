var globalStudentListBySubject;

function generateCategoryItemsTable(response) {
  var table = $("#datatables-bogs-categoryItem").DataTable();
  var eData = [];
  for (var i = 0; i < response.length; i++) {
    var chkbox =
      '<input class="bogs-categoryItem-check" type="checkbox" value="' +
      response[i].CategoryItemID +
      '">';
    var title =
      '<input class="form-control change-input" type="text" value="' +
      response[i].Title +
      '">';
    var assignDate =
      '<input class="form-control datepicker maxWidth-250 change-input" data-date-format="YYYY-MM-DD" type="text" value="' +
      response[i].AssignDate +
      '">';

    var CategoryWeight = parseFloat(response[i].ItemWeight * 100).toFixed(2);

    var ItemWeight =
      '<input class="form-control 2decimal max100 onlyNum change-input" type="number" step="any" value="' +
      CategoryWeight +
      '">';
    var maxValue =
      '<input class="form-control 2decimal onlyNum change-input" type="number" step="any" value="' +
      response[i].MaxValue +
      '">';
    var body =
      '<input class="form-control change-input" type="text" value="' +
      response[i].Body.replace(/"/g, "&quot;") +
      '">';

    eData.push([
      chkbox,
      response[i].CategoryItemID,
      response[i].Text,
      title,
      assignDate,
      ItemWeight,
      maxValue,
      body,
    ]);
  }
  table.clear();
  table = $("#datatables-bogs-categoryItem").DataTable({
    data: eData,
    deferRender: true,
    bDestroy: true,
    autoWidth: false,
    responsive: true,
    pagingType: "simple_numbers",
    paging: false,
    language: {
      paginate: {
        next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
        previous: '<i class="material-icons">keyboard_arrow_left</i>', // or '←'
      },
    },
    order: [4, "asc"],
    columnDefs: [{
        width: "3%",
        targets: 0,
        orderable: false,
        className: "text-center",
      },
      {
        width: "7%",
        targets: 1,
        className: "text-center minWidth-60",
      },
      {
        width: "19%",
        targets: 2,
        className: "ellipsis-td",
      },
      {
        width: "20%",
        targets: 3,
      },
      {
        width: "10%",
        targets: 4,
      },
      {
        width: "10%",
        targets: 5,
        className: "minWidth-90",
      },
      {
        width: "6%",
        targets: 6,
        className: "minWidth-55",
      },
      {
        width: "25%",
        targets: 7,
      },
    ],
    dom: '<"row"<"col-md-12 bogsSettings-cateItems-filter-wrapper text-right">>t<"row"<"col-md-6"i><"col-md-6"p>>',
  });

  $(".bogsSettings-cateItems-filter-wrapper").append(
    '<select id="categoryItemList" name="categoryItemList"' +
    'class="form-control custom-form width-200 categoryItemList inlineBlock"></select>'
  );

  var select = $("#categoryItemList");

  table.column(2).every(function () {
    var that = this;
    //empty filter again

    $("#categoryItemList").empty().append('<option value="">All</option>');
    var val = "";
    that.search(val ? "^" + val + "$" : "", true, false).draw();

    // empty
    this.cache("search")
      .sort()
      .unique()
      .each(function (d) {
        select.append($('<option value="' + d + '">' + d + "</option>"));
      });
    select.on("change", function () {
      var val = $.fn.dataTable.util.escapeRegex($(this).val());
      that.search(val ? "^" + val + "$" : "", true, false).draw();
    });
  });
}

function generateEnterGradeTable(globalEnterGradeList, object) {
  var tr;
  var point;
  var chk;
  var maxValue = $(".item-MaxValue").val();
  console.log(globalEnterGradeList);
  for (var i = 0; i < globalEnterGradeList.length; i++) {
    if (globalEnterGradeList[i].ScorePoint == ".00") {
      point = "0.00";
    } else {
      point = globalEnterGradeList[i].ScorePoint;
    }

    if (globalEnterGradeList[i].Exempted == 1) {
      chk = "checked";
    } else {
      chk = "";
    }

    var atag =
      '<a class="hoverShowPic enterGradePic" data-id="' +
      globalEnterGradeList[i].StudentID +
      '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      globalEnterGradeList[i].StudentID +
      '" target="_blank">';

    if (globalEnterGradeList[i].GradeID == 0) {
      tr +=
        "<tr class='color-FFA21A'>" +
        '<td class="text-center"><input class="bogs-grade-check" type="checkbox" value="' +
        globalEnterGradeList[i].GradeID +
        '" data-id="' +
        globalEnterGradeList[i].StudSubjID +
        '" disabled></td>' +
        '<td class="text-center"><span class="redirect-admin-studentid">' +
        globalEnterGradeList[i].StudentID +
        '</span><div class="form-group mg-0 pd-0"><input type="hidden" class="form-control custom-form studSubId" value="' +
        globalEnterGradeList[i].StudSubjID +
        '"></div></td>' +
        '<td class="ellipsis-td">' +
        atag +
        createFullName(
          globalEnterGradeList[i].EnglishName,
          globalEnterGradeList[i].FirstName,
          globalEnterGradeList[i].LastName
        ) +
        "</a></td>" +
        '<td class="text-center"><div><input type="checkbox" class="change-input exempt-chk" value="' +
        globalEnterGradeList[i].Exempted +
        '"' +
        chk +
        "></div></td>" +
        '<td class="text-center"><input type="number" class="form-control custom-form 2decimal onlyNum change-input eGradeScore" value="' +
        point +
        '"></td>' +
        '<td class="text-center">' +
        maxValue +
        "</td>" +
        '<td><input type="text" class="form-control custom-form change-input eGradeComment" value="' +
        globalEnterGradeList[i].Comment +
        '"></td>' +
        "</tr>";
    } else {
      tr +=
        "<tr>" +
        '<td class="text-center"><input class="bogs-grade-check" type="checkbox" value="' +
        globalEnterGradeList[i].GradeID +
        '" data-id="' +
        globalEnterGradeList[i].StudSubjID +
        '" disabled></td>' +
        '<td class="text-center"><span class="redirect-admin-studentid">' +
        globalEnterGradeList[i].StudentID +
        '</span><div class="form-group mg-0 pd-0"><input type="hidden" class="form-control custom-form studSubId" value="' +
        globalEnterGradeList[i].StudSubjID +
        '"></div></td>' +
        '<td class="ellipsis-td">' +
        atag +
        createFullName(
          globalEnterGradeList[i].EnglishName,
          globalEnterGradeList[i].FirstName,
          globalEnterGradeList[i].LastName
        ) +
        "</a></td>" +
        '<td class="text-center"><div><input type="checkbox" class="change-input exempt-chk" value="' +
        globalEnterGradeList[i].Exempted +
        '"' +
        chk +
        "></div></td>" +
        '<td class="text-center"><input type="number" class="form-control custom-form 2decimal onlyNum change-input eGradeScore" value="' +
        point +
        '"></td>' +
        '<td class="text-center">' +
        maxValue +
        "</td>" +
        '<td><input type="text" class="form-control custom-form change-input eGradeComment" value="' +
        globalEnterGradeList[i].Comment +
        '"></td>' +
        "</tr>";
    }
  }
  $("#datatables-bogs-enterGrade tbody").html(tr);
}

function generateViewTableHeader(globalGradeList, object) {
  var tr;
  var th;
  var list = globalGradeList["viewGradeTableHeader"][object];
  for (var j = 0; j < globalSemesterList.length; j++) {
    if (globalSemesterList[j].SemesterID == $(".termList").val()) {
      var midDate = globalSemesterList[j].MidCutOffDate;
    }
  }
  th =
    "<th>STUDENT ID</th>" +
    "<th>STUDENT NAME</th>" +
    "<th>MIDTERM<br/> ECPP<br/> [MAX 100%]</th>" +
    "<th>MIDTERM<br/> ECWP<br/> [MAX 10%]</th>" +
    "<th>FINAL<br/> ECPP<br/> [MAX 100%]</th>" +
    "<th>FINAL<br/> ECWP<br/> [MAX 10%]</th>";
  for (var i = 8; i < list.length; i++) {
    var cat = getCategoryItemInfo(list[i]);
    var title = "<label>" + cat[1] + "</label><br />" + cat[2];
    if (new Date(cat[1]) > new Date(midDate)) {
      th += "<th class='viewGrade-final'>" + title + "</th>";
    } else {
      th += "<th class='viewGrade-mid'>" + title + "</th>";
    }
  }
  tr = "<tr>" + th + "</tr>";
  $("#datatables-bogs-viewGrade thead").html(tr);
}

function generateViewTableRows(
  globalGradeList,
  selectedCourse,
  selectedCategory
) {
  var tr;
  var td;
  var lasttr;
  console.log(globalGradeList);
  console.log(globalGradeList["viewGradeTable"]);
  var list = globalGradeList["viewGradeTable"][selectedCategory];
  for (var i = 0; i < list.length; i++) {
    var sub = list[i];
    atag =
      '<a class="hoverShowPic viewGradePic" data-id="' +
      sub[0] +
      '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      sub[0] +
      '" target="_blank">';
    td +=
      "<td class='text-center'><span class='redirect-admin-studentid'>" +
      sub[0] +
      "</span></td>";
    if (sub[2] == "Class Average") {
      td +=
        "<td class='color-18acbc text-center' style='font-weight: bold'>" +
        sub[2] +
        "</td>";
    } else {
      td +=
        "<td>" + atag + createFullName(sub[3], sub[2], sub[1]) + "</a></td>";
    }

    for (var s = 0; s < sub.length; s++) {
      if (s < 4) {} else {
        if (sub[s].label) {
          if (sub[s].status == "normal") {
            td += "<td>" + sub[s].label + "</td>";
          } else {
            td += createItalicText(sub[s].status, sub[s].label);
          }
        } else {
          td += createItalicText(sub[s].status, "");
        }
      }
    }

    tr += "<tr>" + td + "</tr>";
    td = "";
  }

  $("#datatables-bogs-viewGrade tbody").html(tr);

  var table = $("#datatables-bogs-viewGrade").DataTable({
    // fixedColumns: {
    //   leftColumns: 2
    // },
    scrollY: "494px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    ordering: false,
  });

  new $.fn.dataTable.FixedColumns(table, {
    leftColumns: 2, //specifies how many left columns should be fixed.
  });
}

function generateOverViewTableHeader(globalGradeList, object) {
  var tr;
  var th;
  var list = globalGradeList["overviewTableHeader"][object];

  for (var j = 0; j < globalSemesterList.length; j++) {
    if (globalSemesterList[j].SemesterID == $(".termList").val()) {
      var midDate = globalSemesterList[j].MidCutOffDate;
    }
  }

  th = "<th>STUDENT ID</th>" + "<th>STUDENT NAME</th>";
  for (var i = 4; i < list.length; i++) {
    var cat = getCategoryItemInfo(list[i]);
    var title = "<label>" + cat[1] + "</label><br />" + cat[2];
    if (new Date(cat[1]) > new Date(midDate)) {
      th += "<th class='overView-final'>" + title + "</th>";
    } else {
      th += "<th class='overView-mid'>" + title + "</th>";
    }
  }
  tr = "<tr>" + th + "</tr>";
  $("#datatables-bogs-viewGrade thead").html(tr);
}

function generateOverViewTableRows(globalGradeList, selectedCourse) {
  var tr;
  var td;
  var lasttr;
  var list = globalGradeList["overviewTable"][selectedCourse];
  for (var i = 0; i < list.length; i++) {
    var sub = list[i];
    atag =
      '<a class="hoverShowPic overViewPic" data-id="' +
      sub[0] +
      '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      sub[0] +
      '" target="_blank">';
    td +=
      "<td class='text-center'><span class='redirect-admin-studentid'>" +
      sub[0] +
      "</span></td>";
    if (sub[2] == "Class Average") {
      td +=
        "<td class='color-18acbc text-center' style='font-weight: bold'>" +
        sub[2] +
        "</td>";
    } else {
      td +=
        "<td>" + atag + createFullName(sub[3], sub[2], sub[1]) + "</a></td>";
    }

    for (var s = 0; s < sub.length; s++) {
      if (s < 4) {} else {
        if (sub[s].label) {
          if (sub[s].status == "normal") {
            td += "<td>" + sub[s].label + "</td>";
          } else {
            td += createItalicText(sub[s].status, sub[s].label);
          }
        } else {
          td += createItalicText(sub[s].status, "");
        }
      }
    }

    tr += "<tr>" + td + "</tr>";
    td = "";
  }

  $("#datatables-bogs-viewGrade tbody").html(tr);

  var table = $("#datatables-bogs-viewGrade").DataTable({
    // fixedColumns: {
    //   leftColumns: 2
    // },
    scrollY: "494px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    ordering: false,
  });

  new $.fn.dataTable.FixedColumns(table, {
    leftColumns: 2, //specifies how many left columns should be fixed.
  });
}

function getCategoryItemInfo(categoryItemId) {
  var arr = [];
  arr[0] = globalOptionsListV2["itemMap"][categoryItemId].CategoryItemID;
  arr[1] = globalOptionsListV2["itemMap"][categoryItemId].AssignDate;
  arr[2] = globalOptionsListV2["itemMap"][categoryItemId].Title;
  return arr;
}

function getCategoryWeightInfo(categoryItemId, categoryId) {
  var list = globalOptionsListV2["CategoryList"][categoryItemId];
  for (let i = 0; i < list.length; i++) {
    if (categoryId == list[i].categoryId) {
      return list[i].weight;
    }
  }
  return null;
}

function createItalicText(status, label) {
  var classname = "";
  var td = "";

  if (status == "na") {
    classname = "viewGrade-italic";
  } else if (status == "exempted") {
    classname = "viewGrade-italic-2980b9";
  } else if (status == "pending") {
    classname = "viewGrade-italic";
  } else if (status == "overdue") {
    classname = "viewGrade-italic-f08f00";
  } else {
    classname = "viewGrade-italic";
  }

  if (label) {
    td = "<td class=" + classname + ">" + label + "</td>";
  } else {
    td = "<td class=" + classname + ">" + status + "</td>";
  }

  return td;
}

function generateOverallTableHeader(globalGradeList, object) {
  var tr;
  var th;
  var list = globalGradeList["overallAverageTable"][object][0];
  th =
    "<th>STUDENT ID</th>" +
    "<th>STUDENT NAME</th>" +
    "<th>MIDTERM<br/> PERCENT<br/> GRADE</th>" +
    "<th>MIDTERM<br/> LETTER<br/> GRADE</th>" +
    "<th>CURRENT<br/> PERCENT<br/> GRADE</th>" +
    "<th>CURRENT<br/> LETTER<br/> GRADE</th>";
  for (var i = 8; i < list.length; i++) {
    var weight = getCategoryWeightInfo(object, list[i].categoryId);
    var title =
      list[i].categoryName +
      "<br /><label>ECWP</label>" +
      "<br /><label>[MAX " +
      weight * 100 +
      "%]</label>";
    th += "<th class='viewGrade-mid'>" + title + "</th>";
  }
  tr = "<tr>" + th + "</tr>";
  $("#datatables-bogs-viewGrade thead").html(tr);
}

function generateOverallTableRows(globalGradeList, selectedCourse) {
  var tr;
  var td;
  var list = globalGradeList["overallAverageTable"][selectedCourse];
  for (var i = 0; i < list.length; i++) {
    var sub = list[i];
    atag =
      '<a class="hoverShowPic overallPic" data-id="' +
      sub[0] +
      '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      sub[0] +
      '" target="_blank">';
    td +=
      "<td class='text-center'><span class='redirect-admin-studentid'>" +
      sub[0] +
      "</span></td>";
    if (sub[2] == "Class Average") {
      td +=
        "<td class='color-18acbc text-center' style='font-weight: bold'>" +
        sub[2] +
        "</td>";
    } else {
      td +=
        "<td>" + atag + createFullName(sub[3], sub[2], sub[1]) + "</a></td>";
    }
    // td += "<td><span class='redirect-admin-studentid'>" + sub[0] + "</span></td>" + "<td>" + atag + createFullName(sub[3], sub[2], sub[1]) + "</a></td>";

    for (let j = 4; j < sub.length; j++) {
      if (sub[j].label) {
        if (sub[j].status == "normal") {
          td += "<td>" + sub[j].label + "</td>";
        } else {
          td += createItalicText(sub[j].status, sub[j].label);
        }
      } else {
        td += createItalicText(sub[j].status, "");
      }
    }

    tr += "<tr>" + td + "</tr>";
    td = "";
  }

  $("#datatables-bogs-viewGrade tbody").html(tr);

  var table = $("#datatables-bogs-viewGrade").DataTable({
    // fixedColumns: {
    //   leftColumns: 2
    // },
    scrollY: "494px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    ordering: false,
  });

  new $.fn.dataTable.FixedColumns(table, {
    leftColumns: 2, //specifies how many left columns should be fixed.
  });

  $("#datatables-bogs-viewGrade tbody").trigger("mouseover");
}

function getStudentListBySubject() {
  var course = $(".courseList").val();
  var table = $("#datatables-bogs-weeklyAssignment").DataTable();
  var eData = [];

  var courseSet = findEachcourses(globalcourselistV2, course);
  console.log(courseSet);

  $.ajax({
    url: "../ajax_bogs/a.getStudentListBySubject.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      course: courseSet,
    },
    success: function (response) {
      if (response.result == 0) {
        $("#datatables-bogs-weeklyAssignment tbody").html('');
        showSwal("error", "Something went wrong!");
      } else {
        console.log(response);
        globalStudentListBySubject = response;
        // var course_id = $(".courseList option:selected").val();
        for (let i = 0; i < response.length; i++) {
          var fullname = "";
          if (response[i].EnglishName != "") {
            fullname =
              response[i].FirstName +
              " (" +
              response[i].EnglishName +
              ") ";
          } else {
            fullname = response[i].FirstName;
          }

          var id_link =
            '<span class="redirect-admin-studentid">' +
            response[i].StudentID +
            "</span>";

          var name_atag =
            '<a class="hoverShowPic enterGradePic" data-id="' +
            response[i].StudentID +
            '" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
            response[i].StudentID +
            '" target="_blank">';

          var student_name = name_atag + fullname + "</a>";

          var classname_key = response[i].StudentID + "-" + response[i].SubjectID;

          var assignments =
            "<div class='row'>" +
            "<div class='col-md-12 row row-eq-height' >" +
            "<div class='col-md-1'><input class='wa-check wa-check-1' type='checkbox' data-id='" + classname_key + "' value='" + response[i].StudentID + "' disabled></div>" +
            "<div class='col-md-1 text-center'>1</div>" +
            "<div class='col-md-8'>" +
            "<input type='text' class='form-control custom-form change-input-wa wa" + classname_key + "-1 wa-input-text' name='wAssignment1' placeholder='Weekly Assignment1' />" +
            "<input type='hidden' class='waId" + classname_key + "-1 hidden-waId' value='' />" +
            "</div>" +
            "<div class='col-md-2 text-center'>" +
            "<select class='select" + classname_key + "-1 form-control custom-form change-input-wa wa-input-select' style='font-size:14px; font-family:Arial, Material Icons;'><option value='1'>&#xe14c</option><option value='2'>&#xe033</option><option value='3'>&#xe876</option></select>" +
            "</div></div>" +
            "<div class='col-md-12 row row-eq-height' >" +
            "<div class='col-md-1'><input class='wa-check wa-check-2' type='checkbox' data-id='" + classname_key + "' value='" + response[i].StudentID + "' disabled></div>" +
            "<div class='col-md-1 text-center'>2</div>" +
            "<div class='col-md-8'>" +
            "<input type='text' class='form-control custom-form change-input-wa wa" + classname_key + "-2 wa-input-text' name='wAssignment2' placeholder='Weekly Assignment2' />" +
            "<input type='hidden' class='waId" + classname_key + "-2 hidden-waId' value = ''/>" +
            "</div>" +
            "<div class='col-md-2 text-center'>" +
            "<select class='select" + classname_key + "-2 form-control custom-form change-input-wa wa-input-select' style='font-size:14px; font-family:Arial, Material Icons;'><option value='1'>&#xe14c</option><option value='2'>&#xe033</option><option value='3'>&#xe876</option></select>" +
            "</div></div>" +
            "<div class='col-md-12 row row-eq-height' >" +
            "<div class='col-md-1'><input class='wa-check wa-check-3' type='checkbox' data-id='" + classname_key + "' value='" + response[i].StudentID + "' disabled></div>" +
            "<div class='col-md-1 text-center'>3</div>" +
            "<div class='col-md-8'><input type='text' class='form-control custom-form change-input-wa wa" + classname_key + "-3 wa-input-text' name='wAssignment3' placeholder='Weekly Assignment3' />" +
            "<input type='hidden' class='waId" + classname_key + "-3 hidden-waId' value = '' />" +
            "</div>" +
            "<div class='col-md-2 text-center'>" +
            "<select class='select" + classname_key + "-3 form-control custom-form change-input-wa wa-input-select' style='font-size:14px; font-family:Arial, Material Icons;'><option value='1'>&#xe14c</option><option value='2'>&#xe033</option><option value='3'>&#xe876</option></select>" +
            "</div></div>" +
            "</div > ";

          eData.push([
            id_link,
            student_name,
            response[i].LastName,
            assignments
          ]);
        }

        table.clear();
        table = $("#datatables-bogs-weeklyAssignment").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          bPaginate: false,
          order: [2, "asc"],
          columnDefs: [{
              width: "13%",
              targets: 0,
              className: "text-center"
            },
            {
              width: "25%",
              targets: 1
            },
            {
              width: "12%",
              targets: 2
            },
            {
              width: "50%",
              targets: 3,
            }
          ],
          dom: '<"row"<"col-md-12 status_text">><"row"<"col-md-6 week"><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>',
        });
        var status_text =
          '<div class="text-right"><label class="row-eq-height"><i class="material-icons font-14">clear</i>&nbsp;Incomplete</label> / ' +
          '<label class="row-eq-height"><i class="material-icons font-14">not_interested</i>&nbsp;Partially Complete</label> / ' +
          '<label class="row-eq-height"><i class="material-icons font-14">done</i>&nbsp;Complete</label></div>';
        $(".status_text").html(status_text);
        // $(
        //   '<label class="mg-r-10">Week :<div class="select-container"><input type="text" id="weeklyDatePicker2" class="form-control custom-form mg-lr-7 maxWidth-none datepicker" data-date-format="YYYY-MM-DD" placeholder="Select Week" /></div></label>'
        // ).appendTo(".week");

      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}
