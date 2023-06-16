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
        <h2 class="spacebelowabove">Overzicht producten bij de bestelling</h2>
        <?php
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT pl.ID, pl.purchaseid, pl.price, pl.quantity, p.productname
        FROM purchaseline pl
        JOIN product p ON pl.productid = p.ID
        WHERE purchaseid = :purchaseid;");
        $pid= $_POST["pid"];

        $query->execute([
            ":purchaseid" => $pid
        ]);
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>ID</th>
              <th>product naam</th>
              <th>hoeveelheid</th>
              <th>prijs per 1</th>
              ";


        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            $pid= $_POST["pid"];
            echo '<form action="change-order-script2.php" method="post">';
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["productname"] . "</td>";
            echo "<td>" . $data["quantity"] . "</td>";
            echo "<td>" . $data["price"] . "</td>";
            echo '<td> <input type="submit" name="submito" value="verwijder"></td>';

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="clientid" value="' . $data["ID"] . '">';
            echo '<input type="hidden" name="oldproductname" value="' . $data["productname"] . '">';
            echo '<input type="hidden" name="quantity" value="' . $data["quantity"] . '">';
            echo '<input type="hidden" name="email" value="' . $data["price"] . '">';
            echo '<input type="hidden" name="pid" value="' . $pid . '">';
            echo "</tr>";
            echo "</form>";
        }
        ?>

        <?php


if(isset($_POST["delete"])) {
    $_SESSION["oldproductname"] = $data["productname"];
    $_SESSION["pid"] = $pid;
     }
     ?>
    </main>
</body>
</html>
</body>
</html>