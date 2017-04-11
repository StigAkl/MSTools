<?php include_once ("controller/access/db_connect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>MS Tools</title>
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <script src="js/script.js"></script>

    <style>

        input[type=submit] {
            padding:5px 15px;
            background:#ccc;
            width: 200px;
            height: 80px;
            border:0 none;
            cursor:pointer;
            -webkit-border-radius: 5px;
            border-radius: 5px;
        }

        #submit {
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>
<body>



<p>

    <?php

    $countGudfar = 0;
    $countCc = 0;
    $countTutti = 0;
    $count = 0;

   function get_hendelse_logg()
    {
        $handle = fopen("files/alle_hendelser.txt", "r");
        $gudfar = array();
        $cc = array();
        $tutti = array();


        if ($handle) {
            while (($line = fgets($handle)) !== false) {


                if (strpos($line, "opp i rank") !== false && strpos($line, "Gudfar") !== false) {
                    $substring = trim(strtolower(substr($line, 0, strpos($line, 'Gudfar') - 25)));
                    array_push($gudfar, $substring);
                    $countGudfar++;
                    $count++;
                }

                if (strpos($line, "opp i rank") !== false && strpos($line, "Capo Crimini") !== false) {
                    $substring = trim(strtolower(substr($line, 0, strpos($line, 'Capo Crimini') - 25)));
                    array_push($cc, $substring);
                    $countCc++;
                    $count++;
                }

                if (strpos($line, "opp i rank") !== false && strpos($line, "Capo de tutti Capi") !== false) {
                    $substring = trim(strtolower(substr($line, 0, strpos($line, 'Capo de tutti Capi') - 25)));
                    array_push($tutti, $substring);
                    $countTutti++;
                    $count++;
                }
            }

            fclose($handle);
        } else {
            echo "Feil ved åpning av fil!";
        }


        //Filtrer ut døde brukere
        $handle = fopen("files/alle_hendelser.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, "blir skutt og drept i") !== false) {
                    $substring = trim(strtolower(substr($line, 0, strpos($line, 'blir skutt og drept'))));

                    if (($key = array_search($substring, $gudfar)) !== false) {
                        unset($gudfar[$key]);
                        $countGudfar--;
                    }

                    if (($key = array_search($substring, $cc)) !== false) {
                        unset($cc[$key]);
                        $countCc--;
                    }

                    if (($key = array_search($substring, $tutti)) !== false) {
                        unset($tutti[$key]);
                        $countTutti--;
                    }
                }
            }
            fclose($handle);
        } else {
            echo "Feil ved åpning av fil!";
        }


        //Filtrer CC fra Gudfar, Tutti fra CC
        foreach ($cc as $crimini) {
            if (($key = array_search($crimini, $gudfar)) !== false) {
                unset($gudfar[$key]);
                $countGudfar--;
            }
        }


        foreach ($tutti as $tt) {
            if (($key = array_search($tt, $cc)) !== false) {
                unset($cc[$key]);
                $countCc--;
            }
        }

        $connection = Db::getInstance();
        foreach($gudfar as $gf) {
            add_to_database(htmlspecialchars($gf), "Gudfar", $connection);
        }
        
        foreach($cc as $crimini) {
            add_to_database(htmlspecialchars($crimini), "Capo Crimini", $connection);
        }

       // deleteUsers();

        //Add new users
        foreach($tutti as $tuttii) {
            add_to_database(htmlspecialchars($tuttii), "Tutti", $connection);
        }
    }


    function add_to_database($username, $rank, $connection) {
        $noob = 0;
        $sql = "INSERT INTO Users(username, rank, noobfaktor) VALUES ('$username', '$rank', '$noob')";
        $connection->exec($sql);
    }

    function deleteUsers() {
       $connection = Db::getInstance();
        $sql = "DELETE FROM Users";
        $connection->exec($sql);
    }


    if(isset($_POST["update"])) {
        get_hendelse_logg();
    }

    ?>
</p>


<form method="post">
    <div id="submit"><input type="submit" name="update" value="Oppdater logg"/></div>
</form>
</body>
</html>