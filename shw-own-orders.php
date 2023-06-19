<!DOCTYPE html>
<html>

<head>
    <title>Overzicht Bestellingen</title>
    <link rel="stylesheet" href="company.css">
</head>

<body>
    <?php
    // Controleren of de klant is ingelogd
    session_start();
    if (!isset($_SESSION['signedInCustomer'])) {
        echo "Deze functie is alleen toegankelijk voor ingelogde klanten.";
        // Redirect
        echo '<script>setTimeout(function() { window.location.replace("add-country01.php"); }, 5000);</script>';
        exit;
    }
    include 'nav.php';
    ?>
    <!-- <header>
        <h1>Overzicht Bestellingen</h1>
    </header> -->
    <h1>Overzicht Van Uw Bestellingen</h1>
    <?php

    // Verbinding maken met de database
    require_once 'dbconnect.php';



    // Klantnummer ophalen van ingelogde klant
    $signedInCustomer = $_SESSION['signedInCustomer'];

    // Query opstellen om bestellingen en bijbehorende gegevens op te halen
    $query = "SELECT p.ID AS purchaseid, p.purchasedate, pr.productname, c.name AS categoryname, pl.quantity, pl.price
          FROM purchase AS p
          INNER JOIN purchaseline AS pl ON p.ID = pl.purchaseid
          INNER JOIN product AS pr ON pl.productid = pr.ID
          INNER JOIN category AS c ON pr.categoryid = c.ID
          WHERE p.clientid = :signedInCustomer
          ORDER BY p.purchasedate DESC";

    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':signedInCustomer', $signedInCustomer);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Fout bij het ophalen van gegevens: " . $e->getMessage();
        exit;
    }

    // Controleren of er bestellingen zijn gevonden
    if (count($result) > 0) {
        echo '<table class="tableformat">';
        echo "<tr><th>Purchase ID</th><th>Purchase Datum</th><th>Productnaam</th><th>Categorienaam</th><th>Hoeveelheid</th><th>Prijs</th></tr>";

        // Variabeel om de vorige purchase ID bij te houden
        $vorigePurchaseID = null;

        foreach ($result as $row) {
            $purchaseID = $row['purchaseid'];
            $purchaseDate = $row['purchasedate'];
            $productName = $row['productname'];
            $categoryName = $row['categoryname'];
            $quantity = $row['quantity'];
            $price = $row['price'];

            // Alleen de purchase ID en purchase datum tonen als het de eerste rij is of als de purchase ID verandert
            if ($vorigePurchaseID !== $purchaseID) {
                echo "<tr><td>$purchaseID</td><td>$purchaseDate</td>";
            } else {
                echo "<tr><td></td><td></td>";
            }

            echo "<td>$productName</td><td>$categoryName</td><td>$quantity</td><td>$price</td></tr>";

            $vorigePurchaseID = $purchaseID;
        }

        echo "</table>";
    } else {
        echo "Geen bestellingen gevonden.";
    }

    // Verbinding verbreken
    $db = null;

    ?>


</body>

</html>