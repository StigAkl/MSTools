<?php
/**
 * Created by PhpStorm.
 * User: EliseIGank
 * Date: 03.04.2017
 * Time: 15.48
 */
include_once("access/db_connect.php");


if(isset($_GET['remove'])) {
    $username = htmlspecialchars($_GET['remove']);
    remove($username);
}

function checkInterval($timestamp)
{
    $now = new DateTime();
    $then = new DateTime();
    $then->setTimestamp($timestamp);

    $then->sub(new DateInterval("PT2H"));

    $diff = $now->diff($then);
    $minutes = ($diff->format('%a') * 1440) +
        ($diff->format('%h') * 60) +
        $diff->format('%i');


    if($minutes < 0)
        return -1;
    else if($minutes <= 60)
        return 1;
    else if($minutes <= 120)
        return 2;
    else if($minutes <= 360)
        return 6;
    else if($minutes <= 720)
        return 12;
    else
        return 0;
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
    else if(strpos($report, "i London")) {
        $substr2 = "i London";
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

    $split = explode(' ', $substr2);
    $city = $split[1];
    $username = get_string_between($report, "var", $substr2);
    return $username . ":" . $city;
}

function getTimer($report) {
    $timer = get_string_between($report, "frem til", ". Oppdraget");
    return $timer;
}


if(isset($_POST['save_report']))  {
    $report = htmlspecialchars($_POST['rapport']);

    if(strpos($report, "frem til") !== false) {

        $user_city = getUsername($report);
        $str = explode(":", $user_city);
        $username = $str[0];
        $city = $str[1];
        $timer = getTimer($report);


        //7. april 2017 kl 17:30
        //0 = "", 1 = 7., 2 = april, 3 = 2017, 4 = kl, 5 = 17:30
        $arr_timer = preg_split('/\s+/', $timer);
        $day = getDay(substr($arr_timer[1], 0, -1));
        $month = getMonth($arr_timer[2]);
        $year = date("Y");

        $time_split = explode(":", $arr_timer[5]);

        $hour = $time_split[0];
        $minute = $time_split[1];
        $second = "00";

        $format = 'Y-m-d H:i:s';
        $datetime = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;

        $date = DateTime::createFromFormat($format, $datetime);

        //USE THIS IN THE OUTPUT: echo $date->format("j. F H:i");
        //header("Location: hotel_timer.php?report=" . $username . " : " . $timer . " : " . $city . " : " . date("Y"));
        saveToDb($date, $username, $city);
    } else {
        //header("Location: hotel_timer.php?error=notimers");
    }
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function getMonth($month) {
    switch ($month) {
        case "januar":
            return "01";
            break;
        case "februar":
            return "02";
            break;
        case "mars":
            return "03";
            break;
        case "april":
            return "04";
            break;
        case "mai":
            return "05";
            break;
        case "juni":
            return "06";
            break;
        case "juli":
            return "07";
            break;
        case "august":
            return "08";
            break;
        case "september":
            return "09";
            break;
        case "oktober":
            return "10";
            break;
        case "november":
            return "11";
            break;
        case "desember":
            return "12";
            break;
    }
}

function getDay($day) {
    switch ($day) {
        case "1":
            return "01";
            break;
        case "2":
            return "02";
            break;

        case "3":
            return "03";
            break;

        case "4":
            return "04";
            break;

        case "5":
            return "05";
            break;

        case "6":
            return "06";
            break;

        case "7":
            return "07";
            break;

        case "8":
            return "08";
            break;

        case "9":
            return "09";
            break;
        default: return $day;
    }
}

function saveToDb($date,$username,$city) {
    $username = trim(htmlspecialchars($username));
    $db =Db::getInstance();

    $city = getCity($city);
    if(usernameExist($username)) {

        $sql = "UPDATE hoteltimers SET removed=1 WHERE username='$username' AND private = 0";
        if(isset($_GET['private']) == "true") {
            $sql = "UPDATE hoteltimers SET removed=1 WHERE username='$username' AND private = 1";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }


    $private = 0;

    if(isset($_GET['private']) == "true") {
        $private = 1;
    }

    $sql = "INSERT INTO hoteltimers (username, hoteltime, city, private) VALUES (:username, :hoteltime, :city, :private)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":hoteltime", $date->format("Y-m-d H:i:s"));
    $stmt->bindParam(":city", $city);
    $stmt->bindParam(":private", $private);

    $stmt->execute();

    $link = "$_SERVER[REQUEST_URI]";
    //header("Location: " . $link);
}

function listLog() {
    $sql = "";

    if(isset($_GET['private']) == "true") {
        $sql = "SELECT * FROM hoteltimers WHERE removed = 0 AND private >= 0 ORDER BY hoteltime";
    } else {
        $sql = "SELECT * FROM hoteltimers WHERE removed = 0 AND private = 0 ORDER BY hoteltime";
    }
    $db = Db::getInstance();
    $stmt = $db->prepare($sql);

    $stmt->execute();

    $format = 'Y-m-d H:i:s';
    $count = 0;
        while($row = $stmt->fetch()) {
            $date = DateTime::createFromFormat($format, $row['hoteltime']);
            $now = new DateTime("now");

            $copytime = clone $date;
            $copytime->sub(new DateInterval("PT2H"));

            $timestamp1 = $now->getTimestamp();
            $timestamp2 = $copytime->getTimestamp();

            if($timestamp1 < ($timestamp2+300)) {
                $interval = checkInterval($date->getTimestamp());

                if($interval > 0 && $interval <= 6) {
                    echo "<div class='hotel_info blink' id='".$row['username']."'>";
                } else {
                    echo "<div class='hotel_info' id='".$row['username']."'> ";
                }
                echo "<ul class='hotel_info_ul'>";
                echo "<li><font style='font-weight: bold'>Brukernavn: </font> <a target='_blank' href='http://mafiaspillet.no/profile.php?viewuser=".$row['username']."'>".$row['username']."</a></li>";
                echo "<li><font style='font-weight: bold'>Tid: </font> " . $date->format("j. F H:i") . "</li>";
                echo "<li><font style='font-weight: bold'>By: </font> " . $row['city'] . "</li>";
                echo "<li><button class='delete_button' onclick=\"removeTimer('".$row['username']."')\">Slett</button></li>";
                echo "</ul>";
                echo "</div>";
                $count = $count + 1;
                }
        }

        if($count == 0) {
            echo "<div id='ingentider'>Ingen hotelltider</div>";
        }
}

function remove($username) {
    $username = htmlspecialchars($username);

    if($_GET['private'] == "true") {
        $sql = "UPDATE hoteltimers SET removed = 1 WHERE username = '$username' AND private = 1 AND removed = 0";
        $db = Db::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo "deleted private";
    } else {
        $sql = "UPDATE hoteltimers SET removed = 1 WHERE username = '$username' AND private = 0 AND removed = 0";
        $db = Db::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo "deleted public";
    }
}


function usernameExist($username) {
    $username = htmlspecialchars($username);
    $sql = "SELECT username FROM hoteltimers WHERE username ='$username'";

    try {
        $db = Db::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

    } catch(PDOException $e) {
        return $e->getMessage();
    }

    if($count >= 1)
        return true;
    else
        return false;
}

function getCity($city) {
    switch($city) {
        case "New":
            return "New York";
            break;
        case "Rio":
            return "Reio De Janeiro";
            break;
        case "Kuala":
            return "Kuala Lumpur";
            break;
        case "Las":
            return "Las Vegas";
            break;
        default:
            return $city;
    }
}

?>