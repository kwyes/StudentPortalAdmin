var globalcourselist;
var globalCategoryList;
var globalCategoryItemsList;
var globalEnterGradeList;
var globalOptionsList;
var globalOptionsListV2;
var globalGradeList;
var globalSchedulelist;
var globalCategoryListV2;

function GetCourseOptionsList(semesterID, teacherId) {
  $.ajax({
    url: "../ajax_bogs/a.getCourseOptionsList.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    success: function (response) {
      globalOptionsList = response;
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseList(
          ".courseList",
          globalOptionsList["SubjectList"],
          false
        );
        var selectedCourse = $(".courseList").val();
        generateCategoryListV2(
          ".categoryList",
          selectedCourse,
          globalOptionsList["CategoryList"],
          false
        );
        var selectedCategory = $(".categoryList").val();
        generateCategoryItemList(
          ".itemList",
          selectedCategory,
          globalOptionsList["categoryItemArray"]
        );
        displayItemInfo(globalOptionsList);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function GetCourseOptionsListV2(semesterID, teacherId) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.getCourseOptionsListV2.php",
    type: "POST",
    dataType: "json",
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    success: function (response) {
      globalOptionsListV2 = response;
      toggleSpinner();
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseList(
          ".courseList",
          globalOptionsListV2["SubjectList"],
          false
        );
        var selectedCourse = $(".courseList").val();
        generateCategoryListV2(
          ".categoryList",
          selectedCourse,
          globalOptionsListV2["CategoryList"],
          true
        );
        var selectedCategory = $(".categoryList").val();
        generateCategoryItemList(
          ".itemList",
          selectedCategory,
          globalOptionsListV2["categoryItemArray"]
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

// For G8/G9 Weekly Assignment
function GetCourseOptionsListV3(semesterID, teacherId) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.getCourseOptionsListV2.php",
    type: "POST",
    dataType: "json",
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    success: function (response) {
      globalOptionsListV2 = response;
      toggleSpinner();
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseList(
          ".courseList",
          globalOptionsListV2["SubjectList"],
          false
        );
        var selectedCourse = $(".courseList option:selected").text();
        $(".course-info").html(selectedCourse);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getMyCourseList(semesterID, teacherId) {
  $.ajax({
    url: "../ajax_bogs/a.getMyCourseList.php",
    type: "POST",
    dataType: "json",
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    async: false,
    success: function (response) {
      globalcourselist = response;
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseList(".courseList", globalcourselist, false);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getMyCourseListV2(semesterID, teacherId) {
  $.ajax({
    url: "../ajax_bogs/a.getMyCourseListV2.php",
    type: "POST",
    dataType: "json",
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    async: false,
    success: function (response) {
      globalcourselistV2 = response;
      if (response.result == 0) {
        console.log("IT");
      } else {
        generateCourseListV2(".courseList", globalcourselistV2, false);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getCategory(courseId) {
  $.ajax({
    url: "../ajax_bogs/a.getCategoriesByCourseID.php",
    type: "POST",
    dataType: "json",
    data: {
      courseId: courseId,
    },
    async: false,
    success: function (response) {
      var firstcategorySelect = '<option value="">Select Category..</option>';
      if (response.result == 0) {
        console.log("IT");
        $("#datatables-bogs-category tbody").html("");
        $("#bogsCategoryItemMdl-category").html(firstcategorySelect);
      } else {
        globalCategoryList = response;
        var categorySelect = "";
        for (let i = 0; i < globalCategoryList.length; i++) {
          categorySelect +=
            '<option value="' +
            globalCategoryList[i].CategoryID +
            '">' +
            globalCategoryList[i].Text +
            "</option>";
        }
        $("#bogsCategoryItemMdl-category").html(
          firstcategorySelect + categorySelect
        );
        $(".categoryList").html(categorySelect);
        generateCategoryList(
          "#datatables-bogs-category tbody",
          globalCategoryList
        );
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getCategoryV2(courseId) {
  $.ajax({
    url: "../ajax_bogs/a.getCategoriesByCourseID.php",
    type: "POST",
    dataType: "json",
    data: {
      courseId: courseId,
    },
    async: false,
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        globalCategoryListV2 = response;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getCategoryItems(courseId) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.getCategoryItemsByCourseID.php",
    type: "POST",
    dataType: "json",
    data: {
      courseId: courseId,
    },
    success: function (response) {
      toggleSpinner();
      if (response.result == 0) {
        console.log("IT");
        $("#datatables-bogs-categoryItem tbody").html("");
      } else {
        globalCategoryItemsList = response;
        generateCategoryItemsTable(response);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function AddBogsCategory(formArr) {
  $.ajax({
    url: "../ajax_bogs/a.addBogsCategory.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        showSwal2("success", null, "#bogsCategoryModal");
        $("#bogsCategoryModal").modal();
        var selectedCourse = $(".courseList").val();
        getCategory(selectedCourse);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function AddBogsCategoryItems(formArr) {
  $.ajax({
    url: "../ajax_bogs/a.addBogsCategoryItems.php",
    type: "POST",
    dataType: "json",
    data: formArr,
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        var term = $(".termList").val();
        var course = $(".courseList").val();
        showSwalBogs("success", "", "?page=bogs&menu=settings", course);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function saveCategory(itemsArr) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.updateBogsCategory.php",
    type: "POST",
    dataType: "json",
    data: {
      data: itemsArr,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        toggleSpinner();
        var term = $(".termList").val();
        var course = $(".courseList").val();
        showSwalBogs("success", "", "?page=bogs&menu=settings", course);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function deleteCategory(itemsArr) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.deleteBogsCategory.php",
    type: "POST",
    dataType: "json",
    data: {
      data: itemsArr,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        toggleSpinner();
        var term = $(".termList").val();
        var course = $(".courseList").val();
        showSwalBogs("success", "", "?page=bogs&menu=settings", course);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function saveCategoryItems(itemsArr) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.UpdateBogsCategoryItems.php",
    type: "POST",
    dataType: "json",
    data: {
      data: itemsArr,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        toggleSpinner();
        var term = $(".termList").val();
        var course = $(".courseList").val();
        showSwalBogs("success", "", "?page=bogs&menu=settings", course);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function deleteCategoryItems(itemsArr) {
  toggleSpinner();
  $.ajax({
    url: "../ajax_bogs/a.deleteBogsCategoryItems.php",
    type: "POST",
    dataType: "json",
    data: {
      data: itemsArr,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        toggleSpinner();
        var term = $(".termList").val();
        var course = $(".courseList").val();
        showSwalBogs("success", "", "?page=bogs&menu=settings", course);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getEnterGradeRecord() {
  toggleSpinner();
  var term = $(".termList").val();
  var course = $(".courseList").val();
  var category = $(".categoryList").val();
  var item = $(".itemList").val();
  var object = {
    term: term,
    course: course,
    category: category,
    item: item,
  };
  $.ajax({
    url: "../ajax_bogs/a.getEnterGradeRecord.php",
    type: "POST",
    dataType: "json",
    data: object,
    success: function (response) {
      if (response.result == 0) {
        // showSwalBogs("error", "Something went wrong!");
      } else {
        globalEnterGradeList = response;
        generateEnterGradeTable(globalEnterGradeList, object);
      }
      toggleSpinner();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function saveEnterGradeRecord(object) {
  var term = $(".termList").val();
  var course = $(".courseList").val();
  var category = $(".categoryList").val();
  var item = $(".itemList").val();
  var subjobject = {
    term: term,
    course: course,
    category: category,
    item: item,
  };
  $.ajax({
    url: "../ajax_bogs/a.saveEnterGradeRecord.php",
    type: "POST",
    dataType: "json",
    data: {
      data: object,
      subjobject: subjobject,
    },
    success: function (response) {
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        getEnterGradeRecord();
        var msg = object.length + " data have been updated.";
        showNotification("top", "center", "success", msg);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getOverViewGrade(object, show) {
  toggleSpinner();
  var courseId = $(".courseList").val();

  var send = {
    termInfo: object["termInfo"],
    categoryMap: object["categoryMap"][courseId],
    studentMap: object["studentMap"][courseId],
    categoryItemMap: object["categoryItemMap"],
    termItemArray: object["termItem"],
    categoryArrayBySubjectID: object["categoryArrayBySubjectID"][courseId],
  };
  $.ajax({
    url: "../ajax_bogs/a.getOverViewGrade.php",
    type: "POST",
    dataType: "json",
    cache: false,
    async: false,
    data: {
      data: JSON.stringify(send),
      courseId: courseId,
    },
    success: function (response) {
      toggleSpinner();
      globalGradeList = response;
      console.log(response);
      if (show) {
        var selectedCourse = $(".courseList").val();
        var selectedCategory = $(".categoryList").val();
        if (selectedCategory == "all") {
          generateOverViewTableHeader(response, selectedCourse);
          generateOverViewTableRows(response, selectedCourse);
        } else {
          generateViewTableHeader(globalGradeList, selectedCategory);
          generateViewTableRows(
            globalGradeList,
            selectedCourse,
            selectedCategory
          );
        }

        displayItemInfoView(globalOptionsListV2);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function GetCourseSchedule(semesterID, teacherId) {
  $.ajax({
    url: "../ajax_bogs/a.getCourseSchedule.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      semesterID: semesterID,
      teacherId: teacherId,
    },
    success: function (response) {
      globalSchedulelist = response;
      if (response.result == 0) {
        console.log("IT");
      } else {}
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function registerSession(val, text, chk) {
  $.ajax({
    url: "../ajax_bogs/a.registerSession.php",
    type: "POST",
    dataType: "json",
    data: {
      input: val,
      text: text,
    },
    success: function (response) {
      if (text == "bogsSemesterText") {
        showSwalBogsSemester(val + " was selected.");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function updateCourseCalendarEvent(dataObj) {
  $.ajax({
    url: "../ajax_bogs/a.updateCourseCalendarEvent.php",
    type: "POST",
    dataType: "json",
    data: dataObj,
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        // showSwalBogs("error", "Something went wrong!");
        console.log("Something went wrong!");
      } else {
        var msg = "Calendar has been updated!";
        showNotification("top", "center", "success", msg);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function getWeeklyAssignment() {
  var course = $('.courseList').val();
  var term = $('.termList').val();
  var combineddate = $("#weeklyDatePicker2").val();
  var dateArr = combineddate.split("   -   ");
  var courseSet = findEachcourses(globalcourselistV2, course);
  console.log(courseSet);

  $.ajax({
    url: "../ajax_bogs/a.getWeeklyAssignment.php",
    type: "POST",
    dataType: "json",
    data: {
      SemesterID: term,
      SubjectID: courseSet,
      from: dateArr[0],
      to: dateArr[1]
    },
    success: function (response) {
      if (response.result == 0) {
        // showSwalBogs("error", "Something went wrong!");
        console.log("no DATA");
      } else {
        $('.wa-check').prop('checked', false)
        Object.keys(response).forEach(key => {
          Object.keys(response[key]).forEach(seqkey => {
            $('.wa' + key + '-' + response[key][seqkey].SubjectID + '-' + seqkey).val(response[key][seqkey].Title);
            $('.select' + key + '-' + response[key][seqkey].SubjectID + '-' + seqkey).val(response[key][seqkey].Status);
            $('.waId' + key + '-' + response[key][seqkey].SubjectID + '-' + seqkey).val(response[key][seqkey].waID);
          });
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}

function saveWeeklyAssignment(arr) {
  var combineddate = $("#weeklyDatePicker2").val();
  var dateArr = combineddate.split("   -   ");
  $.ajax({
    url: "../ajax_bogs/a.saveWeeklyAssignment.php",
    type: "POST",
    dataType: "json",
    data: {
      arr: arr,
      date: dateArr[0],
    },
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        showSwalBogs("error", "Something went wrong!");
      } else {
        showNotification("top", "center", "success", "Weekly Assignment has been updated!");
        getWeeklyAssignment();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    },
  });
}
