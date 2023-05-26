<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="company.css">
</head>

<body>
    <?php
    session_start();
    // Checkt of de gebruiker op de juiste manier op de pagina is gekomen, zoniet laat zien dat ze geen toegang hebben tot de pagina
    if (!isset($_POST["registersubmit"]) && !isset($_POST["registerconfirm"])) {
        require("scripts/forbidden.php");
    }
    // Checkt of de gebruiker heeft gecancelled
    if (isset($_POST["registercancel"])) {
        header("Location: register.php");
    }
    ?>
    <header>
        <?php include 'nav.php' ?>
        <h1>Welkom bij de Bread Company</h1>
        <h2>Hier kunt u Registreren!</h2>
        <p>Kloppen de volgende gegevens?</p>
    </header>

    <form method="POST" action="registerscript.php">
        <div>
            <label for="email">Uw email:</label>
            <input readonly value="<?php echo $_POST["email"] ?>" type="email" name="email" id="email">
        </div>
        <div>
            <label for="email">Uw voornaam:</label>
            <input readonly value="<?php echo $_POST["fname"] ?>" type="text" name="fname" id="fname">
        </div>
        <div>
            <label for="email">Uw achternaam:</label>
            <input readonly value="<?php echo $_POST["lname"] ?>" type="text" name="lname" id="lname">
        </div>
        <div>
            <label for="email">Uw adres:</label>
            <input readonly value="<?php echo $_POST["adress"] ?>" type="text" name="adress" id="adress">
        </div>
        <div>
            <label for="email">Uw postcode:</label>
            <input readonly value="<?php echo $_POST["zipcode"] ?>" type="text" name="zipcode" id="zipcode">
        </div>
        <div>
            <label for="email">Uw stad:</label>
            <input readonly value="<?php echo $_POST["city"] ?>" type="text" name="city" id="city">
        </div>
        <div>
            <label for="email">Uw provincie:</label>
            <input readonly value="<?php echo $_POST["state"] ?>" type="text" name="state" id="state">
        </div>
        <div>
            <label for="email">Uw land:</label>
            <input readonly value="<?php echo $_POST["country"] ?>" type="text" name="country" id="country">
        </div>
        <div>
            <label for="email">Uw telefoonnummer:</label>
            <input readonly value="<?php echo $_POST["phonenr"] ?>" type="text" name="phonenr" id="phonenr">
        </div>
        <div>
            <label for="email">Uw wachtwoord:</label>
            <input hidden readonly value="<?php echo $_POST["pw"] ?>" type="password" name="pw" id="pw">
        </div>
        <div>
            <label for="email">Herhaal uw wachtwoord hier in:</label>
            <input hidden readonly value="<?php echo $_POST["pw2"] ?>" type="password" name="pw2" id="pw2">
        </div>
        <div>
            <input type="submit" name="registerconfirm" id="registerconfirm" value="Deze gegevens kloppen">
            <input type="submit" name="registercancel" id="registercancel" value="Deze gegevens kloppen niet">
        </div>
    </form>

    <?php
    function sanitizeInput($value)
    {
        // Sanitize user input
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    // Check if the confirmation is pressed
    if (isset($_POST["registerconfirm"])) {
        // Database connection
        require_once "dbconnect.php";

        try {
            $query = $db->prepare("SELECT count(*) FROM client where email = :email");
            $query->bindValue(":email", $_POST["email"]);
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $results = $query->fetch();

        if ($results >= 1) {
            echo 'Account bestaat al';
            sleep(5);
            header("Location: register.php");
            exit();
        }


        // Sanitize user inputs
        $fname = sanitizeInput($_POST["fname"]);
        $lname = sanitizeInput($_POST["lname"]);
        $email = sanitizeInput($_POST["email"]);
        $adress = sanitizeInput($_POST["adress"]);
        $zipcode = sanitizeInput($_POST["zipcode"]);
        $city = sanitizeInput($_POST["city"]);
        $state = sanitizeInput($_POST["state"]);
        $country = sanitizeInput($_POST["country"]);
        $telephone = sanitizeInput($_POST["phonenr"]);
        // Check if the entered passwords match; if not, terminate the program
        if ($_POST["pw"] != $_POST["pw2"]) {
            echo "<p>WACHTWOORDEN KOMEN NIET OVEREEN</p>";
            echo "<p><a href='register.php'>Keer terug naar registerpagina</a></p>";
            die();
        } else {
            // Hash the password using BCRYPT
            $hashedpassword = password_hash($_POST["pw"], PASSWORD_BCRYPT);
            try {
                // Prepare the insert statement
                $createuser = $db->prepare("INSERT INTO 
                client 
                (first_name, last_name, email, adress, zipcode, city, state, country, telephone, password) 
                VALUES     
                (:fname, :lname, :email, :adress, :zipcode, :city, :state, :country, :telephone, :password)");

                // Bind the parameters
                $createuser->bindParam(":fname", $fname);
                $createuser->bindParam(":lname", $lname);
                $createuser->bindParam(":email", $email);
                $createuser->bindParam(":adress", $adress);
                $createuser->bindParam(":zipcode", $zipcode);
                $createuser->bindParam(":city", $city);
                $createuser->bindParam(":state", $state);
                $createuser->bindParam(":country", $country);
                $createuser->bindParam(":telephone", $telephone);
                $createuser->bindParam(":password", $hashedpassword);

                // Execute the insert statement
                $createuser->execute();

                // Redirect to login.php with a success message
                header_remove();
                header("Location: login.php?message=success");
                exit();

                // Handle any potential errors
            } catch (PDOException $e) {
                die("<p>Error met maken van account, de server gaf als error code: " . $e->getCode() . ", neem contact op met een systeembeheerder om het probleem te verhelpen.</p>");
            }
        }
    }
    ?>
</body>

</html>