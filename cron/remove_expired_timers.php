<?php
include_once ("../controller/access/db_connect.php");
include_once ("../functions/functions.php");
/**
 * Created by PhpStorm.
 * User: EliseIGank
 * Date: 11.04.2017
 * Time: 02.41
 */

$conn = Db::getInstance();
$now = new DateTime();
$now->add(new DateInterval("PT2H"));


if($_GET['code'] == "12jlkdj120981") {

    $ip = getUserIP();
    $date = clone $now;

    //Logger utgått for mer enn 5 minutter siden skal slettes
    $date->sub(new DateInterval('PT5M'));
    $date_string = $date->format('Y-m-d H:i:s');

    $sql = "UPDATE hoteltimers SET removed = 1 WHERE hoteltime < '$date_string' AND removed=0";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $num = $stmt->rowCount();

    $message = "Ingen tider er slettet.";
    $status = "CRON JOB SUCCESSFULL";
    $type = "cronjob";
    $date = new DateTime();
    if($num > 0 )
        $message = $num . " tider er slettet";

    $sql = "INSERT INTO log (type, status, message, time_registered, ip) VALUES (:type, :status, :message, :time_registered, :ip)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam("type", $type);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":time_registered", $now->format('Y-m-d H:i:s'));
    $stmt->bindParam(":ip", $ip);
    $stmt->execute();

} else {
    $status = "CRON JOB FAILED";
    $message = "Invalid code";
    $date = new DateTime();
    $sql = "INSERT INTO log (type, status, message, time_registered, ip) VALUES (:type, :status, :message, :time_registered, :ip)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":time_registered", $now->format('Y-m-d H:i:s'));
    $stmt->bindParam(":ip", $ip);
    $stmt->execute();
}


?>