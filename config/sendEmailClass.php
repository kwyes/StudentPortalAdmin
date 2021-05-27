<?php
// require_once 'settings.php';
require_once '../lib/PHPMailer-5.2.22/PHPMailerAutoload.php';

function sendEmail($from, $to, $cc, $subject, $body, $altBody = '') {
    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->SMTPDebug = 0;
    $mail->Host = 'bodwell-edu.mail.protection.outlook.com';
    $mail->Port = '25';
    $mail->SMTPSecure = 'TLS';
    $mail->SMTPAuth = false;
    $mail->Username = '';
    $mail->Password = '';

    // $mail->SMTPDebug = 0;
    // $mail->Host = 'smtp.van.terago.ca';
    // $mail->Port = '25';
    // $mail->SMTPSecure = '';
    // $mail->SMTPAuth = false;
    // $mail->Username = '';
    // $mail->Password = '';

    $mail->setFrom($from['email'], $from['name']);
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    foreach($to as $row) {
        $email = $row['email'];
        $name = $row['name'];
        $mail->addAddress($email, $name);
    }
    //$mail->addCC($from['email'], $from['name']);
    if($cc) {
        foreach($cc as $row) {
            $email = $row['email'];
            $name = $row['fullName'];
            $mail->addBCC($email, $name);
        }
    }
    // $mail->addBCC('kwyes2@hotmail.com', 'Chanho Lee');
    // $mail->addBCC('kwyes2@hotmail.com', 'Chanho Lee');
    // $mail->addBCC('kwyes2@hotmail.com', 'Chanho Lee');
    // $mail->addBCC('chano.bodwell@gmail.com', 'Chanho Lee');
    $mail->Subject = $subject;
    $mail->msgHTML($body);
    $mail->AltBody = $altBody;
    if(!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }
}

function getStatusName($num){
  if($num == 10) {
    $numTxt = 'Pending Registration';
  } elseif ($num == 20) {
    $numTxt = 'Registered';
  } elseif ($num == 60) {
    $numTxt = 'Pending Approval';
  } elseif ($num == 70) {
    $numTxt = 'In Progress';
  } elseif ($num == 80) {
    $numTxt = 'Hours Approved';
  } elseif ($num == 90) {
    $numTxt = 'Rejected';
  } else {
    $numTxt = 'Error';
  }
  return $numTxt;
}

function makeBody($student, $title, $location, $sDate, $eDate, $hours, $preStatus, $status, $StaffFullName, $comment){
  $preStatusTxt = getStatusName($preStatus);
  $statusTxt = getStatusName($status);
  $body = <<<BODY
  <style media="screen">
    .table-mail{
      border-collapse: collapse;
      border:none;
      width:900px;
    }
    th, td {
      border-bottom: 1px solid #d2d2d2;
    }
    .table-mail tr td {
      padding:10px;
      font-size:14px;
    }
    .title{
      color:#30297E;
    }
    .tableTitle{
      font-weight: bold;
      color: #66615b;
      width: 300px;
    }



  </style>
  <div>
    <h3 class="title">
      Student Portal System Notification<br />
    </h3>
    <br />
      Please note the latest status update of your self-submitted hours.<br />
      <br />
      <br />
      <table class="table-mail" >
        <tr >
          <td class="tableTitle">Student Name</td>
          <td colspan="3" >{$student}</td>
        </tr>
        <tr>
          <td class="tableTitle">Activity Name</td>
          <td colspan="3" >{$title}</td>
        </tr>
        <tr>
          <td class="tableTitle">Location</td>
          <td colspan="3" >{$location}</td>
        </tr>
        <tr>
          <td class="tableTitle">Date & Hours</td>
          <td >{$sDate}</td>
          <td >{$eDate}</td>
          <td >{$hours}</td>
        </tr>
        <tr>
          <td class="tableTitle">Approval Status</td>
          <td colspan="3" >{$preStatusTxt} -> <span style="color:#F44336">{$statusTxt}</span></td>
        </tr>
        <tr>
          <td class="tableTitle">Approver</td>
          <td colspan="3" >{$StaffFullName}</td>
        </tr>
        <tr style="border-bottom: none;">
          <td style="border-bottom: none;" class="tableTitle">Approver Staff<br />Comment</td>
          <td style="border-bottom: none;" colspan="3" >{$comment}</td>
        </tr>
      </table>
  </div>
BODY;

return $body;

}

function makeBodyCareer($SubjectName, $studentName, $topic, $mentorName, $staffName, $preStatus, $status, $tComment){
  $preStatusTxt = getStatusName($preStatus);
  $statusTxt = getStatusName($status);
  $body = <<<BODY
  <style media="screen">
    .table-mail{
      border-collapse: collapse;
      border:none;
      width:900px;
    }
    th, td {
      border-bottom: 1px solid #d2d2d2;
    }
    .table-mail tr td {
      padding:10px;
      font-size:14px;
    }
    .title{
      color:#30297E;
    }
    .tableTitle{
      font-weight: bold;
      color: #66615b;
      width: 300px;
    }



  </style>
  <div>
    <h3 class="title">
      Student Portal System Notification<br />
    </h3>
    <br />
      <br />
      <table class="table-mail" >
        <tr >
          <td class="tableTitle">Course</td>
          <td colspan="3" >{$SubjectName}</td>
        </tr>
        <tr>
          <td class="tableTitle">Student</td>
          <td colspan="3" >{$studentName}</td>
        </tr>
        <tr>
          <td class="tableTitle">Project Topic</td>
          <td colspan="3" >{$topic}</td>
        </tr>
        <tr>
          <td class="tableTitle">Guide</td>
          <td colspan="3" >{$mentorName}</td>
        </tr>
        <tr>
          <td class="tableTitle">Teacher</td>
          <td colspan="3" >{$staffName}</td>
        </tr>
        <tr>
          <td class="tableTitle">Approval Status</td>
          <td colspan="3" >{$preStatusTxt} -> <span style="color:#F44336">{$statusTxt}</span></td>
        </tr>
        <tr style="border-bottom: none;">
          <td style="border-bottom: none;" class="tableTitle">Approver Comment</td>
          <td style="border-bottom: none;" colspan="3" >{$tComment}</td>
        </tr>
      </table>
  </div>
BODY;

return $body;

}
