<?php
session_start();
ob_start();
/**
 * Created by PhpStorm.
 * User: EliseIGank
 * Date: 22.03.2017
 * Time: 04.14
 */
$loggedIn = $_SESSION["loggedin"];

if($loggedIn != "yes") {
    header("Location: index.php?error=login");
    exit();
}

