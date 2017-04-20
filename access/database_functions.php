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

function getLogs($type) {
    $sql = "SELECT * FROM log ORDER BY time_registered DESC";
    if(!empty($type)) {
        $sql = "SELECT * FROM log WHERE type = '$type' ORDER BY time_registered DESC";
    }

    $db = Db::getInstance();
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($result = $stmt->fetch()) {

        $date = DateTime::createFromFormat("Y-m-d H:i:s", $result['time_registered']);

        echo "<tr>";
        echo "<td>" .$result['type'] . " </td>";
        echo "<td>" .$result['status'] . " </td>";
        echo "<td>" .$result['message'] . " </td>";
        echo "<td>" .$date->format("j. F H:i") . " </td>";
        echo "<td>" .$result['ip'] . " </td>";
        echo "</tr>";
    }
}

function printSpillemaskinStatistikk($id, $start) {
    setlocale(LC_MONETARY,"nb_NO");
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id='$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $statistikk = $stmt->fetch();

    $sql = "SELECT * FROM spillemaskin_log WHERE spillemaskin='$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $num = $stmt->rowCount();

    $num_mini_jackpot = $statistikk['mini_jackpot'];
    $num_jackpot = $statistikk['jackpot'];
    $num_total_jackpot = $num_mini_jackpot + $num_jackpot;
    $last_jackpot = DateTime::createFromFormat("Y-m-d H:i:s", $statistikk['last_jackpot']);

    echo "<tr>";
    echo "<td>" . $num . "</td>";
    echo "<td>" . number_format($statistikk['highest_win'],  0, ',', '.') . " kr (".$statistikk['highest_win_result']." ganger innsats.)</td>";
    echo "<td>" . number_format(($statistikk['money']-$start),  0, ',', '.') . " kr</td>";
    echo "<td>" . number_format($statistikk['highest_profit'], 0, ',', '.') . " kr</td>";
    echo "<td>" . $num_jackpot . " ( " . $num_mini_jackpot . " ) <br> <font style='font-size:0.8em'>" . $last_jackpot->format("j. F H:i:s") . "</font></td>";
    echo "<td>" . 0 . "</td>";
    echo "<td>" . $statistikk['loss_in_row'] . " </td>";
    echo "</tr>";
}

function printSpillemaskinLog($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin_log WHERE spillemaskin='$id' ORDER BY id DESC LIMIT 1000";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $i = 1;
    while($result = $stmt->fetch()) {

        $resultat = explode(" ", $result['message']);
        $first = str_replace(",", "", $resultat[2]);
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $result['time']);
        $vinner = $result['type'];
        $gevinst = "Vinner ingenting.";
        $innsats = $resultat[10];
        if($vinner == "Vinner") {
            $gevinst = "Vinner " . number_format(intval($resultat[8]), 0, ",",".") . " kroner.";
            $innsats = intval($resultat[11]);
        }

        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $date->format("j. F H:i:s") . "</td>";
        echo "<td>
            <img src='design/img/spillemaskin/".$first.".jpg' width='50px' height='50px'/> 
            <img src='design/img/spillemaskin/".$resultat[3].".jpg' width='50px' height='50px'/>
            <img src='design/img/spillemaskin/".$resultat[5].".jpg' width='50px' height='50px'/>
             ". $gevinst ." </td>";
        echo "<td>" . number_format($innsats, 0, ",", ".") . "</td>";
        echo "</tr>";

        $i = $i+1;

    }
}

function getRankStatistikk() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM rank_statistikk";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $rank = $stmt->fetch();

    return $rank;
}

function lagreRankStatistikk($gf, $cc, $tutti) {
    $db = Db::getInstance();
    $sql = "UPDATE rank_statistikk SET gudfar='$gf', capocrimini='$cc', tutti='$tutti'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}


//function countNumJackpots() {
//    $db = Db::getInstance();
//    $sql = "SELECT * FROM spillemaskin_log WHERE type='Vinner'";
//    $stmt = $db->prepare($sql);
//
//    $stmt->execute();
//
//    $num_jackpot = 0;
//    $num_minijackpot = 0;
//    while($result = $stmt->fetch()) {
//        //Du fikk wbar, wbar og rbar og vinner 2000000 kroner! Innsats: 1000000
//
//        $str = $result['message'];
//        $resultat = explode(" ", $str);
//        $gevinst = intval($resultat[8]);
//        $innsats = intval($resultat[11]);
//
//        if($innsats > 0) {
//            $forhold = ($gevinst / $innsats);
//        } else
//            echo $result['id'];
//        if($forhold == 100) {
//            $num_minijackpot = $num_minijackpot+1;
//        } else if($forhold == 200) {
//            $num_jackpot = $num_jackpot+1;
//        }
//    }
//
//    $sql = "UPDATE spillemaskin SET mini_jackpot = '$num_minijackpot', jackpot = '$num_jackpot' WHERE id=2";
//    $stmt = $db->prepare($sql);
//    $stmt->execute();
//
//    echo "Jackpot: " . $num_jackpot . ", minijackpot: " . $num_minijackpot;
//}
?>