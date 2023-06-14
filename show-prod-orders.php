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
        header("Location: login.php ");
        exit();
    }
    require_once("dbconnect.php");
    
    include "nav.php";




    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle producten met bestelingen</h2>
        <?php
// Verbinding maken met de database


// Query om alle producten met bestellingen op te halen
$query = $db->prepare("SELECT p.productname, pl.price, pl.quantity, c.first_name, c.last_name, pu.purchasedate
FROM product AS p
JOIN purchaseline AS pl ON p.ID = pl.productid
JOIN purchase AS pu ON pl.purchaseid = pu.ID
JOIN client AS c ON pu.clientid = c.ID
ORDER BY p.productname ASC;");

$query2 = $db->prepare("SELECT * FROM `product` ");
$query->execute();
$query2->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

// If there are no results, display an error message
if ($query->rowCount() == 0) {
    echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
    die();
}

// echo's the product name
foreach ($result2 as $row2) {
    echo "<table class='tableformat'>";
    echo "<tr><th>Naam product</th><th>Prijs</th><th>Aantal</th><th>Klant</th><th>Besteldatum</th></tr>";
    echo "<tr>";
    echo "<th>" . $row2['productname'] . "</th>";
    echo "</tr>";

    // echo's for reach the result of my first query
    foreach ($result as $row) {
        // Check if the product name matches the product name from the for each loop above
        if ($row['productname'] == $row2['productname']) {
            $price = $row['price'] * $row['quantity'];
            echo "<tr>";
            echo "<td>" . $row['productname'] . "</td>";
            echo "<td> $" . $price . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . $row['purchasedate'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}
        ?>
    </main>
</body>

</html>