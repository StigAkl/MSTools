<?php session_start();
include_once("controller/add_controller.php");
include_once("controller/CookieController.php");
require ("controller/check_login_status.php");
$error = "";
$added = "";

$rank_1_selected = getRankCookie("Gudfar");
$rank_2_selected = getRankCookie("Capo Crimini");
$rank_3_selected = getRankCookie("Tutti");

$rank_cookie = $_COOKIE['RankCookie'];

$sortering = $_COOKIE['sortering'];

if(empty($_COOKIE['sortering'])) {
    $sortering = "alle";
}

if($_GET['error'] == "invalid")
    $error = "Ugyldig navn";

if($_GET['error'] == "empty")
    $error = "Velg rank!";

if(!empty($_GET['added']))
    $added = $_GET['added'] . " har blitt lagt til i listen!";

if(!empty($_GET['edited']))
    $added = $_GET['edited'] . " har blitt endret!";

if(!empty($_GET['removed']))
    $added = $_GET['removed'] . " har blitt fjernet fra listen!";
?>
<!doctype html>
<html>
<head>
    <title>MS Tools</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="design/img/spider.gif">
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

        #header {
            margin-top: 0px;
            width: 100%;
            height: 155px;
            background-color: #3D3D3D;
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

        form#form1 {
            margin: 0px auto;
            width: 312px;
        }

        /* SELECT */

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
        .select-margin {
            margin-right: 8px;
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

        #error {
            color: red;
            text-align: center;
        }

        #added {
            color: seagreen;
            text-align: center;
            margin-top: 5px;
        }

        /* TABLE */

        table{
            margin: 0px auto;
            font-size:16px;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 30%;
            margin-bottom: 40px;
        }

        td, th {
            border: 1px solid #ddd;
            text-align: center;
            padding: 4px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            padding-top: 11px;
            padding-bottom: 11px;
            background-color: #3D3D3D;
            color: white;
        }

        .title {
            width: 30%;
            margin: 0px auto;
        }

        .table-margin {
            margin-top: 15px;
        }

        /* NAVIGATION */

        ul {
            list-style-type: none;
            margin: 0;
            padding: none;
            width: 500px;
        }

        li {
            float: left;
            margin: 0px auto;
            margin-right: 30px;
        }

        li a {
             display: inline;
             color: #666;
             text-decoration: underline;
         }

        a {
            display: inline;
            color: #666;
            text-decoration: underline;
        }

        .nav {
            width: 30%;
            margin: 0px auto;
            margin-top: 10px;
            margin-bottom:10px;
            padding: 20px;
        }

        .link {
            width: 200px;
            position: relative;
            z-index: 1;
            top: 30px;
            left:25%;

        }


    </style>

    <script type="text/javascript">

        function remove1(username) {
            console.log(username);
           let svar = confirm("Er du sikker på at du vil slette " + username + "?");
            if(svar) {
                window.location = "add.php?remove="+username;
            }
        }

        function remove2(username) {
            if(confirm("Er du sikker på at du vil slette " + username + "?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let tr = document.getElementById(username);
                        tr.parentNode.removeChild(tr);
                        document.getElementById("added").innerHTML = username + " har blitt slettet.";
                    }
                };
                xhttp.open("GET", "add.php?remove=" + username, true);
                xhttp.send();
            }
        }
    </script>
</head>

<body>

<div id="header">

    <form method="post" id="form1">
        <input type="text" placeholder="Brukernavn" autocomplete="off" name="username" />


        <div class="select-style select-margin">
            <select name="rank">
                <option value="" disabled>Rank</option>
                <option value="Gudfar" <?php echo $rank_1_selected; ?>>Gudfar</option>
                <option value="Capo Crimini" <?php echo $rank_2_selected; ?>>Capo Crimini</option>
                <option value="Tutti"  <?php echo $rank_3_selected; ?>>Tutti</option>
            </select>
        </div>


        <div class="select-style">
            <select name="noob">
                <option value="" disabled selected>Noob-faktor</option>
                <option value="0">Vet ikke</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>

        <input type="submit" name="add" autocomplete="off" value="Legg til"/>
        <?php echo "<p id='error'> $error .</p>"; ?>
    </form>


    <div class="link"><a href="menu.php">Tilbake (Meny)</a></div>

</div>
<p id="added"> <?php echo $added; ?></p>


<div class="nav">
<ul>
    <li><a href="set_sortering.php?sortering=gudfar"><span id="gudfarlink">Vis bare Gudfar</span></a></li>
    <li id="cclink"><a href="set_sortering.php?sortering=cc">Vis bare CC</a></li>
    <li id="tuttilink"><a href="set_sortering.php?sortering=tutti">Vis bare Tutti</a></li>
    <li id="allelink"><a href="set_sortering.php?sortering=alle">Vis alle</a></li>
</ul>

</div>
<div class="table-margin"></div>
<div class="table-margin"></div>


<?php if($sortering == "Gudfar" || $sortering == "alle") { ?>
<div class='title'>Gudfar <?php echo countUsers("Gudfar"); ?> / 72</div>
<?php listUsers("Gudfar"); }?>


<div class="table-margin"></div>

<?php if($sortering == "Capo Crimini" || $sortering == "alle") { ?>
<div class='title'>Capo Crimini <?php echo countUsers("Capo Crimini"); ?> / 58</div>
<?php listUsers("Capo Crimini"); }?>

<div class="table-margin"></div>

<?php if($sortering == "Tutti" || $sortering == "alle") { ?>
<div class='title'>Tutti <?php echo countUsers("Tutti"); ?> / 35</div>
<?php listUsers("Tutti"); }?>

<script type="text/javascript">

    let boldLink = "<?php echo $sortering; ?>"

    if(boldLink === "Gudfar")
        document.getElementById("gudfarlink").style.fontWeight="bold";
    else if(boldLink === "Capo Crimini")
        document.getElementById("cclink").style.fontWeight="bold";
    else if(boldLink === "Tutti")
        document.getElementById("tuttilink").style.fontWeight="bold";
    else
        document.getElementById("allelink").style.fontWeight="bold";

</script>
</body>
</html>
