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
    include "nav.php";




    ?>
    <main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle clienten</h2>
        <?php
        // if (!isset($_SESSION["signedInCustomer"])) {
        //     echo 'Je moet ingelogd zijn om te bestellen! <br>';
        // }
        // Verbinding maken met de database 
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT * FROM client");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0) {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>id</th>
              <th>Voornaam</th>
              <th>Achternaam</th>
              <th>Email</th>
              <th>Land</th>
              <th>Telefoon nr</th>
              <th>Is Admin</th>";

        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="" method="post">';
            echo "<tr>";
            echo "<td>" . $data["id"] . "</td>";
            echo "<td>" . $data["first_name"] . "</td>";
            echo "<td>" . $data["last_name"] . "</td>";
            echo "<td>" . $data["email"] . "</td>";
            echo "<td>" . $data["country"] . "</td>";
            echo "<td>" . $data["telephone"] . "</td>";
            echo "<td>" . $data["isadmin"] . "</td>";
            echo "<td><input type='submit' value='Maak admin' name='makeadmin'></td>";
            echo "<td><input type='submit' value='Maak geen admin' name='unadmin'</td>";
            echo "</tr>";

            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="id" value="' . $data["id"] . '">';
            echo '<input type="hidden" name="fist_name" value="' . $data["first_name"] . '">';
            echo '<input type="hidden" name="last_name" value="' . $data["last_name"] . '">';
            echo '<input type="hidden" name="email" value="' . $data["email"] . '">';
            echo '<input type="hidden" name="country" value="' . $data["country"] . '">';
            echo '<input type="hidden" name="telephone" value="' . $data["telephone"] . '">';
            echo '<input type="hidden" name="isadmin" value="' . $data["isadmin"] . '">';

            echo "</form>";
        }

        if (isset($_POST["unadmin"])) {
            // Haalt de productID uit de form
            $id = $_POST["id"];
            // Checkt of de user die geunadmint owordt niet de active user is
            if ($_SESSION["signedInAdmin"] == $id) {
                exit("You can not unadmin yourself.");
            }
            // Checkt de huidige activiteit
            try {
                $checkadmin = $db->prepare("SELECT isadmin FROM client WHERE id = :id");
                $checkadmin->bindValue(":id", $id);
                $checkadmin->execute();
            } catch (PDOException $e) {
                echo "Error in SQL:" . $e->getMessage();
            }


            $adminstate = $checkadmin->fetch();

            if ($adminstate['isadmin'] == 1) {
                try {
                    $setactivity = $db->prepare("UPDATE client SET isadmin = :isadmin WHERE ID = :id");
                    $setactivity->bindValue(":isadmin", 0);
                    $setactivity->bindValue(":id", $id);
                } catch (PDOException $e) {
                    echo "Fout in zet activiteit statement: " . $e->getMessage();
                }
                $setactivity->execute();
                echo "<script>window.location.reload()</script>";
            } else {
                echo "<p>Deze gebruiker is nu geen admin</p>";
            }
            ;
        }

        if (isset($_POST["makeadmin"])) {

            // Haalt de productID uit de form
            $id = $_POST["id"];
            // Checkt de huidige activiteit
        
            try {
                $checkadmin = $db->prepare("SELECT isadmin FROM client WHERE ID = :id");
                $checkadmin->bindValue(":id", $id);
                $checkadmin->execute();
            } catch (PDOException $e) {
                echo "Error in SQL:" . $e->getMessage();
            }


            $adminstate = $checkadmin->fetch();

            if ($adminstate['isadmin'] == 0) {
                try {
                    $setactivity = $db->prepare("UPDATE client SET isadmin = :isadmin WHERE ID = :id");
                    $setactivity->bindValue(":isadmin", 1);
                    $setactivity->bindValue(":id", $id);
                } catch (PDOException $e) {
                    echo "Fout in zet activiteit statement: " . $e->getMessage();
                }
                $setactivity->execute();
                echo "<script>window.location.reload()</script>";
            } else {
                echo "<p>Deze gebruiker is nu admin</p>";
            }
            ;
        }


        // Debugging: you can display the stored values
        // echo "Added purchase made: " . $productName . ", Category: " . $category . ", Supplier: " . $supplier . " , Hoeveelheid: " . $number . "   id: " . $id;
        ?>
    </main>
</body>

</html>