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
    <header>
        <?php


        session_start();
        // check if you canceled your action and if so it will redirect you back
        if (isset($_POST["denie"])) {
            header_remove();
            header("Location: add-product01.php ");
        }

        // checks if user is signed in as a Admin, if not it will redirect you to the login page
        if (!isset($_SESSION["signedInAdmin"]) && !isset($_SESSION["signedInCustomer"])) {
            header_remove();
            header("Location: index.php ");
            exit();
        }


        require_once("dbconnect.php");
        include "nav.php";
        ?>
    </header>

    <main>

        <table class='tableformat'>
            <thead>
                <th>Catogory</th>
                <th>AVG Price</th>
            </thead>
            <tbody>

                <?php
                //Grabs all the categories
                $allCats = $db->prepare("SELECT * from category");
                $allCats->execute();
                $catNames = $allCats->fetchAll();
                //Does the math and echos the average price per category
                foreach ($catNames as $catName) {
                    $avgprc = $db->prepare("SELECT AVG(price) FROM product WHERE categoryid = :catid");
                    $avgprc->execute([":catid" => $catName["ID"]]);
                    $catavg = $avgprc->fetch();
                    $roundcatavg = round($catavg[0], 2);
                    if ($catavg > 0) {
                        echo "<tr>";
                        echo "<td>" . $catName["name"] . "</td>";
                        echo "<td>$" . $roundcatavg . "</td>";
                        echo "</tr>";
                        // if the cat has no price it will echo 0
                    } else {
                        echo "<td>" . $catName["name"] . "</td>";
                        echo "<td> $0</td>";
                    }
                }
                ?>
    </main>