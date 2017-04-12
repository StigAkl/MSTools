<?php
include_once("../access/database_functions.php");
include_once ("../functions/functions.php");

/**
 * Created by PhpStorm.
 * User: EliseIGank
 * Date: 11.04.2017
 * Time: 02.41
 */

$now = getNowDatetime();

if($_GET['code'] == "12jlkdj120981") {

    $ip = getUserIP();
    $date = clone $now;

    //Logger utgått for mer enn 5 minutter siden skal slettes
    $date->sub(new DateInterval('PT5M'));
    $date_string = $date->format('Y-m-d H:i:s');

    $sql = "UPDATE hoteltimers SET removed = 1 WHERE hoteltime < '$date_string' AND removed=0";

    //Oppdaterer hotelltimere (kjører SQL-setningen over ^), og returnerer hvor mange hotelltimere som ble slettet.
    $num = updateHotelTimer($sql);


    $message = "Ingen tider er slettet.";
    $status = "CRON JOB SUCCESSFULL";
    $type = "cronjob";
    $date = new DateTime();

    //Hvis noen timere ble slettet, oppdater message
    if($num > 0 )
        $message = $num . " tider er slettet";

    saveLog($type, $status, $message, $now, $ip);

}

//Ellers, ugyldig kode.
else {
    $status = "CRON JOB FAILED";
    $message = "Invalid code";
    saveLog($type, $status, $message, $now, $ip);
}


?>