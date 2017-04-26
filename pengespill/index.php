<?php
session_start();
include_once("db_connect.php");
/**
 * Created by PhpStorm.
 * User: Nichlas
 * Date: 25/04/2017
 * Time: 14:07
 */

if(isset($_POST['login'])) {
    $brukernavn = htmlspecialchars($_POST['brukernavn']);
    $passord = md5($_POST['passord']);

    if (empty($brukernavn) || empty($passord)) {
        header("Location: index.php?error=emptylogin");
    } else {
        $conn = Db::getInstance();
        $sql = "SELECT * FROM brukere WHERE brukernavn = '$brukernavn'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $bruker = $stmt->fetch();

        $passord2 = $bruker['passord'];

        $_SESSION['id'] = $bruker['id'];
        $_SESSION['logged_in'] = true;
        header("Location: game.php");




    }
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
<form method="post">
    <fieldset>
        <legend>Personalia:</legend>
        Brukernavn: <input type="text" name="brukernavn" placeholder="Brukernavn" autocomplete="off"><br>
        Passord: <input type="password" name="passord" placeholder="Passord" autocomplete="off"><br>
        <input type="submit" value="Logg inn!" name="login">
    </fieldset>
</form>
<a href="registrer.php">Registrer deg her!</a>
</body>
</html>