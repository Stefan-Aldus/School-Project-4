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
    // check if you canceled your action and if so it will redirect you back
    if (isset($_POST["denie"])) {
        header_remove();
        header("Location: remove-client.php ");
    }
    if (!isset($_SESSION["signedInAdmin"])) {
        header_remove();
        header("Location: login.php ");
        exit();
    }
    require_once("dbconnect.php");
    include "nav.php";

    ?>

    <main>
        <form action="" method="post">
            <h3>verwijder klant</h3>
            <div>
                <label for="klant">ID:</label>
                <input type="text" id="klant" name="cat-id" readonly value="<?php echo $_POST["cat-id"] ?>" />
            </div>
            <div>
                <label for="klant">Cat Naam:</label>
                <input type="text" id="klant" name="cat-name" readonly value="<?php echo $_POST["cat-name"] ?>" />
            </div>
            <input type="submit" name="confirm" id="submit" value="Verwijderen">
            <input type="submit" name="denie" id="submit" value="Annuleren">
        </form>




        <?php
        function delete($db)
        {
            try {
                $delcat = $db->prepare("DELETE FROM category WHERE ID = :id");
            } catch (PDOException $e) {
                die("FOUT IN SQL QUERY " . $e->getMessage());
            }

            $id = $_POST["cat-id"];
            $delcat->execute([
                ":id" => $id
            ]);
            echo '<script>window.location.replace("remove-cat.php")</script>';
        }


        if (isset($_POST["submit"])) {
            // Else checks if the final submit form is submitted, and calls the addtodb function
            // echo ("TEST1");
        }
        if (isset($_POST["confirm"])) {
            delete($db);
            // echo ("TEST2");
        } elseif (isset($_POST["submit"])) {
        }
        ?>
    </main>
</body>

</html>