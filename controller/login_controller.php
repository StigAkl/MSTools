<?php
session_set_cookie_params(0);
session_start();
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 20.03.2017
 * Time: 17.19
 */

$loggedIn = $_SESSION["loggedin"];

if($loggedIn == "yes" || $loggedIn == "admin") {

    if($loggedIn == "yes" && basename($_SERVER["SCRIPT_FILENAME"], '.php') == "index") {
        header("Location: add.php");
    } else {
        if(basename($_SERVER["SCRIPT_FILENAME"], '.php') == "admin_login" && $loggedIn == "admin") {
            header("Location: admin.php?kake");
        }
    }
}

$password = "kake";
$adminPassword = "kake123";

if(isset($_POST['login'])) {
    $passwordInput = $_POST["password"];

    if(!preg_match('/^[A-Za-z0-9]+$/', $passwordInput) || ($password != $passwordInput)) {
        header("Location: index.php?error=wrongpw");
    }

    else {
        $_SESSION["loggedin"] = "yes";
        header("Location: add.php");
    }
}

if(isset($_POST['admin_login'])) {
    $password_input = $_POST['password'];

    if($password_input != $adminPassword) {
        header("Location: admin_login.php?error=wrongpw");
    } else {
        $_SESSION["loggedin"] = "admin";
        header("Location: admin.php");
    }
}
?>