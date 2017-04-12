<?php require ("controller/check_login_status.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MS Tools</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <link rel="icon" href="design/img/spider.gif">
    <script src="js/script2.js"></script>

    <style>

        .select-style {
            border: 1px solid #ccc;
            width: 150px;
            border-radius: 3px;
            float: left;
            height: 35px;
            margin-top: 6px;
            text-align: center;
        }

        .select-style select {
            width: 100%;
            border: none;
            height: 35px;
        }

        .select-style select:focus {
            outline: none;
        }

        select option {
            color: gray;
            height: 30px;
            font-size: 14px;
        }

        select:not(:checked) {
            color: gray;
        }

    </style>
</head>
<body>

<div id="content">

    <p class="link"><a href="menu.php">Tilbake</a></p>
    <textarea id="logg" placeholder="Lim inn logg fra undersått">
</textarea>
<p>Intervall:</p>
    <select id="minutes" class="select-style">
        <option value="05" selected="selected">5 min</option>
        <option value="04">4 min</option>
        <option value="03">3 min</option>
        <option value="02">2 min</option>
    </select>

    <select id="seconds" class="select-style">
        <option value="0">0 sek</option>
        <option value="05">05 </option>
        <option value="10">10 sek</option>
        <option value="15">15 sek</option>
        <option value="20" selected="selected">20 sek</option>
        <option value="30">30 sek</option>
        <option value="40">40 sek</option>
        <option value="50">50 sek</option>
        <option value="60">60 sek</option>

    </select>

    <div class="clear"></div>
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