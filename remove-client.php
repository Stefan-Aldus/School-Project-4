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
    if (!isset($_SESSION["signedInAdmin"])) {
        header_remove();
        header("Location: index.php ");
        header("Location: login.php ");
        exit();
    }
    include "nav.php";
    
    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle klanten zonder bestelling</h2>
        <?php
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT client.*
FROM client
LEFT JOIN purchase ON client.ID = purchase.clientid
WHERE purchase.clientid IS NULL OR client.ID IN (
  SELECT purchase.clientid
  FROM purchase
  WHERE purchase.delivered = 1
)
AND client.ID NOT IN (
  SELECT purchase.clientid
  FROM purchase
  WHERE purchase.delivered = 0
)");

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
              <th>voornaam</th>
              <th>achternaam</th>
              <th>email</th>
              <th>adress</th>
              <th>zipcode</th>
              <th>stad</th>
              <th>provincy</th>
              <th>land</th>
              <th>nummer</th>
              <th>isadmin</th>
              <th>verwijder</th>
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="remove-client-script.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["id"] . "</td>";
            echo "<td>" . $data["first_name"] . "</td>";
            echo "<td>" . $data["last_name"] . "</td>";
            echo "<td>" . $data["email"] . "</td>";
            echo "<td>  " . $data["adress"] . "</td>";
            echo "<td> " . $data["zipcode"] . "</td>";
            echo "<td> " . $data["city"] . "</td>";
            echo "<td>  " . $data["country"] . "</td>";
            echo "<td>  " . $data["state"] . "</td>";
            echo "<td>  " . $data["telephone"] . "</td>";
            echo "<td>  " . $data["isadmin"] . "</td>";
            echo '<td> <input type="submit" name="delete" value="verwijder"></td>';

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="clientid" value="' . $data["id"] . '">';
            echo '<input type="hidden" name="client-f-name" value="' . $data["first_name"] . '">';
            echo '<input type="hidden" name="client-l-name" value="' . $data["last_name"] . '">';
            echo '<input type="hidden" name="email" value="' . $data["email"] . '">';
            echo '<input type="hidden" name="adress" value="' . $data["adress"] . '">';
            echo '<input type="hidden" name="zipcode" value="' . $data["zipcode"] . '">';
            echo '<input type="hidden" name="city" value="' . $data["city"] . '">';
            echo '<input type="hidden" name="country" value="' . $data["country"] . '">';
            echo '<input type="hidden" name="state" value="' . $data["state"] . '">';
            echo '<input type="hidden" name="telephone" value="' . $data["telephone"] . '">';
            echo '<input type="hidden" name="isadmin" value="' . $data["isadmin"] . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </main>
</body>
</html>
</body>
</html>