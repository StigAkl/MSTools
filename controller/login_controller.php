<?php
session_set_cookie_params(0);
session_start();
include_once ("access/database_functions.php");
include_once ("functions/functions.php");

/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 20.03.2017
 * Time: 17.19
 */

$loggedIn = $_SESSION["loggedin"];
$ip = getUserIP();
$date = getNowDatetime();

if($loggedIn == "yes") {

    if($loggedIn == "yes" && basename($_SERVER["SCRIPT_FILENAME"], '.php') == "index") {
        saveLog("Login", "Login Successfull", "Innlogget via gyldig session", $date, $ip);
        header("Location: menu.php");
    }
}

$password = "kake";


if(isset($_POST['login'])) {
    $passwordInput = $_POST["password"];

    if(!preg_match('/^[A-Za-z0-9]+$/', $passwordInput) || ($password != $passwordInput)) {
        saveLog("Login", "Login Error", "Forsøk på innlogging ved feil passord", $date, $ip);
        header("Location: index.php?error=wrongpw");
    }

    else {
        saveLog("Login", "Login Successfull", "Innlogging vellykket, riktig passord ble oppgitt.", $date, $ip);
        $_SESSION["loggedin"] = "yes";
        header("Location: menu.php");
    }
}

?>