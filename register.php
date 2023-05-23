<!-- Fuck berkhout -->

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
    <header>
        <h1>Welkom bij de Bread Company</h1>
        <?php
        session_start();
        include "nav.html";
        ?>
        <h2>Hier kunt u Registreren!</h2>
    </header>
    <form method="POST" action="registerscript.php">
        <div>
            <label for="email">Voer uw email hier in:</label>
            <input required type="email" name="email" id="email">
        </div>
        <div>
            <label for="email">Voer uw voornaam hier in:</label>
            <input required type="text" name="fname" id="fname">
        </div>
        <div>
            <label for="email">Voer uw achternaam hier in:</label>
            <input required type="text" name="lname" id="lname">
        </div>
        <div>
            <label for="email">Voer uw adress hier in:</label>
            <input required type="text" name="adress" id="adress">
        </div>
        <div>
            <label for="email">Voer uw postcode hier in:</label>
            <input required type="text" name="zipcode" id="zipcode">
        </div>
        <div>
            <label for="email">Voer uw stad hier in:</label>
            <input required type="text" name="city" id="city">
        </div>
        <div>
            <label for="email">Voer uw provincie hier in:</label>
            <input required type="text" name="state" id="state">
        </div>
        <div>
            <label for="email">Voer uw land hier in:</label>
            <input required type="text" name="country" id="country">
        </div>
        <div>
            <label for="email">Voer uw telefoon nr hier in:</label>
            <input required type="text" name="phonenr" id="phonenr">
        </div>
        <div>
            <label for="email">Voer uw wachtwoord hier in:</label>
            <input required type="password" name="pw" id="pw">
        </div>
        <div>
            <label for="email">Herhaal uw wachtwoord hier in:</label>
            <input required type="password" name="pw2" id="pw2">
        </div>
        <div>
            <input type="submit" name="registersubmit" id="registersubmit" value="Registreren">
        </div>
    </form>
</body>

</html>