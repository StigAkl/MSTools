<?php require ("controller/check_login_status.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MS Tools</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <link rel="icon" href="design/img/spider.gif">
    <script src="js/script.js"></script>
</head>
<body>

<div id="content">

    <p class="link"><a href="menu.php">Tilbake</a></p>
    <textarea id="logg" placeholder="Lim inn logg fra undersått">
</textarea>

    <div class="submitButton">

        <button class="button" id="analyser_logg">Analyser logg</button>

    </div>

    <div id="resultat">
        <ul class="data">
            <li><span class="res">Resultat:</span></li>
<!--            <li>Antall ganger ute hvert minutt: <span class="rdata">3</span></li>-->
<!--            <li>Gjennomsnitlig sekund hvert minutt: <span class="rdata">42</span></li>-->
<!--            <li>Sannsynlig stjeletimer: <span class="rdata">18:25:18 | 18:30:43 | 18:36:04</span></li>-->
<!--            <li>Foreslått skytetitdspunkt: <span class="rdata">18:38:41 i Oslo </span>(2.15% sannsynlighet for treff!) </li>-->
            <li>Debug: <span id="debug"></span></li>
            <li><div id="stealTimers"></div></li>
        </ul>
    </div>
</div>



</body>
</html>