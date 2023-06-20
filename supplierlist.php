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
    // if (!isset($_SESSION["signedInAdmin"])) {
    //     header_remove();
    //     header("Location: index.php ");
    //     header("Location: login.php ");
    //     exit();
    // }
    include "nav.php";

    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle klanten zonder bestelling</h2>
        <?php
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT product.*, supplier.*
        FROM product
        INNER JOIN supplier ON product.supplierid = supplier.ID");

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
              <th>Naam  </th>
              <th>Prijs</th>
              <th>Soort</th>
              <th>Bedrijf</th>
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="remove-order-script.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["productname"] . "</td>";
            echo "<td>" . $data["price"] . "</td>";
            echo "<td>" . $data["categoryid"] . "</td>";
            echo "<td>" . $data["supplierid"] . "</td>";

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="clientid" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="client-f-name" value="' . $data["productname"] . '">';
            echo '<input type="hidden" name="client-l-name" value="' . $data["price"] . '">';
            echo '<input type="hidden" name="email" value="' . $data["company"] . '">';
            // echo '<input type="hidden" name="email" value="' . $data["quantity"] . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </main>
</body>

</html>
</body>

</html>