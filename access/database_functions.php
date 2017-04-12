<?php
include_once("db_connect.php");

/*
 *
 * ALLE DATABASEOPERASJONER SKAL ETTERHVERT INN HIT
 *
 *
 */


function saveLog($type, $status, $message, $time_registered, $ip) {
    $sql = "INSERT INTO log (type, status, message, time_registered, ip) VALUES (:type, :status, :message, :time_registered, :ip)";
    $db = Db::getInstance();
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":time_registered", $time_registered->format('Y-m-d H:i:s'));
    $stmt->bindParam(":ip", $ip);

    $stmt->execute();
}

function updateHotelTimer($sql) {
    $conn = Db::getInstance();
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
}


?>