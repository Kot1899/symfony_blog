<?php

//session_start();
//$_SESSION['time']=date("H:i:s");
//echo $_SESSION['time'];

//session_start();
//if (!isset($_SESSION['time'])) {
//    $_SESSION['time'] = date("H:i:s");
//}
//echo $_SESSION['time'];

//echo session_save_path();
//echo sys_get_temp_dir();

//session_start();
//if (!isset($_SESSION['time'])) {
//    $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
//    $_SESSION['time'] = date("H:i:s");
//}
//if( $_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT']){
//    die ('wrong browser');
//}
//echo $_SESSION['time'];

//session_start();
//
//if (!isset($_SESSION['time'])) {
//    $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
//    $_SESSION['time'] = date("H:i:s");
//}
//
//if ($_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT']) {
//    die('Wrong browser');
//}
//
//echo $_SESSION['time'];


//
//session_start();
//
//echo session_id();
//
//if (isset($_SESSION['name'])) {
//    echo '<br>' . 'session is set.';
//} else {
//    echo '<br>' . 'session is destroyed';
//}
//
//$_SESSION['name'] = 'Roman';
//$_SESSION['email'] = 'slisarenko@email.com';


//session_start();
//if (isset($_SESS["id"])) {
//    echo $_SESS["id"];
//} else {
//    $_SESS["id"] = 42;
//}
echo session_save_path();
echo sys_get_temp_dir();