<?php
include_once ("../access/database_functions.php");
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 13.04.2017
 * Time: 19.11
 */

if(isset($_POST['type'])) {
    $type = htmlspecialchars($_POST['type']);
    setcookie("type", $type, time() + (86400 * 30), "/");
    header("Location: admin.php");
}

function listLogs($type) {
    getLogs($type);
}


?>