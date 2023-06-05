<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="company.css">
</head>

<body>
    <?php
    session_start();
    include "nav.php";

    require_once "dbconnect.php";

    try {
        $query1 = $db->prepare("SELECT category.ID, category.name
        FROM category
        LEFT JOIN product ON category.ID = product.categoryid
        LEFT JOIN purchaseline ON product.ID = purchaseline.productid
        LEFT JOIN purchase ON purchaseline.purchaseid = purchase.ID
        WHERE purchase.delivered = 0 OR purchase.delivered IS NULL
        GROUP BY category.ID
        HAVING COUNT(purchaseline.ID) = 0;");
        $query1->execute();
        $result1 = $query1->fetchAll();
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    $amount = count($result1);
    if ($amount <= 0) {
        echo "<p>GEEN CATEGORIEN DIE VERWIJDERD KUNNEN WORDEN</p>";
        die();
    }
    ?>

    <h1>Welkom bij de Bread Company</h1>
    <h2>Hier staan alle categorieën zonder actieve bestellingen!</h2>

    <form method="post" action="remove-category-script.php">
        <table class="tableformat">
            <thead>
                <th>Category ID</th>
                <th>Category Naam</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($result1 as $cat) { ?>
                    <tr>
                        <td>
                            <?php echo $cat["ID"]; ?>
                        </td>
                        <td>
                            <?php echo $cat["name"]; ?>
                        </td>
                        <td>
                            <input type="hidden" name="catid" value="<?php echo $cat["ID"]; ?>">
                            <input type="hidden" name="catname" value="<?php echo $cat["name"]; ?>">
                            <input type="submit" name="remove-cat" value="Verwijderen">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</body>

</html>