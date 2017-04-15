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
            border: 1px solid #dddddd;
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
            width: 60%;
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
            list-style-type: circle;
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
        Dette er en kopi av mafiaspillet sin spillemaskin. Hvert minutt vil en "AI" med 1.000.000.000 kroner spille på spillemaskinen etter følgende regler:
        <ul>
            <li>Satser 500.000 første gang</li>
            <li>Hvis det blir tap, vil innsatsen dobles helt til man vinner eller til man går tom.</li>
            <li>Dersom man vinner, vil neste innsats bli 500.000 igjen og repeterer forrige punkt</li>
            <li>Hvis det blir mindre enn 0 kroner, vil hele prosessen bli nullstilt og den starter på nytt med 1.000.000.000 kroner.</li>
            <li>Maksbet er 50 millioner. Når man dobler fra 32.000.000 kr vil innsatsen bli satt til 50.000.000</li>
            <li>Den vil satse 50.000.000 helt til den vinner eller går tom for penger</li>
        </ul>

    </div>

<table>

    <tr>
        <th>Antall spill</th>
        <th>Høyeste gevinst</th>
        <th>Profitt</th>
        <th>Penger totalt</th>
        <th>Antall jackpot</th>
    </tr>

    <?php printSpillemaskinStatistikk(); ?>

</table>


<p class="overskrift">Siste 50 spill</p>

<table>
    <tr>
        <th>Tid</th>
        <th>Resultat</th>
        <th>Innsats</th>
    </tr>

    <?php printSpillemaskinLog(); ?>

</table>

</div>
</body>
</html>