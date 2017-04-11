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

if($loggedIn == "yes") {

    if($loggedIn == "yes" && basename($_SERVER["SCRIPT_FILENAME"], '.php') == "index") {
        header("Location: menu.php");
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
        header("Location: menu.php");
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