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
            background-color: #f0f0f2;
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
            width: 300px;
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

    </style>
</head>

<body>


<div id="container">
    <h2>Oversikt logg:
        <?php
            if($type=="")
                echo "Alle";
        else if($type == "cronjob")
            echo "Cronjobs";
        else
            echo $type;
        ?>
        </h2>

    <form method="post">
        <select class="select-style" name="type" onchange="this.form.submit()">
            <option value="alle">Alle logger</option>
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
