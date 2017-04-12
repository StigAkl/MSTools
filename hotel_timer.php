<?php
include_once ("controller/check_login_status.php");
include_once ("controller/hotel_timer_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MS Tools</title>
    <link rel="stylesheet" type="text/css" href="design/css/default.css">
    <link rel="icon" href="design/img/spider.gif">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>
<body>

<?php
    if($_GET['private'] == "true")
        echo "<div id='private'>true</div>";
    else
        echo "<div id='private'>false</div>";
?>

<div id="headerTittel">
    Oversikt - Hotelltider
</div>

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

<!--            <div class="hotel_info blink"">-->
<!--            <ul class="hotel_info_ul">-->
<!--                <li><font style="font-weight: bold">Brukernavn:</font> No One</li>-->
<!--                <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>-->
<!--                <li><button class="delete_button">Slett</button> </li>-->
<!--            </ul>-->
<!---->
<!--    </div>-->
<!--    <div class="hotel_info blink">-->
<!---->
<!--        <ul class="hotel_info_ul">-->
<!--            <li><font style="font-weight: bold">Brukernavn:</font> No One</li>-->
<!--            <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>-->
<!--            <li><button class="delete_button">Slett</button> </li>-->
<!--        </ul>-->
<!---->
<!--    </div>-->
<!--    <div class="hotel_info">-->
<!---->
<!--        <ul class="hotel_info_ul">-->
<!--            <li><font style="font-weight: bold">Brukernavn:</font> No One</li>-->
<!--            <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>-->
<!--            <li><button class="delete_button">Slett</button> </li>-->
<!--        </ul>-->
<!---->
<!--    </div>-->
<!--    <div class="hotel_info">-->
<!---->
<!--        <ul class="hotel_info_ul">-->
<!--            <li><font style="font-weight: bold">Brukernavn:</font> No One</li>-->
<!--            <li><font style="font-weight: bold">Tid:</font> 4. April 21:52</li>-->
<!--            <li><button class="delete_button">Slett</button> </li>-->
<!--        </ul>-->
<!--    </div>-->

            <?php listLog(); ?>

    <div class="bottom_margin"></div>
    </fieldset>

        <p class="forklaring">Tid < 6 timer: Blinker rød / grønn</p>
        <br/>
        <p class="link"><a href="menu.php">Tilbake</a></p>
</div>

</div>


<script type="text/javascript">


    function removeTimer(username) {
        if(confirm("Er du sikker på at du vil slette loggen?")) {

            let xhttp = new XMLHttpRequest();
            let id=username;
            let private = document.getElementById("private").innerHTML;
            console.log("Private: " + private);
            console.log(id);
            xhttp.onreadystatechange = function(response) {
            if(this.readyState == 4 && this.status == 200) {
                    console.log("response: " + xhttp.responseText);
                    $( "#"+username ).fadeOut( "slow", function() {

                });

            }
            }

            xhttp.open("GET", "controller/hotel_timer_controller.php?remove="+username+"&private="+private, true);
            xhttp.send();
        }
    }

    var blink_divs = document.getElementsByClassName("blink");
    for(var i = 0; i < blink_divs.length; i++)
    {
        let element = blink_divs.item(i);
        element.style.borderWidth="2px";
        element.style.borderColor = "green";

        let color = true;
        setInterval(function() {
            if(color) {;
                element.style.borderColor = "red";
                color = !color;
            } else {
                element.style.borderColor = "green";
                color = !color;
            }
        }, 1000)
    }




</script>

</body>
</html>