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
    include "nav.php";
    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle klanten</h2>
        <?php
        if (!isset($_SESSION["signedInAdmin"])) {
            require "scripts/forbidden.php";
        }
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT * FROM client");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>ID</th>
              <th>Voornaam</th>
              <th>Achternaam</th>
              <th>Email</th>
              <th>Adress</th>
              <th>Postcode</th>
              <th>Stad</th>
              <th>Staat</th>
              <th>Land</th>
              <th>Telefoon Nummer</th>";
        ;
        echo "</thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="" method="post">';
            echo "<tr>";
            echo "<td>" . $data["id"] . "</td>";
            echo "<td>" . $data["first_name"] . "</td>";
            echo "<td>" . $data["last_name"] . "</td>";
            echo "<td>" . $data["email"] . "</td>";
            echo "<td>" . $data["adress"] . "</td>";
            echo "<td>" . $data["zipcode"] . "</td>";
            echo "<td>" . $data["city"] . "</td>";
            echo "<td>" . $data["state"] . "</td>";
            echo "<td>" . $data["country"] . "</td>";
            echo "<td>" . $data["telephone"] . "</td>";
        }
        ?>
    </main>
</body>

</html>