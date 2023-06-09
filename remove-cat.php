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
        <h2 class="spacebelowabove">Overzicht van alle categorien zonder producten gekoppend aan een bestelling</h2>
        <?php
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("Select category.ID, category.name from category where category.ID NOT IN (SELECT category.ID
        FROM purchase
        INNER JOIN purchaseline ON purchase.ID = purchaseline.purchaseid
        INNER JOIN product ON purchaseline.productid = product.ID
        INNER JOIN category ON product.categoryid = category.ID
        WHERE purchase.delivered = 0)");

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
              <th>Category Naam</th>
              <th>verwijder</th>
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="remove-cat-script.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["name"] . "</td>";
            echo '<td> <input type="submit" name="delete" value="verwijder"></td>';

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="cat-id" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="cat-name" value="' . $data["name"] . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </main>
</body>

</html>
</body>

</html>