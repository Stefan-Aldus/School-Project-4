<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log uit</title>
    <link rel="stylesheet" href="company.css">
</head>

<body>
    <!-- <header> -->
        <h1>Welkom bij de Bread Company</h1>
        <?php
        session_start();
        include "nav.php";
        ?>
        <h2>Hier kunt u uit loggen!</h2>
    <!-- </header> -->

    <form method="post" action="logoutUserScript-admin.php">
        <p>Wilt u echt uitloggen?</p>
        <input type="submit" value="Ja" name="logoutconfirm">
        <input type="submit" value="Nee" name="logoutcancel">
    </form>
</body>

</html>