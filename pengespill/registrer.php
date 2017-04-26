<?php
include_once("db_connect.php");
/**
 * Created by PhpStorm.
 * User: Nichlas
 * Date: 25/04/2017
 * Time: 14:18
 */
if(isset($_POST['registrer'])) {
    $brukernavn = htmlspecialchars($_POST['brukernavn']);
    $passord = md5($_POST['passord']);

    if(!empty($brukernavn) && !empty($passord)) {
        $conn = Db::getInstance();
        $sql = "INSERT INTO brukere (brukernavn, passord) VALUES (:brukernavn, :passord)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":brukernavn", $brukernavn);
        $stmt->bindParam(":passord", $passord);
        $stmt->execute();

    } else {
        header("Location: registrer.php?error=emptyusername");
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Registrer</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<form method="post">
    <fieldset>
        <legend>Registrering:</legend>
        Brukernavn: <input type="text" name="brukernavn" placeholder="Brukernavn" autocomplete="off"><br>
        Passord: <input type="password" name="passord" placeholder="Passord" autocomplete="off"><br>
        <input type="submit" value="Registrer deg!" name="registrer">
    </fieldset>
</form>
</body>
</html>
