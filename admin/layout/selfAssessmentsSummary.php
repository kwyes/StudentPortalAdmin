<?php

$staffId = $_POST[0];
$roleBogs = $_POST[1];

if((!$staffId) || ($roleBogs != 10 && $roleBogs != 99) ){
      header("HTTP/1.0 401 Unauthorized");
      echo 'Unauthorized';
      exit();

} else {
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <table id="table-summary" class="table table-bordered">
      <thead>
        <tr>
          <th width="5%">StudentID</th>
          <th width="9%">Name</th>
          <th width="5%">Grade</th>
          <th width="24%">Communcation</th>
          <th width="24%">Thinking</th>
          <th width="24%">Personal</th>
          <th width="3%">CR</th>
          <th width="3%">TR</th>
          <th width="3%">PR</th>
        </tr>
      </thead>
      <tbody>

      </tbody>

    </table>




    <script type="text/javascript">
      $(document).ready(function() {
        getSelfAssessmentsSummary("<?=$_POST[2]?>","<?=$_POST[3]?>")

      });

      function getSelfAssessmentsSummary(grade,term) {
        $.ajax({
          url: "../../ajax_php/a.getSelfAssessments.php",
          type: "POST",
          dataType: "json",
          data: {
            term:term,
          },
          success: function (response) {
            console.log(response);
            if(response.result == 0){
              alert('No Record');
            } else {
              var tr;
              for (var i = 0; i < response.length; i++) {
                if(response[i].GradeGroup == grade || grade == ''){
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
                  tr +=
                    '<tr>' +
                    '<td class="text-center">' +
                    response[i].StudentID +
                    "</td><td>" +
                    fullName +
                    "</td><td class='text-center'>" +
                    response[i].CurrentGrade +
                    "</td><td>" +
                    response[i].CommunicationText.split(':*:').join('<br />') +
                    "</td><td>" +
                    response[i].ThinkingText.split(':*:').join(' ') +
                    "</td><td>" +
                    response[i].PersonalText.split(':*:').join('<br />') +
                    "</td><td class='text-center'>" +
                    response[i].CommunicationRate +
                    "</td><td class='text-center'>" +
                    response[i].ThinkingRate +
                    "</td><td class='text-center'>" +
                    response[i].PersonalRate +
                    "</td></tr>";
                }

              }

              $('#table-summary tbody').html(tr);

            }

          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log("ajax error : " + textStatus + "\n" + errorThrown);
          },
        });
      }

    </script>
  </body>
</html>
<?php
}
 ?>
