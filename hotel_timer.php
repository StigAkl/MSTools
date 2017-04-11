<?php
    include_once ("controller/hotel_timer_controller.php");
    include_once ("controller/check_login_status.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MS Tools</title>
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
</head>
<body>

<div id="content hotel_timer_content">
    <?php echo $_GET['report']; ?>
    <div id="rapport_input">
        <form method="post">
            <textarea placeholder="Lim inn rapport" id="rapport" name="rapport"></textarea>
            <button class="add_button" type="submit" name="save_report" id="hotel_timer_button">Legg inn logg</button>
        </form>
    </div>

    <div id="boxes">

        <fieldset>
            <legend id="tittel">Hotelltider</legend>
        <div class="hotel_info" id="blink">

            <ul class="hotel_info_ul">
                <li><font style="font-weight: bold">Brukernavn:</font> No One</li>
                <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>
                <li><button class="delete_button">Slett</button> </li>
            </ul>

        </div>
        <div class="hotel_info">

            <ul class="hotel_info_ul">
                <li><font style="font-weight: bold">Brukernavn:</font> No One</li>
                <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>
                <li><button class="delete_button">Slett</button> </li>
            </ul>

        </div>
        <div class="hotel_info">

            <ul class="hotel_info_ul">
                <li><font style="font-weight: bold">Brukernavn:</font> No One</li>
                <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>
                <li><button class="delete_button">Slett</button> </li>
            </ul>

        </div>
        <div class="hotel_info">

            <ul class="hotel_info_ul">
                <li><font style="font-weight: bold">Brukernavn:</font> No One</li>
                <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>
                <li><button class="delete_button">Slett</button> </li>
            </ul>
        </div>

        <div class="bottom_margin"></div>
        </fieldset>
    </div>
</div>


<script type="text/javascript">

    document.getElementById("blink").style.borderWidth="2px";
    document.getElementById("blink").style.borderColor = "#e95f1b";
    setTimeout(function() {
        setInterval(function() {
            document.getElementById("blink").style.borderColor = "#a8290b";
            console.log("red")
        }, 1000);
    }, 500);

    setInterval(function() {
        document.getElementById("blink").style.borderColor = "#e95f1b";
        console.log("black");
    }, 2000);

</script>

</body>
</html>