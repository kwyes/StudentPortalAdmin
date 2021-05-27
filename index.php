<?php
// error_reporting(E_ALL);
require_once __DIR__.'/settings.php';
global $settings;
// $isAdmin = strpos($_SERVER['SCRIPT_NAME'], 'SPAdmin')!==false || strpos($_SERVER['SCRIPT_NAME'], 'admin')!==false;
// if($isAdmin) {
    require_once __DIR__.'/lib/is-authenticated.php';
    if(!IsAuthenticated()) {
        header("HTTP/1.0 401 Unauthorized");
        echo 'Unauthorized';
        exit();
    } else {

        $roleBogs = $_SESSION['staffRole'];
        // $path = $_SERVER['SERVER_NAME'].$settings['adminPath'];
        $path ="";
        $staffRoleSys = $_SESSION['staffRoleSys'];

        if($staffRoleSys == '30'){
            $url = "boarding";
        } else {
          switch ($roleBogs) {
            case '10':
              $url = "admin";
              break;
            case '99':
              $url = "admin";
              break;
            case '40':
              $url = "admin";
              break;
            case '50':
              $url = "sat-e";
              break;
            case '20':
              $url = "faculty";
              break;
            case '21':
              $url = "counselling";
              break;
            case '30':
              $url = "boarding";
              break;
            case '31':
              $url = "boarding";
              break;
            case '32':
              $url = "boarding";
              break;
            default:
              $url = "";
              break;
          }

        }



        // $url = $url."/?page=dashboard";
        header("location: {$url}");
        exit;
    }
// }
