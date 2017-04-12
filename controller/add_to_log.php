<?php
include_once ("../controller/check_login_status.php");
include_once ("../functions/functions.php");
include_once("../access/db_connect.php");
include_once ("../access/database_functions.php");

/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 12.04.2017
 * Time: 21.41
 */

if(isset($_POST['savelog'])) {
    $type = htmlspecialchars($_POST['type']);
    $status = htmlspecialchars($_POST['status']);
    $message = htmlspecialchars($_POST['message']);
    $ip = getUserIP();
    $date = getNowDatetime();

    saveLog($type, $status, $message, $date, $ip);

}

?>