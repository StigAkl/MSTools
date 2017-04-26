<?php
    include_once("access/database_functions.php");
    $regler = getSpillemaskinRegler();


    if(isset($_POST['save'])) {
        $regler = getSpillemaskinRegler();
        $min_bet = $_POST['min_bet'];
        $max_bet = $_POST['max_bet'];
        $max_on_loss = $_POST['max_on_loss'];
        $num_rounds = $_POST['num_rounds'];
        $money_at_start = $_POST['money_at_start'];

        if(empty($min_bet)) {
            $min_bet = $regler['min_bet'];
        }
        if(empty($max_bet)) {
            $max_bet = $regler['max_bet'];
        }
        if(empty($max_on_loss)) {
            $max_on_loss = $regler['max_bet_on_loss'];
        }
        if(empty($num_rounds)) {
            $num_rounds = $regler['num_rounds'];
        }
        if(empty($money_at_start)) {
            $money_at_start = $regler['money_at_start'];
        }

        if($num_rounds > 50)
            $num_rounds = 50;

        if(isset($_POST['max_on_loss']))
            $max_on_loss = 1;
        else
            $max_on_loss = 0;

        $db = Db::getInstance();
        $sql = "UPDATE spillemaskin_regler SET min_bet = '$min_bet', max_bet = '$max_bet', num_rounds = '$num_rounds', money_at_start='$money_at_start', max_bet_on_loss='$max_on_loss'";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $sql = "INSERT INTO spillemaskin (money, nextbet) VALUES (:money, :nextbet)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":money", $money_at_start);
        $stmt->bindParam(":nextbet", $min_bet);

        $stmt->execute();

        $last_id = $db->lastInsertId();

        $sql = "UPDATE spillemaskin_regler SET spillemaskin = '$last_id'";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        header("Location: spillemaskin_resultat.php");
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <link rel="icon" href="design/img/spider.gif">
    <title>MS Tools</title>

    <style>
        
        a {
            cursor: pointer;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border: none;
        }

        td, th {
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

        .tittel {
            float:left;
            text-align: left;
            font-size: 1.3em;
            font-weight: bold;
            margin: 0;
            padding:0;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: 10px;
        }

        #tabell_container {
            width: 70%;
            margin: 0px auto;
        }

        .link {
            margin-top: 20px;
            float: left;
            margin-right: 10px;
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

        table.regler {
            font-family: arial, sans-serif;
            border: none;
            width: 50%;
            margin-bottom: 10px;
            margin-left: 30px;

        }

        tr.regler:nth-child(even) {
            background-color: #DFF0D8;
        }

        #adminpanel {
            width: 100%;
            margin-top: 40px;
            margin-bottom:40px;
            background-color: #DFF0D8;
            border:1px solid #468847;
            display: none;
        }

        input[type=text] {
            padding: 3px;
            border:2px solid #ccc;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            width: 150px;
            height: 25px;
            text-align: center;
            font-size: 10pt;
            margin-top: 5px;
        }

        input[type=submit] {
            width: 80%;
            height: 35px;
            background: #DFF0D8;
            border:1px solid #468847;
            cursor:pointer;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            padding:5px;
            margin: 0px auto;
            margin-left: 10%;
            margin-top: 10px;
            font-size: 0.8em;
            color: #666;
        }

        input[type=text]:focus {
            border-color:#333;
        }

        input[type='checkbox'] {
            color: #3D3D3D;
            width: 15px;
            height: 15px;
            padding: 5px;
        }

        .remove {
            text-align: left;
            font-weight: bold;
            float: right;
            margin-right: 40px;
            margin-top: 30px;
        }

        .remove a {
            color: #ff232b;
        }


    </style>
</head>
<body>

<div id="tabell_container">
    <p class="link"><a href="menu.php">Tilbake</a></p><p class="link">-</p><p class="link"><a onclick="fadeRulesIn()">Administrer regler</a></p>

    <div class="clear"></div>


    <div id="adminpanel">
        <div class="tittel">Administrer regler</div>
        <div class="remove"><a onclick="fadeRulesOut()">( X )</a></div>
        <div class="clear"></div>

        <form method="post">
            <table class="regler">
            <tr>
                <td width="30%">Min-bet:</td>
                <td width="50%"><input type="text" placeholder="<?php echo number_format($regler['min_bet'], 0, ",","."); ?>" name="min_bet"/></td>
            </tr>
            <tr style="background-color: #DFF0D8">
                <td width="30%">Maks-bet:</td>
                <td width="50%"> <input type="text" placeholder="<?php echo number_format($regler['max_bet'], 0, ",","."); ?>" name="max_bet"/></td>
            </tr>
            <tr>
                <td width="30%">Antall spill hvert minutt (maks 50):</td>
                <td width="50%"><input type="text" placeholder="<?php echo number_format($regler['num_rounds'], 0, ",","."); ?>" name="num_rounds"/></td>
            </tr>
                <tr style="background-color: #DFF0D8">
                    <td width="30%">Penger ved start: </td>
                    <td width="50%"><input type="text" placeholder="<?php echo number_format($regler['money_at_start'], 0, ",","."); ?>" name="money_at_start"/></td>
                </tr>

                <tr style="background-color: #DFF0D8">
                    <td width="30%">Sats maksbet igjen ved tap på maksbet:</td>
                    <td width="50%" ><input style="margin-left:20%" type="checkbox" <?php if($regler['max_bet_on_loss'] == 1) echo "checked";  ?> name="max_on_loss"/></td>
                </tr>
            <tr style="background-color: #DFF0D8">
                <td width="40%"><input type="submit" name="save" value="Oppdater regler og restart prosessen!"></td>
            </tr>
        </table>
        </form>

    </div>

    <div class="tittel">
        Oversikt / Statistikk spillemaskin
    </div>

    <div class="clear"></div>
    <div id="regler">
        Dette er en kopi av mafiaspillet sin spillemaskin. Hvert minutt vil en "AI" med <?php echo number_format($regler['money_at_start'], 0, ",",".");?> kroner spille <?php echo $regler['num_rounds']?> ganger på spillemaskinen etter følgende regler:
        <ul>
            <li>Satser <?php echo number_format($regler['min_bet'], 0, ",", ".");?> første gang</li>
            <li>Hvis det blir tap, vil innsatsen dobles helt til man vinner eller til man går tom.</li>
            <li>Dersom man vinner, vil neste innsats bli <?php echo number_format($regler['min_bet'], 0, ",", "."); ?> igjen og repeterer forrige punkt</li>
            <li>Maksbet er <?php echo number_format($regler['max_bet'], 0, ",", "."); ?>. <?php if($regler['max_bet_on_loss'] == 1) echo "Taper man på maks-bet fortsetter den å satse maksbet til den vinner eller går tom"; else echo "Taper man på maksbet går man tilbake til min-bet (".number_format($regler['min_bet'], 0, ",", ".").")"; ?></li>
        </ul>

        <br>
        Jackpot: 200 x innsats, 100 x innsats i parentes. Datoen viser når siste jackpot inntraff.
        <br><br><br>
        <font style="font-weight:bold">Ny simulering startes 20. April 00:01:00</font>
    </div>

<table>

    <tr>
        <th>Antall spill</th>
        <th>Høyeste gevinst</th>
        <th>Profitt</th>
        <th>Høyeste profitt oppnådd</th>
        <th>Antall jackpot</th>
        <th>Antall resets</th>
        <th>Flest tap på rad</th>
    </tr>

    <?php printSpillemaskinStatistikk($regler['spillemaskin'], $regler['money_at_start']); ?>

</table>


<p class="overskrift">Siste 1000 spill</p>

<table>
    <tr>
        <th>#</th>
        <th>Tid</th>
        <th>Resultat</th>
        <th>Innsats</th>
    </tr>

    <?php printSpillemaskinLog($regler['spillemaskin']); ?>

</table>

</div>

<script type="text/javascript">


    function fadeRulesIn() {
            $("#adminpanel").fadeIn();
    }

    function fadeRulesOut() {
        $("#adminpanel").fadeOut();
    }

</script>
</body>
</html>