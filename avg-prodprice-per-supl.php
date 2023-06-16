<!DOCTYPE html>
<html>

<head>
    <title>Leveranciersoverzicht</title>
    <link rel="stylesheet" type="text/css" href="company.css">
</head>

<body>
    <?php
    if (!isset($_SESSION["signedInAdmin"])) {
        header("Location: login-admin.php");
        die("U moet admin zijn voor deze pagina.");
    }
    include "nav.php" ?>
    <h1>Leveranciersoverzicht</h1>

    <table class="tableformat">
        <tr>
            <th>Leverancier</th>
            <th>Gemiddelde prijs</th>
        </tr>
        <?php
        // Inclusie van de databaseverbinding
        include 'dbconnect.php';

        // Query maken ene executre
        try {
            $query = $db->prepare("SELECT supplier.company, AVG(product.price) AS avgprice
            FROM supplier 
            INNER JOIN product  ON supplier.ID = product.supplierid
            WHERE product.isinactive = 0
            GROUP BY supplier.ID");
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $query->execute();
        $results = $query->fetchAll();

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row["company"] . "</td>";
            echo "<td>" . $row["avgprice"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>