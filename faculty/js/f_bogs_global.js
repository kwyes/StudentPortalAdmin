var eachCategoryArr = [];
var outOfForCategory;
var errorArr = [];
var bogscategoryArr = [{
  val: "",
  text: "Select Category.."
}, {
  val: 10,
  text: "Assignments"
}, {
  val: 11,
  text: "Quizzes"
}, {
  val: 12,
  text: "Participation"
}, {
  val: 14,
  text: "Tests"
}, {
  val: 20,
  text: "Midterm Exam"
}, {
  val: 21,
  text: "Final Exam"
}, {
  val: 99,
  text: "Custom"
}];
var categoryColor = [];
var eventColors = [
  "bgColor-E60012",
  "bgColor-00A0E9",
  "bgColor-F39800",
  "bgColor-920783",
  "bgColor-009E96",
  "bgColor-0068B7",
  "bgColor-8FC31F",
  "bgColor-1D2088",
  "bgColor-009944",
  "bgColor-E4007F"
];

$(document).on("keypress", ".onlyNum", function (evt) {
  if ((evt.which != 8 && evt.which != 13 && evt.which != 46 && evt.which < 48) || (evt.which > 57 && evt.which != 190)) {
    evt.preventDefault();
  }
});

$(document).on("blur", ".2decimal", function () {
  var val = $(this).val();
  if (val.split(".").length > 2) {
    $(this).val(val.split(".")[0]);
  } else {
    if (val) {
      var newVal = Math.round(val * 100) / 100;
      $(this).val(newVal.toFixed(2));
    }
  }
});

$(document).on("blur", ".max100", function () {
  var val = $(this).val();
  if (val > 100) {
    var num = 100;
    $(this).val(num.toFixed(2));
  }
});

$(document).on("change", ".change-input", function () {
  var checkbox = $(this).parent().parent().parent()[0].children[0].children[0];
  $(checkbox).prop("checked", true);
});


$(document).on("keypress", "input[type='text'], input[type='number']", function (event) {
  var target = $(event.target);
  var textboxes = $("input");
  if (target.hasClass("eGradeScore")) {
    textboxes = $("input.eGradeScore");
  } else if (target.hasClass("eGradeComment")) {
    textboxes = $("input.eGradeComment");
  }
  if (event.keyCode == 13) {
    debugger;
    currentBoxNumber = textboxes.index(this);
    if (textboxes[currentBoxNumber + 1] != null) {
      nextBox = textboxes[currentBoxNumber + 1];
      nextBox.focus();
      nextBox.select();
      event.preventDefault();
      return false;
    }
  }
});

$(document).on("click", "#btn-bogs-category-cansel, #btn-bogs-categoryItem-cansel", function () {
  location.href = "?page=dashboard";
});

var minimizeSidebar = false;
$("#minimizeSidebar").on("click", function () {
  minimizeSidebar = !minimizeSidebar;
  $(".bogsSubMenu").css(
    "padding-left", minimizeSidebar ?
    "0px" :
    "20px");
});

function generateCourseList(select, globalcourselist, all) {
  var options = "";
  if (all) {
    options = "<option value='all'>All</option>";
  }
  for (let i = 0; i < globalcourselist.length; i++) {
    options += '<option value="' + globalcourselist[i].SubjectID + '">' + globalcourselist[i].SubjectName + "</option>";
  }
  $(select).html(options);
}

function generateCourseListV2(select, globalcourselist, all) {
  var options = "";
  if (all) {
    options = "<option value='all'>All</option>";
  }

  Object.keys(globalcourselist).forEach(function(key) {
      if(!globalcourselist[key]['CSubjectID']){
        options += '<option value="' + globalcourselist[key]['SubjectID'] + '">' + globalcourselist[key]['SubjectName'] + "</option>";
      }
  });

  $(select).html(options);
}

function generateCategoryListV2(select, selected, optionlist, all) {
  var options = "";
  if (all) {
    options = "<option value='all'>All</option>";
  }
  var list = optionlist[selected];
  var EachCategoryWeight;
  if (!list) {
    showSwalBogs("error", "Finish Course Settings!");
    return;
  }
  for (let i = 0; i < list.length; i++) {
    EachCategoryWeight = parseFloat(list[i].weight * 100) + "%";
    options += '<option value="' + list[i].categoryId + '">' + list[i].text + " (" + EachCategoryWeight + ")" + "</option>";
  }
  $(select).html(options);
}

function generateCategoryListV4(select, optionlist, all) {
  var options = "";
  options = "<option value='all'>All</option>";
  var eventColorIndex = 1;
  for (let i = 0; i < optionlist.length; i++) {
    options += '<option value="' + optionlist[i].CategoryID + '">' + optionlist[i].Text + "</option>";
    categoryColor[optionlist[i].CategoryID] = eventColors[eventColorIndex];

    if (eventColorIndex + 1 >= eventColors.length) {
      eventColorIndex = 1;
    } else {
      eventColorIndex++;
    }
  }
  $(select).html(options);
}

function generateCategoryItemList(select, selected, optionlist) {
  var options = "";
  var list = optionlist[selected];
  for (let i = 0; i < list.length; i++) {
    EachCategoryWeight = parseFloat(list[i].weight * 100).toFixed(2);

    options += '<option value="' + list[i].CategoryItemID + '">' + list[i].Title + "</option>";
  }
  $(select).html(options);
}

function generateCategoryList(tbody, globalCategoryList) {
  var tr = "";
  var EachCategoryWeight;
  var selectedCourseText = $(".courseList option:selected").text();
  var text = "";
  var textclass = "";

  for (let i = 0; i < globalCategoryList.length; i++) {
    EachCategoryWeight = parseFloat(globalCategoryList[i].EachCategoryWeight * 100).toFixed(2);
    if (EachCategoryWeight !== "100.00") {
      text = "Item category weight of <span class='text-weight-700 inlineBlock'>" + selectedCourseText + " > " + globalCategoryList[i].Text + "</span> not equal to 100%";
      errorArr.push(text);
      textclass = "text-warning";
    } else {
      textclass = "";
    }
    tr += "<tr>" + '<td class="text-center"><input class="bogs-category-check" type="checkbox" value="' + globalCategoryList[i].CategoryID + '"></td>' + "<td class='text-center'>" + globalCategoryList[i].CategoryID + "</td>" + '<td><input type="text" class="form-control custom-form bogs-category-name change-input" value="' + globalCategoryList[i].Text + '"></td>' + '<td><input type="number" class="form-control custom-form 2decimal max100 onlyNum change-input" step="any" value="' + (
      globalCategoryList[i].CategoryWeight * 100).toFixed(2) + '"></td>' + "<td>%</td>" + "<td class='text-center'>" + globalCategoryList[i].ItemCount + "</td>" + '<td class="' + textclass + ' text-center">' + EachCategoryWeight + "%</td>" + "</tr>";
  }
  $(tbody).html(tr);
}

function calculateNumandPercentage(globalCategoryList, globalCategoryItemsList) {
  var categorysum = 0;
  var floatLen = 0;
  var sum = 0;
  for (var i = 0; i < globalCategoryList.length; i++) {
    var splitNum = globalCategoryList[i].CategoryWeight.toString().split(".");
    if (splitNum[1] && floatLen < splitNum[1].length) {
      floatLen = splitNum[1].length;
    }
    categorysum += parseFloat(globalCategoryList[i].CategoryWeight) * 100;
    sum = Math.floor(categorysum * Math.pow(10, floatLen)) / Math.pow(10, floatLen);
  }
  var selectedCourseText = $(".courseList option:selected").text();

  if (sum / 100 !== 1) {
    var text = "Category weight of <span class='text-weight-700 inlineBlock'>" + selectedCourseText + "</span> not equal to 100%";
    errorArr.push(text);
  }
}

function displayErr(arr) {
  var arrTxt = "";
  for (let i = 0; i < arr.length; i++) {
    arrTxt += arr[i] + "<br />";
  }
  if (arr.length > 0) {
    showNotification("top", "center", "warning", arrTxt);
  }
}

function customSerializeArray(id) {
  var addBogsCategoryForm = $(id).serializeArray();
  var addBogsCategoryObject = {};
  $.each(addBogsCategoryForm, function (i, v) {
    addBogsCategoryObject[v.name] = v.value;
  });
  return addBogsCategoryObject;
}


function controlCourseSettingsFunction(itemsArr, chk) {
  if (chk == 0) {
    saveCategory(itemsArr);
  } else if (chk == 1) {
    deleteCategory(itemsArr);
  } else if (chk == 2) {
    saveCategoryItems(itemsArr);
  } else if (chk == 3) {
    deleteCategoryItems(itemsArr);
  } else {
    alert("Contact IT");
  }
}

function showSwalBogs(type, title = "", path = "", data1 = "", data2 = "") {
  if (type == "error") {
    swal({
      title: title,
      buttonsStyling: false,
      confirmButtonClass: "btn btn-info"
    }).catch(swal.noop);
  } else if (type == "success") {
    swal({
      title: "Success!",
      buttonsStyling: false,
      confirmButtonClass: "btn btn-info",
      type: "success"
    }).then(function () {
      redirectToBogs(path, data1, data2);
    }).catch(swal.noop);
  }
}

function displayItemInfo(globalOptionsList) {
  var selectedCourse = $(".courseList").val();
  var selectedCategory = $(".categoryList").val();
  var selectedItem = $(".itemList").val();
  var selectedCourseText = $(".courseList option:selected").text();
  var selectedCategoryText = $(".categoryList option:selected").text();
  var selectedItemText = $(".itemList option:selected").text();
  $(".course-info").html(selectedCourseText + " - " + selectedCategoryText + " - " + selectedItemText);
  var cateWeight = parseFloat(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].CategoryWeight * 100).toFixed(2);
  var itemWeight = parseFloat(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].ItemWeight * 100).toFixed(2);
  $(".enterGrade-category").html(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].Text);
  $(".enterGrade-item").html(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].Title);
  $(".enterGrade-cateWeight").html(cateWeight + "%");
  $(".enterGrade-itemWeight").html(itemWeight + "%");
  $(".enterGrade-assignDate").html(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].AssignDate);
  $(".item-MaxValue").val(globalOptionsList["categoryItemMap"][selectedCourse][selectedCategory][selectedItem].MaxValue);
}

function displayItemInfoView(globalOptionsListV2) {
  var selectedCourse = $(".courseList").val();
  var selectedCategory = $(".categoryList").val();
  var selectedCourseText = $(".courseList option:selected").text();
  var selectedCategoryText = $(".categoryList option:selected").text();
  $(".course-info").html(globalOptionsListV2["termInfo"][0].SemesterName + " - " + selectedCourseText + " - " + selectedCategoryText);
  $(".term-title").html(globalOptionsListV2["termInfo"][0].txt);
}

function initFullCalendar(globalSchedulelist, course, category) {
  $calendar = $("#fullCalendar");

  today = new Date();
  y = today.getFullYear();
  m = today.getMonth();
  d = today.getDate();

  var eventItems = getCalenderEvents(globalSchedulelist, course, category);

  $calendar.fullCalendar({
    viewRender: function (view, element) {
      // We make sure that we activate the perfect scrollbar when the view isn't on Month
      if (view.name != "month") {
        $(element).find(".fc-scroller").perfectScrollbar();
      }
    },
    header: {
      left: "title",
      center: "month,agendaWeek,agendaDay",
      right: "prev,next,today"
    },
    defaultDate: today,
    views: {
      month: {
        titleFormat: "MMMM YYYY"
      },
      week: {
        titleFormat: " MMMM D YYYY",
        rows: 2
      },
      day: {
        titleFormat: "D MMM, YYYY"
      }
    },
    eventLimit: true, // allow "more" link when too many events
    events: eventItems,
    eventDrop: function (jsEvent, dayDelta, minuteDelta, allDay, revertFunc) {
      if (dayDelta._days != 0) {
        var date = new Date(jsEvent.start._i)
        var newdate = moment(date.setDate(date.getDate() + dayDelta._days)).format('YYYY-MM-DD');

        var updateData = {
          subjectId: jsEvent.subjectId,
          categoryId: jsEvent.categoryId,
          categoryItemId: jsEvent.categoryItemId,
          assignDate: newdate
        }
        console.log(updateData)
        updateCourseCalendarEvent(updateData)
      }
    },
    eventClick: function (info) {
      var title = '';
      var date = '';
      var bgColor = '';
      if (info.id) {
        var id = info.id;
        var rawDataArr = info.source.rawEventDefs;
        for (let i = 0; i < rawDataArr.length; i++) {
          if (id == rawDataArr[i].id) {
            title = rawDataArr[i].title;
            date = rawDataArr[i].start;
            bgColor = rawDataArr[i].className;
            break;
          }
        }
      } else {
        title = info.title;
        date = info.start;
        bgColor = info.className;
      }

      $('#courseCalendarEventModal').modal({
        show: true
      });
      $('.calendarEventTitle').html(title);
      $('.calendarEventDate').html(moment(date).format('LL'));
      $('.calendarEvent').addClass(bgColor);
    }
  });
}

function updateCalenderEvents(globalSchedulelist, course, category) {
  $calendar = $("#fullCalendar");
  var eventItems = getCalenderEvents(globalSchedulelist, course, category);

  $calendar.fullCalendar("removeEvents");
  $calendar.fullCalendar("addEventSource", eventItems);
}

function getCalenderEvents(globalSchedulelist, course, category) {
  $calendar = $("#fullCalendar");
  var eventItems = [];
  var termText = ["The first day of ", "The mid cutoff of ", "The last day of "];

  // console.log(globalSchedulelist)

  for (let i = 0; i < globalSchedulelist.termInfo.length; i++) {
    eventItems.push({
      title: termText[0] + globalSchedulelist.termInfo[i].SemesterName,
      start: new Date(globalSchedulelist.termInfo[i].StartDate),
      allDay: true,
      className: eventColors[0],
      editable: false
    });
    eventItems.push({
      title: termText[1] + globalSchedulelist.termInfo[i].SemesterName,
      start: new Date(globalSchedulelist.termInfo[i].MidCutOffDate),
      allDay: true,
      className: eventColors[0],
      editable: false
    });
    eventItems.push({
      title: termText[2] + globalSchedulelist.termInfo[i].SemesterName,
      start: new Date(globalSchedulelist.termInfo[i].EndDate),
      allDay: true,
      className: eventColors[0],
      editable: false
    });
  }

  if (category == "all") {
    for (let i = 0; i < globalSchedulelist.termItem.length; i++) {
      if (globalSchedulelist.termItem[i].SubjectID == course) {
        eventItems.push({
          id: globalSchedulelist.termItem[i].SubjectID + i,
          subjectId: globalSchedulelist.termItem[i].SubjectID,
          categoryId: globalSchedulelist.termItem[i].CategoryID,
          categoryItemId: globalSchedulelist.termItem[i].CategoryItemID,
          title: globalSchedulelist.termItem[i].Title + " (" + globalSchedulelist.termItem[i].SubjectName + ")",
          start: new Date(globalSchedulelist.termItem[i].AssignDate.replace(/-/g, "/")),
          allDay: true,
          className: categoryColor[globalSchedulelist.termItem[i].CategoryID],
          editable: true
        });
      }
    }
  } else {
    for (let i = 0; i < globalSchedulelist.termItem.length; i++) {
      if (globalSchedulelist.termItem[i].SubjectID == course && globalSchedulelist.termItem[i].CategoryID == category) {
        eventItems.push({
          subjectId: globalSchedulelist.termItem[i].SubjectID,
          categoryId: globalSchedulelist.termItem[i].CategoryID,
          categoryItemId: globalSchedulelist.termItem[i].CategoryItemID,
          title: globalSchedulelist.termItem[i].Title + " (" + globalSchedulelist.termItem[i].SubjectName + ")",
          start: new Date(globalSchedulelist.termItem[i].AssignDate.replace(/-/g, "/")),
          allDay: true,
          className: categoryColor[globalSchedulelist.termItem[i].CategoryID],
          editable: true
        });
      }
    }
  }

  return eventItems;
}

function findEachcourses(courseObj, courseId){
  var courseIdset = [];
  if(courseObj[courseId]['Type'] == 'C'){
    Object.keys(courseObj).forEach(function(key) {
        if(courseObj[key]['CSubjectID'] == courseId){
          courseIdset.push(key);
        }
    });
  } else {
    courseIdset.push(courseId);
  }
  return courseIdset;
}
