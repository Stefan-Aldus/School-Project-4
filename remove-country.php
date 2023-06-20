<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="company.css">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    // check if you canceled your action and if so it will redirect you back
    if (isset($_POST["denie"])) {
        header_remove();
        header("Location: shw-all-country.php ");
    }
    if (!isset($_SESSION["signedInAdmin"])) {
        header_remove();
        header("Location: login.php ");
        exit();
    }
    require_once("dbconnect.php");
    include "nav.php";
    

    ?>

    <main>
        <form action="remove-country-script.php" method="post">
            <h3>verwijder land</h3>
            <div>
                <label for="klant">id:</label>
                <input type="text" id="klant" name="cid" readonly value="<?php echo $_POST["cid"] ?>" />
            </div>
            <div>
                <label for="klant">Naam:</label>
                <input type="text" id="klant" name="cname" readonly
                    value="<?php echo $_POST["cname"] ?>" />
            </div>
            <div>
                <label for="klant">Code</label>
                <input type="text" id="klant" name="ccode" readonly value="<?php echo $_POST["ccode"] ?>" />
                
            </div>
            <input type="submit" name="confirm" id="submit" value="weet u zeker dat het klopt?">
            <input type="submit" name="denie" id="submit" value="nee het klopt niet!">
        </form>
    </main>
</body>

</html>