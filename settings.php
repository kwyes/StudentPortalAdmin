<?php
const VERSION = '1.2.0';
const CVERSION = '1.1.9';
const SVERSION = '1.2.1';
const BVERSION = '1.2.0';
const GCVERSION = '1.1.7';
const GSVERSION = '1.1.8';
const SEVERSION = '1.1.6';

function getCommonSettings() {

    $version = VERSION;
    $cversion = CVERSION;
    $sversion = SVERSION;
    $bversion = BVERSION;
    $gcversion = GCVERSION;
    $gsversion = GSVERSION;
    $seversion = SEVERSION;

    return array(
        'version' => VERSION,
        'cversion' => CVERSION,
        'sversion' => SVERSION,
        'bversion' => BVERSION,
        'gcversion' => GCVERSION,
        'gsversion' => GSVERSION,
        'seversion' => SEVERSION,
        'title' => "Bodwell Student Portal Admin (v{$version})",
        'hostName' => $_SERVER['SERVER_NAME'],
        'hostAddr' => $_SERVER['SERVER_ADDR'],
    );

}

function getEnvironmentSettings() {

    $version = VERSION;
    $hostName = $_SERVER['SERVER_NAME'];
    $scriptFileName = "student-portal-web-{$version}.js";
    $adminScriptName = "student-portal-admin-{$version}.js";
    $returnUrl = "";
    $backdoor = array(
        '45c0x:2|ch//',
    );

    switch($hostName) {
        case 'admin.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => false,
                'basePath' => '/',
                'adminPath' => '/BHS/SPAdmin',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/BHS/SPAdmin/assets/'.$adminScriptName,
                'apiPath' => "https://{$hostName}/api/index.php",
                'adminApiPath' => "https://{$hostName}/BHS/SPAdmin/api/index.php",
                'pdo' => array(
                    
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    
                ),
            );

          case 'spadmin.bodwell.edu':
              return array(
                  'env' => 'production',
                  'debug' => false,
                  'basePath' => '/',
                  'adminPath' => '/',
                  'returnUrl' => $returnUrl,
                  'script' => '/assets/'.$scriptFileName,
                  'adminScript' => '/assets/'.$adminScriptName,
                  'apiPath' => "https://{$hostName}/api/index.php",
                  'adminApiPath' => "https://{$hostName}/api/index.php",
                  'pdo' => array(
                     
                  ),
                  'smtp' => array(
                      'debug' => false,
                      'host' => 'smtp.sendgrid.net',
                      'port' => '587',
                      'secure' => 'TLS',
                      'auth' => true,
                    
                  ),
              );
        case 'dev.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => true,
                'basePath' => '/',
                'adminPath' => './',
                'returnUrl' => $returnUrl,
                'script' => './',
                'adminScript' => './assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'adminApiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => true,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    
                ),
                'backdoor' => $backdoor,
            );
        case 'localhost':
        return array(
            'env' => 'production',
            'debug' => true,
            'basePath' => '/student.bodwell.edu/',
            'adminPath' => '/SPadmin/?page=dashboard',
            'returnUrl' => $returnUrl,
            'script' => '/assets/'.$scriptFileName,
            'adminScript' => '/assets/'.$adminScriptName,
            'apiPath' => "http://{$hostName}/student.bodwell.edu/api/index.php",
            'adminApiPath' => "http://{$hostName}/api/index.php",
            'pdo' => array(
              
            ),
            'bypassAuth' => false,
            'smtp' => array(
                'debug' => true,
                'host' => 'smtp.sendgrid.net',
                'port' => '587',
                'secure' => 'TLS',
                'auth' => true,
              
            ),
            'backdoor' => $backdoor,
        );
        default:
            return array(
                'env' => 'development',
                'debug' => true,
                'basePath' => '/',
                'adminPath' => '/admin/',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                    'database' => 'mysql',
                    'dsn' => 'mysql:host=localhost;dbname=bodwell',
                    'user' => 'root',
                    'pass' => 'root',
                ),
                'testing' => array(
                    'staffId' => 'F0123',
                    'staffRole' => '99',
                    'studentId' => '201500126',
                    
                ),
                'bypassAuth' => true,
                'smtp' => array(
                    'debug' => true,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    
                ),
            );
    }

}

$settings = array_merge(getCommonSettings(), getEnvironmentSettings());
