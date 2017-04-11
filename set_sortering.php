<?php
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 20.03.2017
 * Time: 20.49
 */

$sortering = $_GET['sortering'];

if($sortering == "gudfar") {
    setcookie("sortering", "Gudfar", time()+3600*24*30);
}

else if($sortering == "cc") {
    setcookie("sortering", "Capo Crimini", time()+3600*24*30);
}

else if($sortering == "tutti") {
    setcookie("sortering", "Tutti", time()+3600*24*30);
}

else {
    setcookie("sortering", "alle", time()+3600*24*30);
}

header("Location: add.php?sortering=".$sortering);
?>