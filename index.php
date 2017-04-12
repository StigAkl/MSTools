<?php
include_once ("controller/login_controller.php");

$error = "";
if($_GET["error"] == "wrongpw") {
    $error = "<font color='red'>Feil passord</font>";
}

if($_GET["error"] == "login") {
    $error = "<font color='red'>Krever innlogging!</font>";
}

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
    body {
        background-color: #f0f0f2;
        margin: 0;
        padding: 0;
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-color: #222;
        
    }

    #login {
        margin: 0px auto; 
        width: 200px; 
        height: 100px; 
        margin-top: 250px;  
        padding: 5px;
        padding-left: 0px;
    }

    input[type=text] {
    padding: 5px;
    border:2px solid #ccc; 
    -webkit-border-radius: 5px;
    border-radius: 5px;
    width: 190px; 
}

input[type=text]:focus {
    border-color:#333;
}

    input[type=password] {
        padding: 5px;
        border:2px solid #ccc;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        width: 190px;
    }

    input[type=password]:focus {
        border-color:#333;
    }


input[type=submit] {
    width: 100%; 
    height: 40px; 
    background:#ccc; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
    padding:5px; 
    margin: 0px auto;
}




    </style>
</head>

<body>

<div id="login">
<form method="post">
<p>Passord: <input autocomplete="off" type="password" name="password" /> </p>
<input type="submit" name="login" value="Logg inn"  />

</form>
    <p>
<?php echo $error ?>
    </p>
</div>

</body>
</html>
