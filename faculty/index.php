<?php

session_start();
require_once '../settings.php';
global $settings;
$isAdmin = strpos($_SERVER['SCRIPT_NAME'], 'SPAdmin')!==false || strpos($_SERVER['SCRIPT_NAME'], 'admin')!==false;
if($isAdmin) {
    require_once '../lib/is-authenticated.php';
    if(!IsAuthenticated()) {
        header("HTTP/1.0 401 Unauthorized");
        echo 'Unauthorized';
        exit();
    }
}
$layoutDir = "layout/";
$page = isset($_GET['page']) ? $_GET['page'] : '';
$menu = isset($_GET['menu']) ? $_GET['menu'] : '';
$url = $_SERVER['REQUEST_URI'];

  include_once $layoutDir."header.php";
  include_once $layoutDir."sidebar.php";

	switch($page) {
		default : {
			include_once $layoutDir."main.php";
			break;
		}
    case "profile" : {
			include_once $layoutDir."profile.html";
			break;
		}
		case "dashboard" : {
			include_once $layoutDir."main.php";
			break;
		}
    case "activities" : {
			include_once $layoutDir."activities.php";
			break;
		}
		case "selfsubmit" : {
			include_once $layoutDir."selfsubmit.php";
			break;
		}
		case "vlwe" : {
			include_once $layoutDir."vlwe.php";
			break;
		}
		case "enrollments" : {
			include_once $layoutDir."enroll.html";
			break;
		}
    case "myhall" : {
      include_once $layoutDir."myhall.php";
      break;
    }
	  case "currentStudent" : {
      include_once $layoutDir."currentStudent.php";
      break;
    }
    case "searchStudent" : {
      include_once $layoutDir."searchStudent.php";
      break;
    }

    case "career" : {
      include_once $layoutDir."careerLife.php";
      break;
    }

    case "reports" : {
      switch($menu) {
        default: {
          include_once $layoutDir."reports.php";
          break;
        }
				case "VLWEReport" : {
						include_once $layoutDir.'vlwereports.php';
					break;
				}
        break;
      }
    }

    case "weeklyAssignment" : {
      include_once $layoutDir."g8g9WeeklyAssignment.php";
      break;
    }

  case "bogs" : {
    include_once $layoutDir.'bogsCustomHeader.php';
    switch($menu) {
      // default: {
      //   include_once $layoutDir."bogsDashboard.php";
      //   break;
      // }
      // case "dashboard" : {
      //   include_once $layoutDir.'bogsDashboard.php';
      //   break;
      // }
      // case "calendar" : {
      //   include_once $layoutDir.'bogsCalendar.php';
      //   break;
      // }
      case "enter" : {
        include_once $layoutDir.'bogsEnterGrade.php';
        break;
      }
      case "view" : {
        include_once $layoutDir.'bogsViewGrade.php';
        break;
      }
      case "weeklyAssignment" : {
        include_once $layoutDir.'bogsWeeklyAssignment.php';
        break;
      }
      case "settings" : {
        include_once $layoutDir.'bogsSettings.php';
        break;
      }
      case "semester" : {
        include_once $layoutDir.'bogsSemester.php';
        break;
      }
      // case "overview" : {
      //   include_once $layoutDir.'bogsOverview.php';
      //   break;
      // }
      // case "overall" : {
      //   include_once $layoutDir.'bogsOverallAverage.php';
      //   break;
      // }
      // case "sendemail" : {
      //   include_once $layoutDir.'bogsSendEmail.php';
      //   break;
      // }
    break;
  }
}

}
	include_once $layoutDir."footer.php";
?>
