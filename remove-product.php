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
        <h2 class="spacebelowabove">Overzicht van alle producten zonder active bestelling</h2>
        <?php
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT *
        FROM product
        WHERE ID NOT IN (
            SELECT DISTINCT productid
            FROM purchaseline pl
            INNER JOIN purchase pu ON pl.purchaseid = pu.ID
            WHERE pu.delivered = 0
        );");

        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>Product naam</th>
              
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="remove-product-script.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["productname"] . "</td>";
            echo '<td> <input type="submit" name="delete" value="verwijder"></td>';

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="productname" value="' . $data["productname"] . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </main>
</body>

</html>
</body>

</html>