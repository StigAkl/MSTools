<?php
/**
 * Created by PhpStorm.
 * User: Nichlas
 * Date: 25/04/2017
 * Time: 15:48
 */
session_start();
include_once("db_connect.php");
$logged_in = $_SESSION['logged_in'];
$id = $_SESSION['id'];

if($logged_in != true) {
    header("Location: index.php?error=nosession");
    exit();
}
if($logged_in == true) {
    $conn = Db::getInstance();
    $sql = "SELECT * FROM brukere WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $bruker = $stmt->fetch();

    $brukernavn2 = $bruker['brukernavn'];
    $penger = $bruker['penger'];
    echo "Du er logget inn som '$brukernavn2', du har ".number_format($penger, 0, "L",".")." kr.";
}


?>


<!doctype html>
<html>
<head>
    <title>Pengespill - Login</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<br><a href="loggut.php">Logg ut!</a>
</body>
</html>
