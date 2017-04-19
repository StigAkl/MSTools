<?php session_start();
include_once ("controller/login_status.php");
include_once ("controller/admin_controller.php");


if(!isset($_COOKIE['type']))
    $type = "";
else
    $type = $_COOKIE['type'];

?>
<!doctype html>
<html>
<head>
    <title>MS Tools</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="../design/img/spider.gif">
    <style type="text/css">

        * {
            padding: 0;
            margin: 0;
        }

        body {
            margin: 0;
            background-color: #fafafc;
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #666;
        }

        #container {
            margin: 0px auto;
            margin-top: 20px;
            width: 75%;
        }


        .select-style {
            border: 1px solid #ccc;
            width: 150px;
            border-radius: 3px;
            float: left;
            height: 35px;
            margin-top: 10px;
            margin-bottom:10px;
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table.rank {
            width: 50%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #4CAF50;
            color: white;
        }

        input[type=text] {
            padding: 5px;
            border:2px solid #ccc;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            width: 50px;
            height: 25px;
            text-align: center;
            font-size: 12pt;
            margin-top: 10px;
        }

        input[type=text]:focus {
            border-color:#333;
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
        /* SUBMIT */


        input[type=submit] {
            width: 80%;
            height: 35px;
            background:#fff;
            border:0 none;
            cursor:pointer;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            padding:5px;
            margin: 0px auto;
            margin-left: 10%;
            margin-top: 10px;
        }

        .box {
            margin: 0 auto;
            width: 60%;
            border: 1px solid #C0C0C0;
            padding: 10px;
            margin-top:15px;
            background-color: #EEEEEE;
            margin-bottom: 40px;
        }

        .tittel {
            margin-left:5px;
            font-size: 1.4em;
            font-weight: bold;
        }

    </style>
</head>

<body>


<div id="container">


    <div class="box">

        <div class="tittel">Administrer tall fra statistikk</div>

        <form method="post">

            <table class="rank">
                <tr>
                    <td width="30%">Gudfar:</td>
                    <td width="50%"><input type="text" placeholder="<?php echo $rank['gudfar']; ?>" name="gudfar"/></td>
                </tr>
                <tr style="background-color: #EEEEEE">
                    <td width="30%">Capo Crimini:</td>
                    <td width="50%"> <input type="text" placeholder="<?php echo $rank['capocrimini']; ?>" name="capocrimini"/></td>
                </tr>
                <tr>
                    <td width="30%">Capo de tutti Capi:</td>
                    <td width="50%"><input type="text" placeholder="<?php echo $rank['tutti']; ?>" name="tutti"/></td>
                </tr>
                <tr style="background-color: #EEEEEE">
                    <td width="40%"><input type="submit" name="save" value="Oppdater statistikk"></td>
                </tr>
            </table>

        </form>


    </div>
    <h2>Oversikt logg:
        <?php
            if($type=="" || "alle")
                echo "Alle";
        else if($type == "cronjob")
            echo "Cronjobs";
        else
            echo $type;
        ?>
        </h2>

    <form method="post">
        <select class="select-style" name="type" onchange="this.form.submit()">
            <option disabled selected>Velg logg</option>
            <option value="">Alle logger</option>
            <option value="cronjob">Cron Jobs</option>
            <option value="Login">Innlogginger</option>
            <option value="Hotelltid">Hotelltider</option>
        </select>
    </form>
    <table>
        <tr>
            <th>Type</th>
            <th>Status</th>
            <th>Melding</th>
            <th>Tid</th>
            <th>IP</th>
        </tr>


        <?php
        listLogs($type);
        ?>
    </table>

</div>
</body>
</html>
