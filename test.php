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
    if (!isset($_SESSION["signedInCustomer"]) && !isset($_SESSION["signedInAdmin"])) {
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
        $result2 = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }



    // Het overzicht van producten met bestellingen weergeven
    foreach ($result2 as $row2) {
        echo "<table class='tableformat'>";
        echo "<tr><th>Naam product</th><th>Prijs</th><th>Aantal</th><th>Klant</th><th>Besteldatum</th></tr>";
        echo "<tr>";
        echo "<th>".$row2['productname']."</th>";
        echo "</tr>";

        if ($row['productname'] == $row2['productname']) {
            foreach ($result as $row) {
                $price =  $row['price']  *  $row['quantity'];
                echo "<tr>";
                echo "<td>".$row['productname']."</td>";
                echo "<td> $".$price."</td>";
                echo "<td>".$row['quantity']."</td>";
                echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                echo "<td>".$row['purchasedate']."</td>";
                echo "</tr>";
                
            }
            echo "</table>";
        }
    }
    
   
    


// Verbinding sluiten


        // Debugging: you can display the stored values
        // echo "Added purchase made: " . $productName . ", Category: " . $category . ", Supplier: " . $supplier . " , Hoeveelheid: " . $number . "   id: " . $id;
        ?>
    </main>
</body>

</html>