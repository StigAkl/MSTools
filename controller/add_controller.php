<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 20.03.2017
 * Time: 17.04
 */
include_once("access/db_connect.php");
include_once ("access/database_functions.php");
include_once ("functions/functions.php");

if(isset($_POST["add"])) {
    $username = htmlspecialchars($_POST['username']);
    $rank = htmlspecialchars($_POST['rank']);
    $noob = htmlspecialchars($_POST['noob']);
    setcookie("RankCookie", $rank, time()+3600*24*30);

    if(empty($rank)) {
        header("Location: add.php?error=empty");
        exit();
    }
    else {
        if(empty($noob)) {
            $noob = 0;
        }

        if(!usernameExist($username)) {
            $connectoin = Db::getInstance();
            $sql = "INSERT INTO Users(username, rank, noobfaktor) VALUES ('$username', '$rank', '$noob')";
            $connectoin->exec($sql);
            saveLog("Liste", "Ny " . $rank, "La til nytt brukernavn: " . $username, getNowDatetime(), getUserIP());
            header("Location: add.php?added=" . $username);
        } else {
            updateUser($username, $rank, $noob);
            saveLog("Liste", "Oppdatert rank " . $rank, $username . " har nå ranken " . $rank, getNowDatetime(), getUserIP());
            header("Location: add.php?edited=" . $username);
        }
    }
}


if(isset($_GET['remove'])) {
    $username = htmlspecialchars($_GET['remove']);
    if(usernameExist($username)) {
        removeUser($username);
        header("Location: add.php?removed=".$username);
    } else {
        header("Location: add.php?error=removed");
    }
}

function updateUser($username, $rank, $noob) {
    $username = htmlspecialchars($username);
    $noob = htmlspecialchars($noob);
    $rank = htmlspecialchars($rank);
    $db = Db::getInstance();
    $sql = "UPDATE Users SET username = '$username', rank = '$rank', noobfaktor='$noob' WHERE username = '$username'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}


function listUsers($rank) {
    $db = Db::getInstance();
    $sql = "SELECT * FROM Users WHERE rank='$rank' ORDER BY username";
    $stmt = $db->prepare($sql);
    echo "<table>";
    echo "<tr>";
    echo "<th>Brukernavn</th>";
    echo "<th>Fjern</th>";
    echo "</tr>";
    $stmt->execute();
    while($resultat = $stmt->fetch()) {
        echo "<tr id='".$resultat['username']."'>";
        echo "<td>";
        echo "<a href='http://mafiaspillet.no/profile.php?viewuser=".$resultat['username']."'>".$resultat['username']."</a>";
        echo "</td>";
        echo "<td>";
        echo "<a href='javascript:void(0)' onclick=\"remove2('".$resultat['username']."')\">( X ) </a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function countUsers($rank) {
    $rank = htmlspecialchars($rank);
    $db = Db::getInstance();
    $sql = "SELECT * FROM Users WHERE rank='$rank'";
    $del = $db->prepare($sql);
    $del->execute();
    $num = $del->rowCount();

    return $num;
}

function usernameExist($username) {
    $username = htmlspecialchars($username);
    $sql = "SELECT username FROM Users WHERE username ='$username'";

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

function removeUser($username) {
    $username = htmlspecialchars($username);
    $sql = "DELETE FROM Users WHERE username='$username'";
    $db = Db::getInstance();
    $db->exec($sql);
}
?>