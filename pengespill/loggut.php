<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['logged_in']);
session_destroy();

header("Location: index.php?loggetut");
/**
 * Created by PhpStorm.
 * User: Nichlas
 * Date: 25/04/2017
 * Time: 16:18
 */


?>
