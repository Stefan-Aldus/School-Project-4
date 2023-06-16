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
        $query = $db->prepare("SELECT client.*, purchase.*
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
              <th>Purchase ID</th>
              <th>Customer ID</th>
              <th>Purchase ID</th>
              <th>Delivered</th>
              <th>Verwijder</th>
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="remove-order-script.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["clientid"] . "</td>";
            echo "<td>" . $data["purchasedate"] . "</td>";
            echo "<td>" . $data["delivered"] . "</td>";
            echo '<td> <input type="submit" name="delete" value="verwijder"></td>';

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="clientid" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="client-f-name" value="' . $data["clientid"] . '">';
            echo '<input type="hidden" name="client-l-name" value="' . $data["purchasedate"] . '">';
            echo '<input type="hidden" name="email" value="' . $data["delivered"] . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </main>
</body>

</html>
</body>

</html>