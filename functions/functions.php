<?php
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 12.04.2017
 * Time: 21.32
 */

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client."c";
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward."f";
    }
    else
    {
        $ip = $remote."r";
    }

    return $ip;
}

function getNowDatetime() {
    $now = new DateTime();
    $now->add(new DateInterval("PT2H"));

    return $now;
}



?>