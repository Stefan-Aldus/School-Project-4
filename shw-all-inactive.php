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
        header("Location: login-admin.php ");
        exit();
    }
    include "nav.php";




    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van inactieve producten</h2>
        <?php
        // if (!isset($_SESSION["signedInCustomer"])) {
        //     echo 'Je moet ingelogd zijn om te bestellen! <br>';
        // }
        // Verbinding maken met de database 
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT product.*, category.name AS Category, supplier.company AS Supplier FROM product 
        INNER JOIN category ON category.id = product.categoryid 
        INNER JOIN supplier ON product.supplierid = supplier.id
        WHERE isinactive = 1;");
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
              <th>Product naam</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Prijs per product</th>";
        echo "<th>Inactief</th> </thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo "<tr>";
            echo "<td>" . $data["ID"] . "</td>";
            echo "<td>" . $data["productname"] . "</td>";
            echo "<td>" . $data["Category"] . "</td>";
            echo "<td>" . $data["Supplier"] . "</td>";
            echo "<td> € " . $data["price"] . "</td>";
            echo "<td>" . "inactief" . "</td>";
            echo "</tr>";
        }





        // Debugging: you can display the stored values
        // echo "Added purchase made: " . $productName . ", Category: " . $category . ", Supplier: " . $supplier . " , Hoeveelheid: " . $number . "   id: " . $id;
        ?>
    </main>
</body>

</html>