<?php
/**
 * Created by PhpStorm.
 * User: EliseIGank
 * Date: 03.04.2017
 * Time: 15.48
 */

function checkInterval($futureTime)
{
    $now = new DateTime();
    //$future_date = new DateTime('2011-05-11 12:00:00');
    $interval = $future_date->diff($now);
    echo $interval->format("%a days, %h hours, %i minutes, %s seconds");
}

function getUsername($report) {
    $substr2 = "";
    if(strpos($report, "i Detroit")) {
        $substr2 = "i Detroit";
    } else if(strpos($report, "i Oslo")) {
        $substr2 = "i Oslo";
    }
    else if(strpos($report, "i Mogadishu")) {
        $substr2 = "i Mogadishu";
    }
    else if(strpos($report, "i Las Vegas")) {
        $substr2 = "i Las Vegas";
    }
    else if(strpos($report, "i Kuala")) {
        $substr2 = "i Kuala";
    }
    else if(strpos($report, "i Las Vegas")) {
        $substr2 = "i Las Vegas";
    }
    else if(strpos($report, "i New York")) {
        $substr2 = "i New York";
    }
    else if(strpos($report, "i Kabul")) {
        $substr2 = "i Kabul";
    }
    else if(strpos($report, "i Rio")) {
        $substr2 = "i Rio";
    }

    //$username = substr($report, 46, strpos($report, $substr2)-46);
    $username = get_string_between($report, "var", $substr2);
    return $username;
}

function getTimer($report) {
    $timer = get_string_between($report, "frem til", ". Oppdraget");

    return $timer;
}


if(isset($_POST['save_report']))  {
    $report = htmlspecialchars($_POST['rapport']);

    if(strpos($report, "frem til") !== false) {
        $username = getUsername($report);
        $timer = getTimer($report);
        header("Location: hotel_timer.php?report=" . $username . " : " . $timer);
    } else {
        header("Location: hotel_timer.php?report=Ingen hotelltimere funnet");
    }
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
?>