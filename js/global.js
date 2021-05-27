var activityCategory = [
  "Select..",
  "Physical, Outdoor & Recreation Education",
  "Academic, Interest & Skill Development",
  "Citizenship, Interaction & Leadership Experience",
  "Arts, Culture & Local Exploration",
];
var activityCategoryVal = ["", 10, 11, 12, 13];
var activityStatus = ["Pending Approval", "Hours Approved", "Rejected"];
var activityStatusVal = [60, 80, 90];

var capstoneCategory = [{
    val: "",
    text: "Select..",
  },
  {
    val: "Agriculture, Food and Natural Resources",
    text: "Agriculture, Food and Natural Resources",
  },
  {
    val: "Architecture and Construction",
    text: "Architecture and Construction",
  },
  {
    val: "Arts, Audio/Video Technology and Communications",
    text: "Arts, Audio/Video Technology and Communications",
  },
  {
    val: "Business, Management and Administration",
    text: "Business, Management and Administration",
  },
  {
    val: "Education and Training",
    text: "Education and Training",
  },
  {
    val: "Finance",
    text: "Finance",
  },
  {
    val: "Government and Public Administration",
    text: "Government and Public Administration",
  },
  {
    val: "Health Science",
    text: "Health Science",
  },
  {
    val: "Hospitality and Tourism",
    text: "Hospitality and Tourism",
  },
  {
    val: "Human Services",
    text: "Human Services",
  },
  {
    val: "Information Technology",
    text: "Information Technology",
  },
  {
    val: "Law, Public Safety, Corrections and Security",
    text: "Law, Public Safety, Corrections and Security",
  },
  {
    val: "Manufacturing",
    text: "Manufacturing",
  },
  {
    val: "Marketing, Sales and Service",
    text: "Marketing, Sales and Service",
  },
  {
    val: "Science, Technology, Engineering and Mathematics",
    text: "Science, Technology, Engineering and Mathematics",
  },
  {
    val: "Transportation, Distribution and Logistics",
    text: "Transportation, Distribution and Logistics",
  },
  {
    val: "Other (Specify below)",
    text: "Other (Specify below)",
  },
];

var careerSubjectList;
var careerObj;
var defaultForm;
var updateForm;

$(document).ready(function () {
  $(".filter-reset-btn").click(function () {
    location.reload();
  });
  $("#addSubmitMdl-apprStaff, #sSubmitMdl-apprStaff, #leaveRequestMdl-apprStaff").change(function (event) {
    getStaffPic(this.value, event.target.id);
  });
  generateTermList(".select-term", globalSemesterList);
  generateTermListForCareer("#career-term-select", globalSemesterList, 72);

  $("#career-guide-phone").keyup(function (e) {
    var regex1 = RegExp("[0-9]");
    var regex2 = RegExp("[a-zA-Z]{2}");
    if (regex1.test(e.key) || regex2.test(e.key)) {
      $(this).val(
        $(this)
        .val()
        .replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, "$1-$2-$3")
        .slice(0, 12)
      );
    } else {
      var len = $(this).val().length;
      $(this).val(
        $(this)
        .val()
        .slice(0, len - 1)
      );
    }
  });

  $("input").prop("autocomplete", "off");
});

$(document).on("click", ".redirect-admin-studentid", function () {
  ``;
  redirectAdminSystem($(this).text());
});

$(document).on("mouseover", ".hoverShowPic", function (event) {
  $(".studentImageFrame").css("display", "block");
  var target = $(event.target);
  // var id = target.attr("data-id");
  var id = $(this).data("id");
  var src = "https://asset.bodwell.edu/OB4mpVpg/student/bhs" + id + ".jpg";
  var offset_top = 0;
  var offset_left = 0;

  if (target.hasClass("selfSubmitPic")) {
    offset_left = 400;
  } else if (target.hasClass("report-redirect-a")) {
    offset_top = 150;
    offset_left = 200;
  } else if (target.hasClass("careerLifePic")) {
    offset_left = 450;
  } else if (target.hasClass("enterGradePic")) {
    offset_left = 500;
  } else if (target.hasClass("overallPic")) {
    offset_left = 450;
  } else if (target.hasClass("overViewPic")) {
    offset_left = 420;
  } else if (target.hasClass("viewGradePic")) {
    offset_left = 400;
  } else if (target.hasClass("searchStudentTr")) {
    offset_left = 100;
  } else {
    offset_left = 315;
  }

  $(".studentImage").attr("src", src);
  $(".frameStuName").html($(this).html());
  $(".frameStuId").html(id);
  $(".studentImageFrame").css("top", $(this).offset().top - offset_top);
  $(".studentImageFrame").css("left", $(this).offset().left + offset_left);
});

$(document).on("mouseout", ".hoverShowPic", function (event) {
  $(".studentImageFrame").css("display", "none");
});

function getStaffPic(staffId, select) {
  var imgsrc = "https://asset.bodwell.edu/OB4mpVpg/staff/" + staffId + ".jpg";
  // alert(imgsrc);
  var id = "";
  if (select == "addSubmitMdl-apprStaff") {
    id = "#addSubmitMdl-approverPic";
  } else if (select == "sSubmitMdl-apprStaff") {
    id = "#sSubmitMdl-approverPic";
  } else if (select == "leaveRequestMdl-apprStaff") {
    id = "#leaveRequestMdl-approverPic";
  }
  $(id).attr("src", imgsrc);
}

function makeProgress(i) {
  // alert(i);
  var j = 100 - i;
  if (j < 100) {
    j = j + 1;
    $(".progress-bar")
      .css("width", j + "%")
      .text(j + " %");
  }
  // Wait for sometime before running this script again
  setTimeout("makeProgress()", 100);
}

$(document).on("click", ".btn-report-reset", function () {
  refreshVLWEReportList(globalSemesterList);
});

$(document).on("click", ".btn-search-reset", function () {
  refreshSearchStudentList(globalSemesterList);
});

function refreshSearchStudentList(globalSemesterList) {
  var id = $(".searchstudent-session-sid").val();
  studentSearchAllActivityList(id, globalSemesterList);
}

function refreshVLWEReportList(globalSemesterList) {
  var id = $(".report-session-sid").val();
  generateVLWEReport(id, globalSemesterList);
}

function formatDecimal(num) {
  if (num < 1) {
    return "0" + num.toString();
  }
  return num;
}

function pagerNumResize() {
  var width = $(window).width();
  if (width < 577) {
    $.fn.DataTable.ext.pager.numbers_length = 4;
  }
}

function selectAllCheckbox(table_id) {
  $(document).on("click", table_id + " .selectAll", function (event) {
    var target = event.target;
    var checkbox = table_id + ' input[type="checkbox"]:visible';

    if ($(this).hasClass("allChecked")) {
      $(checkbox).prop("checked", false);
    } else {
      $(checkbox).prop("checked", true);
    }
    $(target).toggleClass("allChecked");
  });
}

function GetCategoryIcon(categoryname) {
  var categoryIcon;
  if (categoryname == "10") {
    categoryIcon = '<i class="material-icons-outlined">directions_bike</i>';
  } else if (categoryname == "11") {
    categoryIcon = '<i class="material-icons-outlined">school</i>';
  } else if (categoryname == "12") {
    categoryIcon = '<i class="material-icons-outlined">language</i>';
  } else if (categoryname == "13") {
    categoryIcon = '<i class="material-icons-outlined">palette</i>';
  } else if (categoryname == "21") {
    categoryIcon = '<i class="material-icons-outlined">all_inclusive</i>';
  } else {
    categoryIcon = "err";
  }
  return categoryIcon;
}

function GetStatusIcon(statusid) {
  var statusIcon;
  if (statusid == 10) {
    statusIcon = '<i class="fas fa-pen-alt"></i>';
  } else if (statusid == 20) {
    // joined
    statusIcon = '<i class="material-icons-outlined">date_range</i>';
  } else if (statusid == 60) {
    // pending approval
    statusIcon = '<i class="material-icons-outlined">hourglass_empty</i>';
  } else if (statusid == 70) {
    // in progress
    statusIcon = '<i class="material-icons-outlined">play_arrow</i>';
  } else if (statusid == 80) {
    // hours approval
    statusIcon = '<i class="material-icons-outlined">done_outline</i>';
  } else if (statusid == 90) {
    // cancelled
    statusIcon = '<i class="material-icons-outlined">link_off</i>';
  } else {
    statusIcon = "err";
  }
  return statusIcon;
}

function GetStatusIconV2(statusid) {
  var statusIcon;
   if (statusid == 'P') {
    // pending approval
    statusIcon = '<i class="material-icons-outlined">hourglass_empty</i>';
  } else if (statusid == 'A') {
    // hours approval
    statusIcon = '<i class="material-icons-outlined">done_outline</i>';
  } else if (statusid == 'R') {
    // cancelled
    statusIcon = '<i class="material-icons-outlined">link_off</i>';
  } else {
    statusIcon = 'err';
  }
  return statusIcon;
}

function dateCompare(id) {
  var startDate = $(id + "-from").val();
  var endDate = $(id + "-to").val();
  if (Date.parse(startDate) > Date.parse(endDate)) {
    showSwal("error", "End date should be greater than Start date");
    return false;
  } else {
    return true;
  }
}

function GetStatusIconWithText(statusid) {
  var statusIcon;
  if (statusid == 10) {
    statusIcon =
      '<span class="modal-status-icon"><i class="fas fa-pen-alt"></i> : Pending Registration</span>';
  } else if (statusid == 20) {
    // joined
    statusIcon =
      '<span class="modal-status-icon"><i class="material-icons-outlined">date_range</i> : Registered</span>';
  } else if (statusid == 60) {
    // pending approval
    statusIcon =
      '<span class="modal-status-icon"><i class="material-icons-outlined">hourglass_empty</i> : Pending Approval</span>';
  } else if (statusid == 80) {
    // hours approval
    statusIcon =
      '<span class="modal-status-icon"><i class="material-icons-outlined">done_outline</i> : Hours Approved</span>';
  } else if (statusid == 90) {
    // cancelled
    statusIcon =
      '<span class="modal-status-icon"><i class="material-icons-outlined">link_off</i> : Rejected</span>';
  } else {
    statusIcon = "err";
  }
  return statusIcon;
}

function GetVlweIcon(statusid) {
  var statusIcon;
  if (statusid == 1) {
    statusIcon =
      '<i class="material-icons-outlined text-default">check_box</i>';
  } else if (statusid == 0) {
    statusIcon = "";
  } else {
    statusIcon = "err";
  }
  return statusIcon;
}

function dateTimePicker() {
  if ($(".datetimepicker").length != 0) {
    $(".datetimepicker")
      .datetimepicker({
        useCurrent:true,
        ignoreReadonly: true,
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: "fa fa-chevron-left",
          next: "fa fa-chevron-right",
          today: "fa fa-screenshot",
          clear: "fa fa-trash",
          close: "fa fa-remove",
        },
      })
      .on("dp.change", function () {});
    $(".datetimepicker").attr("readonly", "readonly");
  }

  if ($(".datepicker").length != 0) {
    $(".datepicker")
      .datetimepicker({
        // debug: true,
        // readonly: true,
        ignoreReadonly: true,
        icons: {
          // time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: "fa fa-chevron-left",
          next: "fa fa-chevron-right",
          today: "fa fa-screenshot",
          clear: "fa fa-trash",
          close: "fa fa-remove",
        },
      })
      .on("dp.change", function (event) {
        var target = $(event.target);
        var id = "#" + target.attr("data-id");

        if (dateCompare(id) == true) {
          if (id == "#act-date") {
            $("#activity-cateSelect").html("");
            show_school_activities();
          } else if (id == "#self-date") {
            get_selfsubmit_rows();
          } else if (id == "#vlwe-date") {
            get_vlwe_rows();
          } else if (id == "#leave-date") {
            getStudentLeaveRequest();
          }
        }
      });
    $(".datepicker").attr("readonly", "readonly");
  }
}

function redirectAdminSystem(studentId) {
  var url =
    "https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=" + studentId;
  window.open(url);
}

function generateSelector(select, arr, arr2, def_val, disable) {
  var options = "";

  for (let i = 0; i < arr.length; i++) {
    options += '<option value="' + arr2[i] + '">' + arr[i] + "</option>";
  }
  $(select).html(options);
  if (def_val != "none") {
    $(select).val(def_val).prop("selected", true);
  } else {
    $(select).val("").prop("selected", true);
  }

  $(select).prop("disabled", disable);
}

function generateSelector_v2(select, arr, def_val, disable) {
  var options = "";

  for (let i = 0; i < arr.length; i++) {
    options +=
      '<option value="' + arr[i].val + '">' + arr[i].text + "</option>";
  }
  $(select).html(options);
  if (def_val != "none") {
    $(select).val(def_val).prop("selected", true);
  } else {
    $(select).val("").prop("selected", true);
  }

  $(select).prop("disabled", disable);
}

function showSwal(type, title) {
  if (type == "error") {
    swal({
      title: title,
      buttonsStyling: false,
      confirmButtonClass: "btn btn-info",
    }).catch(swal.noop);
  } else if (type == "success") {
    swal({
        title: "Success!",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
        type: "success",
      })
      .then(function () {
        location.reload();
      })
      .catch(swal.noop);
  }
}

function showSwal2(type, title, modalId) {
  if (type == "error") {
    swal({
      title: title,
      buttonsStyling: false,
      confirmButtonClass: "btn btn-info",
    }).catch(swal.noop);
  } else if (type == "success") {
    swal({
        title: "Success!",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
        type: "success",
      })
      .then(function () {
        $(modalId).modal("hide");
      })
      .catch(swal.noop);
  }
}

function showSwalBogs(type, title) {
  if (type == "error") {
    swal({
        title: title,
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
      })
      .then(function () {
        location.replace("?page=bogs&menu=settings");
      })
      .catch(swal.noop);
  } else if (type == "success") {
    swal({
        title: "Success!",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
        type: "success",
      })
      .then(function () {
        location.reload();
      })
      .catch(swal.noop);
  }
}

function showSwalBogsSemester(text) {
  swal({
      title: "Success!",
      text: text,
      buttonsStyling: false,
      confirmButtonClass: "btn btn-info",
      type: "success",
      allowOutsideClick: false,
    })
    .then(function () {
      location.href = "?page=bogs&menu=weeklyAssignment";
    })
    .catch(swal.noop);
}

function createReportTable(id, fullName, CurrentStatus, globalSemesterList) {
  $(".report-session-sid").val(id);
  generateVLWEReport(id, globalSemesterList);
  var source = $(".report-session-source").val();
  if (source == "admin") {
    atag =
      '<a data-id="' +
      id +
      '" class="report-redirect-a hoverShowPic" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
      id +
      '" target="_blank">';
  } else {
    atag =
      '<a data-id="' +
      id +
      '" class="report-redirect-a hoverShowPic" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      id +
      '" target="_blank">';
  }
  $("#report-stuName").html(atag + fullName + "</a>");
  $("#report-stuStatus").html(CurrentStatus);
  if (CurrentStatus == "Current") {
    $("#report-stuStatus").css("color", "#00BCD4");
  } else {
    $("#report-stuStatus").css("color", "");
  }
}

function createSearchStudentTable(
  id,
  fullName,
  CurrentStatus,
  globalSemesterList
) {
  $(".searchstudent-session-sid").val(id);
  studentSearchAllActivityList(id, globalSemesterList);
  var source = $(".searchstudent-session-source").val();
  if (source == "admin") {
    atag =
      '<a data-id="' +
      id +
      '" class="report-redirect-a hoverShowPic" href="https://admin.bodwell.edu/bhs/updatestudent1.cfm?studentid=' +
      id +
      '" target="_blank">';
  } else {
    atag =
      '<a data-id="' +
      id +
      '" class="report-redirect-a hoverShowPic" href="https://staff.bodwell.edu/updatestudent1.cfm?studentid=' +
      id +
      '" target="_blank">';
  }
  $("#searchStu-stuName").html(atag + fullName + "</a>");
  $("#searchStu-stuStatus").html(CurrentStatus);
  if (CurrentStatus == "Current") {
    $("#searchStu-stuStatus").css("color", "#00BCD4");
  } else {
    $("#searchStu-stuStatus").css("color", "");
  }
}

function getAllValInForm(formId) {
  return $("#" + formId).serializeArray();
}

function checkSomethingChanged(defVal, updtVal) {
  var isChanged = false;

  if (defVal.length == updtVal.length) {
    let len = defVal.length;
    for (let i = 0; i < len; i++) {
      if (defVal[i].name == updtVal[i].name) {
        if (defVal[i].value != updtVal[i].value) {
          isChanged = true;
        }
      }
    }
  } else {
    alert("Contact IT");
  }

  return isChanged;
}

function getFirstCharacter(str) {
  str = str.trim();
  var res = str.split(" ");
  const array = [...res];
  var txt = "";
  for (var i = 0; i < array.length; i++) {
    if (i == 3) {
      txt += "-" + array[i].charAt(0);
    } else {
      txt += array[i].charAt(0);
    }
  }
  return txt;
}

function getAge(dateString) {
  var today = new Date();
  var birthDate = new Date(dateString);
  var real;
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
    // age = age + (1 + m / 10);
  }

  return age;
}

function getGenderIcon(gender) {
  var icon;
  var src;
  if (gender) {
    if (gender == "F") {
      src = "../img/gender/woman-icon.png";
      icon = "<img src='" + src + "' class='width-24' title='Female'/>";
    } else {
      src = "../img/gender/man-icon.png";
      icon = "<img src='" + src + "' class='width-24' title='Male'/>";
    }
    return icon;
  }
}

function getHouseIcon(house) {
  var icon;
  var txt = house.toLowerCase();
  txt = txt.trim();
  if (house) {
    icon =
      "<img src='../img/house/" +
      txt +
      ".svg' class='width-20' title='" +
      txt +
      "'/>";
  } else {
    icon = "";
  }

  return icon;
}

function getNationalFlag(code, name) {
  var flagsrc = "../img/flag/" + code + ".png";
  var flag =
    '<img src="' +
    flagsrc +
    '" title="' +
    name +
    '" class="width-24 mg-b-3"/><span style="display:none;">' +
    name +
    "</span>";

  return flag;
}

function toggleSpinner() {
  if ($(".mask").is(":hidden")) {
    $(".mask").show();
  } else {
    $(".mask").hide();
  }
}

function createFullName(engname, firstname, lastname) {
  if (engname) {
    engName = " (" + engname + ") ";
  } else {
    engName = " ";
  }
  var fullName = firstname + engName + lastname;
  return fullName;
}

function showNotification(from, align, color, text) {
  // type = ['','info','success','warning','danger','rose','primary'];

  $.notify({
    // icon: "notifications",
    message: text,
  }, {
    type: color,
    timer: 3000,
    placement: {
      from: from,
      align: align,
    },
    z_index: 2000,
  });
}

function chkLocation(res, hom) {
  var subCategoryTxt;
  if (hom == 'Y' && res == 'Y') {
    subCategoryTxt = 'Boarding';
  } else if (hom == 'N' && res == 'N') {
    subCategoryTxt = 'Day Program';
  } else if (hom == 'Y' && res == 'N') {
    subCategoryTxt = 'Homestay';
  } else if (hom == 'N' && res == 'Y') {
    subCategoryTxt = 'Boarding';
  } else {
    subCategoryTxt = 'Error';
  }
  return subCategoryTxt;
}

function getGradeLetter(rate) {
  if (rate >= .86) {
    return 'A'
  } else if (rate >= .73 && rate < .86) {
    return 'B';
  } else if (rate >= .67 && rate < .73) {
    return 'C+';
  } else if (rate >= .60 && rate < .67) {
    return 'C';
  } else if (rate >= .50 && rate < .60) {
    return 'C-';
  } else {
    return 'F';
  }
}

function getWeekDate(date) {
  firstDate = moment(date).startOf('week').format("YYYY-MM-DD");
  lastDate = moment(date).endOf('week').format("YYYY-MM-DD");
  return firstDate + "   -   " + lastDate;
}

function setWeekDatePicker(id) {
  $(id).on('dp.change', function (e) {
    $('.wa-input-text').val('');
    $('.wa-input-select').val('1').change();
    $('.hidden-waId').val('');
    $('.wa-check').prop('checked', false);

    var value = $(id).val();
    var weekDate = getWeekDate(value);
    $(id).val(weekDate);

  });

  $(id).click(function () {
    var value = $(id).val();
    var weekDate = getWeekDate(value);
    $(id).val(weekDate);
  });

  $(id).blur(function () {
    var value = $(id).val();
    var weekDate = getWeekDate(value);
    $(id).val(weekDate);
  });
}

$.extend($.fn.dataTableExt.oSort, {
  "num-html-asc": function (a, b) {
    return a < b ? -1 : a > b ? 1 : 0;
  },

  "num-html-desc": function (a, b) {
    return a < b ? 1 : a > b ? -1 : 0;
  },
});



function displayStudentAssessment10(response){
  $('#AssessmentID').val(response.AssessmentID);
  var str = response.PersonalText;
  var res = str.split(":*:");

  $("[name='communication']").val(response.CommunicationText);
  $("[name='thinking']").val(response.ThinkingText);
  $("[name='personal']").val(res[0]);
  $("[name='personal1']").val(res[1]);

  $("[name='cRate']").val(response.CommunicationRate);
  $("[name='tRate']").val(response.ThinkingRate);
  $("[name='pRate']").val(response.PersonalRate);

}

function displayStudentAssessment8(response) {
  $('#AssessmentID').val(response.AssessmentID);
  var p = response.PersonalText;
  var res_p = p.split(":*:");
  var t = response.ThinkingText;
  var res_t = t.split(":*:");
  var c = response.CommunicationText;
  var res_c = c.split(":*:");
  for(var i = 0; i < res_c.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Communication'+inum;
    $("[name="+cName+"]").val(res_c[i]);
  }

  for(var i = 0; i < res_t.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Thinking'+inum;
    $("[name="+cName+"]").val(res_t[i]);
  }

  for(var i = 0; i < res_p.length; i++){
    var inum = parseInt(i+1);
    var cName = 'Personal'+inum;
    $("[name="+cName+"]").val(res_p[i]);
  }



  $("[name='cRate']").val(response.CommunicationRate);
  $("[name='tRate']").val(response.ThinkingRate);
  $("[name='pRate']").val(response.PersonalRate);

}
