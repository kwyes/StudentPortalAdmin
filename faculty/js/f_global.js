function generateCourseListDashboard(globalcourselist) {
  var tr = "";
  for (var i = 0; i < globalcourselist.length; i++) {
    var obj = {
      courseId: globalcourselist[i].SubjectID
    };

    tr += "<tr>" + '<td class="text-center">' + globalcourselist[i].SubjectID + "</td>" + "<td>" + globalcourselist[i].SubjectName + "</td>" + '<td class="text-center">' + globalcourselist[i].Num + "</td>" +
    // '<td class="text-center">' +
    // '<a href="#" onclick="redirectToBogs(\'?page=bogs&menu=enter\',\'' +
    // globalcourselist[i].SubjectID +
    // "')\">Enter Grade</a>" +
    // ' | '+
    // '<a href="#" onclick="redirectToBogs(\'?page=bogs&menu=view\',\'' +
    // globalcourselist[i].SubjectID +
    // "')\">View Grade</a>" +
    // ' | ' +
    // '<a href="#" onclick="redirectToBogs(\'?page=bogs&menu=enter\',\'' +
    // globalcourselist[i].SubjectID +
    // "')\">Send Email</a>" +
    // '</td>' +
    "</tr>";
  }
  $("#dashboard-courses tbody").html(tr);
}

function redirectToBogs(url, data, data2 = "") {
  var form = document.createElement("form");
  form.method = "POST";
  form.action = url;
  form.style.display = "none";

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "courseId";
  input.value = data;
  form.appendChild(input);

  var input2 = document.createElement("input");
  input2.type = "hidden";
  input2.name = "categoryId";
  input2.value = data2;
  form.appendChild(input2);

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

function changeBtnClass(target, remove, add){
  $(target).removeClass(remove);
  $(target).addClass(add);
}
