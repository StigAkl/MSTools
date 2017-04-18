<?php
include_once ("access/db_connect.php");
include_once ("functions/functions.php");
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 14.04.2017
 * Time: 23.21
 */


$min_bet = 10000;
$number_of_games = 100;
if(isset($_GET['code']) == "jjjf23f38u9a89uc") {
    $id = 2;
    $i = 0;
    while($i < $number_of_games) {
        $arr = array("kirsebaer", "wild", "banan", "sitron", "r7", "w7", "b7", "bbar", "rbar", "wbar", "bbar", "rbar", "wbar", "bbar", "rbar", "wbar");
        $rand_keys = array();
        array_push($rand_keys, rand(0, 15));
        array_push($rand_keys, rand(0, 15));
        array_push($rand_keys, rand(0, 15));

        $result = check_result($arr[$rand_keys[0]], $arr[$rand_keys[1]], $arr[$rand_keys[2]]);

        $bet = getBet($id);
        $money = getMoney($id);
        $maks_bet = 50000000;
        $highestWin = getHighest($id);
        $profit = getProfit($id);
        $highestWinResult = getResult($id);
        $loss_in_row = getLossInRow($id);
        $loss_streak = getLossStreak($id);


        //Oppdater total loss-streak
        if($bet > $min_bet)
            $loss_streak = $loss_streak + 1;
        else
            $loss_streak = 0;

        if($loss_streak > $loss_in_row)
            $loss_in_row = $loss_in_row +1;


        echo "bet: " . $bet . ", money: " . $money;


        if (($money - $bet) <= $money) {
            echo "Money: " . $money . "<br/>";
            if ($result != "Du vinner ingenting") {
                $message = "Du fikk " . $arr[$rand_keys[0]] . ", " . $arr[$rand_keys[1]] . " og " . $arr[$rand_keys[2]] . " og vinner " . $result * $bet . " kroner! Innsats: " . $bet;
                $money = $money + ($result * $bet) - $bet;
                $profit = $money - 500000000;

                if ((($result * $bet) - $bet) > $highestWin) {
                    $highestWin = ($result * $bet) - $bet;
                    $highestWinResult = $result;
                }


                updateMoney($money, $id);
                insertLog($message, "Vinner", $id);
                setBet($min_bet, $highestWin, $profit, $highestWinResult, $id, $loss_in_row, $loss_streak);
                echo $message;
            } else {
                $money = $money - $bet;
                $message = "Du fikk " . $arr[$rand_keys[0]] . ", " . $arr[$rand_keys[1]] . " og " . $arr[$rand_keys[2]] . " og vinner ingenting. Innsats: " . $bet;
                insertLog($message, "Taper", $id);
                updateMoney($money, $id);
                if ($bet * 2 >= $maks_bet) {
                    $bet = $maks_bet;
                    setBet($bet, $highestWin, $profit, $highestWinResult, $id, $loss_in_row, $loss_streak);
                } else {
                    setBet($bet * 2, $highestWin, $profit, $highestWinResult, $id, $loss_in_row, $loss_streak);
                }
                echo $message;
            }
        } else {
            setMoney($id);
            insertLog("Tom for penger, resetter", "Tom for penger", $id);
            setBet($min_bet, 0, 0, 0, $id, 0, 0);
        }
        $i++;
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


function setMoney($id) {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET money = 500000000 WHERE id = '$id'";

    $stmt = $db->prepare($sql);
    $stmt->execute();
}
function getMoney($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['money']);
}

function getBet($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['nextbet']);
}

function getHighest($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id='$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['highest_win']);
}

function getProfit($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id='$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['profit']);
}

function getResult($id) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM spillemaskin WHERE id = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    return intval($row['highest_win_result']);
}


function setBet($bet, $highest_win, $profit, $highest_win_result, $id, $loss, $streak) {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET nextbet = '$bet', highest_win = '$highest_win', highest_win_result = '$highest_win_result', profit = '$profit', loss_in_row = '$loss', loss_streak = '$streak' WHERE id = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function updateMoney($money, $id) {
    $db = Db::getInstance();
    $sql = "UPDATE spillemaskin SET money = '$money' WHERE id = '$id'";

    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function insertLog($message, $type, $id){
    $date = getNowDatetime();
    $db = Db::getInstance();
    $sql = "INSERT INTO spillemaskin_log (time, type, message, spillemaskin) VALUES (:time, :type, :message, :spillemaskin)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":time", $date->format('Y-m-d H:i:s'));
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":spillemaskin", $id);
    $stmt->execute();
}

function getLossInRow($id) {
    $sql = "SELECT loss_in_row FROM spillemaskin WHERE id='$id'";
    $db = Db::getInstance();
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch();

    return $result['loss_in_row'];

}

function getLossStreak($id) {
    $sql = "SELECT loss_streak FROM spillemaskin WHERE id='$id'";
    $db = Db::getInstance();
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch();

    return $result['loss_streak'];

}

?>

