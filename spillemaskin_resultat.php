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

    </style>
</head>
<body>

<div id="tabell_container">
    <p class="link"><a href="menu.php">Tilbake</a></p>
    <div id="tittel">
        Oversikt / Statistikk spillemaskin
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