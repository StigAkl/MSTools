<?php
include_once ("access/db_connect.php");
include_once ("functions/functions.php");
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 14.04.2017
 * Time: 23.21
 */


if(isset($_GET['code']) == "jjjf23f38u9a89uc") {
    $arr = array("kirsebaer", "wild", "banan", "sitron", "r7", "w7", "b7", "bbar", "rbar", "wbar", "bbar", "rbar", "wbar", "bbar", "rbar", "wbar");
    $rand_keys = array();
    array_push($rand_keys, rand(0, 15));
    array_push($rand_keys, rand(0, 15));
    array_push($rand_keys, rand(0, 15));

    $result = check_result($arr[$rand_keys[0]], $arr[$rand_keys[1]], $arr[$rand_keys[2]]);

    $bet = getBet();
    $money = getMoney();
    $min_bet = 500000;
    $maks_bet = 50000000;
    $highestWin = getHighest();
    $profit = getProfit();
    $highestWinResult = getResult();

    echo "bet: " . $bet . ", money: " . $money;


    if (($money - $bet) <= $money) {
        echo "Money: " . $money . "<br/>";
        if ($result != "Du vinner ingenting") {
            $message = "Du fikk " . $arr[$rand_keys[0]] . ", " . $arr[$rand_keys[1]] . " og " . $arr[$rand_keys[2]] . " og vinner " . $result * $bet . " kroner! Innsats: " . $bet;
            $money = $money + ($result * $bet) - $bet;
            $profit = $money - 1000000000;

            if ((($result * $bet) - $bet) > $highestWin) {
                $highestWin = ($result * $bet) - $bet;
                $highestWinResult = $result;
            }


            updateMoney($money);
            insertLog($message, "Vinner");
            setBet($min_bet, $highestWin, $profit, $highestWinResult);
            echo $message;
        } else {
            $money = $money - $bet;
            $message = "Du fikk " . $arr[$rand_keys[0]] . ", " . $arr[$rand_keys[1]] . " og " . $arr[$rand_keys[2]] . " og vinner ingenting. Innsats: " . $bet;
            insertLog($message, "Taper");
            updateMoney($money);
            if ($bet * 2 >= $maks_bet) {
                $bet = $maks_bet;
                setBet($bet, $highestWin, $profit, $highestWinResult);
            } else {
                setBet($bet * 2, $highestWin, $profit, $highestWinResult);
            }
            echo $message;
        }
    } else {
        setMoney();
        insertLog("Tom for penger, resetter", "Tom for penger");
        setBet($min_bet, 0, 0, 0);
    }

}

function check_result($e1, $e2, $e3) {
    if($e1 == "kirsebaer" && $e2 == "kirsebaer" && $e3 == "kirsebaer")
        return 200;
    if($e1 == $e2 && $e2 == $e3 && $e1 == "wild")
        return 100;
    if($e1 == "banan" && $e2 == "kirsebaer" && $e3 == "sitron")
        return 80;
    if($e1 == "r7" && $e2 == "w7" && e3 == "b7")
        return 60;
    if($e1 == "r7" && $e2 == "r7"  && e3 == "r7")
        return 50;
    if($e1 == "w7" && $e2 == "w7" && e3 == "w7")
        return 40;
    if($e1 == "b7" && $e2 == "b7"  && e3 == "b7")
        return 20;
    if(($e1 == "w7" || $e1 == "b7" || $e1 == "r7") && ($e2 == "w7" || $e2 == "b7" || $e2 == "r7")  && ($e3 == "w7" || $e3 == "b7" || $e3 == "r7"))
        return 10;
    if($e1 == "bbar" && $e2 == "bbar" && $e3 == "bbar")
        return 8;
    if(($e1 == "r7" || $e1 == "rbar") && ($e2 == "w7" || $e2 == "wbar") && ($e3 == "b7" || $e3 == "bbar"))
        return 5;
    if(($e1 == "rbar" || $e1 == "r7") && ($e2 == "rbar" || $e2 == "r7") && ($e3 == "rbar" || $e3 == "r7"))
        return 2;
    if(($e1 == "bbar" || $e1 == "b7") && ($e2 == "bbar" || $e2 == "b7") && ($e3 == "bbar" || $e3 == "b7"))
        return 2;
    if(($e1 == "rbar" || $e1 == "bbar" || $e1 == "wbar") && ($e2 == "rbar" || $e2 == "bbar" || $e2 == "wbar") && ($e3 == "rbar" || $e3 == "bbar" || $e3 == "wbar"))
        return 2;
    if($e1 == "wild" || $e2 == "wild" || $e3 == "wild")
        return 3;
    else
        return "Du vinner ingenting";
}

function setMoney() {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET money = 1000000000";

    $stmt = $db->prepare($sql);
    $stmt->execute();
}
function getMoney() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['money']);
}

function getBet() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['nextbet']);
}

function getHighest() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['highest_win']);
}

function getProfit() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['profit']);
}

function getResult() {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['highest_win_result']);
}


function setBet($bet, $highest_win, $profit, $highest_win_result) {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET nextbet = '$bet', highest_win = '$highest_win', highest_win_result = '$highest_win_result', profit = '$profit'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function updateMoney($money) {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET money = '$money'";

    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function insertLog($message, $type){
    $date = getNowDatetime();
    $db = Db::getInstance();
    $sql = "INSERT INTO spillemaskin_log (time, type, message) VALUES (:time, :type, :message)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":time", $date->format('Y-m-d H:i:s'));
    $stmt->bindParam(":type", $type);
    $stmt->bindParam("message", $message);
    $stmt->execute();
}

?>

