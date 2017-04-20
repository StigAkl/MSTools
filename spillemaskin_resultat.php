<?php
    include_once("access/database_functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <link rel="icon" href="design/img/spider.gif">
    <title>MS Tools</title>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid rgba(221, 221, 221, 0.58);
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .overskrift {
            margin-top: 30px;
            font-size: 1.2em;
            font-weight: bold;
        }

        #tittel {
            float:left;
            text-align: left;
            font-size. 1.4em;
            font-weight: bold;
            margin: 0;
            padding:0;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        #tabell_container {
            width: 70%;
            margin: 0px auto;
        }

        .link {
            margin-top: 20px;
        }

        #regler {
            background-color: #DFF0D8;
            color: #468847;
            font-size: 0.8em;
            padding:20px;
            margin-bottom: 20px;
            border:1px solid #468847;
        }

        #regler li {
            list-style-type: disc;
            margin-left: 40px;
        }
    </style>
</head>
<body>

<div id="tabell_container">
    <p class="link"><a href="menu.php">Tilbake</a></p>
    <div id="tittel">
        Oversikt / Statistikk spillemaskin
    </div>

    <div class="clear"></div>
    <div id="regler">
        Dette er en kopi av mafiaspillet sin spillemaskin. Hvert minutt vil en "AI" med 500.000.000 kroner spille 50 ganger på spillemaskinen etter følgende regler:
        <ul>
            <li>Satser 1.000.000 første gang</li>
            <li>Hvis det blir tap, vil innsatsen dobles helt til man vinner eller til man går tom.</li>
            <li>Dersom man vinner, vil neste innsats bli 1.000.000 igjen og repeterer forrige punkt</li>
            <li>Maksbet er 64 millioner. Taper man på maksbet går man tilbake til min-bet (1.000.000)</li>
        </ul>

        <br>
        Jackpot: 200 x innsats, 100 x innsats i parentes. Datoen viser når siste jackpot inntraff.
        <br><br><br>
        <font style="font-weight:bold">Ny simulering startes 20. April 20:45:00, nå med korrekte sannsynligheter</font>
    </div>

<table>

    <tr>
        <th>Antall spill</th>
        <th>Høyeste gevinst</th>
        <th>Profitt</th>
        <th>Høyeste profitt oppnådd</th>
        <th>Antall jackpot</th>
        <th>Ant spill mellom to siste jackpots</th>
        <th>Flest tap på rad</th>
    </tr>

    <?php printSpillemaskinStatistikk(3, 500000000); ?>

</table>


<p class="overskrift">Siste 1000 spill</p>

<table>
    <tr>
        <th>#</th>
        <th>Tid</th>
        <th>Resultat</th>
        <th>Innsats</th>
    </tr>

    <?php printSpillemaskinLog(3); ?>

</table>

</div>
</body>
</html>