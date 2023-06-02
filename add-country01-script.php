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
        // Check if the action is canceled and redirect if so
        if (isset($_POST["denie"])) {
            header("Location: add-product01.php");
            exit();
        }

        // Check if the user is signed in as an admin, otherwise redirect to the login page
        if (!isset($_SESSION["signedInAdmin"])) {
            header("Location: index.php");
            exit();
        }

        require_once("./dbconnect.php");
        include "nav.php";
        ?>
    </header>
    <form method="post" action="">
        <h3>Voeg land toe</h3>
        <div>
            <label for="product">Naam Land:</label>
            <input type="text" id="product" name="country-name" readonly value="<?php echo $_POST["country-name"]; ?>" />
        </div>
        <div>
            <label for="product">Land Code:</label>
            <input type="text" id="product" name="country-code" readonly value="<?php echo $_POST['country-code']; ?>" />
        </div>
        <input type="submit" name="confirm" id="submit" value="Weet u zeker dat het klopt?">
        <input type="submit" name="denie" id="submit" value="Nee, het klopt niet!">
    </form>

    <?php
    // Function to sanitize input
    function sanitizeInput($value)
    {
        // Sanitize user input
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    // Function to add to the database
    function addToDB($db)
    {
        try {
            $query = $db->prepare("SELECT count(*) FROM country");
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $results = $query->fetch();

        if ($results[0] >= 1) {
            echo 'Product bestaat al';
            echo '<script>window.location.replace("add-country01.php")</script>';
            exit();
        }

        $filteredName = sanitizeInput($_POST["country-name"]);
        $filteredcode = sanitizeInput($_POST["country-code"]);

        try {
            $addcoun = $db->prepare("INSERT INTO country (`name`, `code`) VALUES (:country, :code)");
        } catch (PDOException $e) {
            die("FOUT IN SQL QUERY " . $e->getMessage());
        }

        $addcoun->execute([
            ":country" => $filteredName,
            ":code" => $filteredcode,
        ]);

        echo '<script>window.location.replace("add-country01.php")</script>';
    }

    if (isset($_POST["confirm"])) {
        addToDB($db);
    }

    ?>
</body>
</html>
