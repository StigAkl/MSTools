<?php
include_once ("../access/database_functions.php");
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 13.04.2017
 * Time: 19.11
 */
$rank = getRank();


if(isset($_POST['type'])) {
    $type = htmlspecialchars($_POST['type']);
    setcookie("type", $type, time() + (86400 * 30), "/");
    header("Location: admin.php");
}

if(isset($_POST['save'])) {
    $gudfar = htmlspecialchars($_POST['gudfar']);
    $cc = htmlspecialchars($_POST['capocrimini']);
    $tutti = htmlspecialchars($_POST['tutti']);

    if(empty($gudfar))
        $gudfar = 50;
    if(empty($cc))
        $cc = $rank['capocrimini'];
    if(empty($tutti))
        $tutti = $rank['tutti'];

    lagreRankStatistikk($gudfar, $cc, $tutti);
    header("Location: admin.php");
}
function listLogs($type) {
    getLogs($type);
}

function getRank() {
    return getRankStatistikk();
}


?>