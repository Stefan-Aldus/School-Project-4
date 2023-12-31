<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huidige gebruiker wijzigen</title>
    <link rel="stylesheet" href="company.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["signedInAdmin"])) {
        header("location: index.php"); // Replace "index.php" with the desired destination page
        exit();
    } elseif (!isset($_POST["submitbtn"]) || !isset($_POST["submit"])) {

    }
    include_once "nav.php";
    require_once "dbconnect.php";


    if (isset($_POST["submitbtn"])) {
        $query = "UPDATE `client` SET ";
        $query .= "`first_name`=:first_name,";
        $query .= "`last_name`=:last_name,";
        $query .= "`adress`=:adress,";
        $query .= "`zipcode`=:zipcode,";
        $query .= "`city`=:city,";
        $query .= "`state`=:state,";
        $query .= "`country`=:country,";
        $query .= "`telephone`=:telephone ";
        $query .= "WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindParam(':id', $_SESSION["signedInCustomer"]); // Add this line to bind the :id parameter
        $statement->bindParam(':first_name', $_POST['firstname']);
        $statement->bindParam(':last_name', $_POST['lastname']);
        $statement->bindParam(':adress', $_POST["adress"]);
        $statement->bindParam(':zipcode', $_POST["zipcode"]);
        $statement->bindParam(':city', $_POST["city"]);
        $statement->bindParam(':state', $_POST["state"]);
        $statement->bindParam(':country', $_POST["country"]);
        $statement->bindParam(':telephone', $_POST["telephone"]);
        $statement->execute();

        echo "setTimeout(function() {
            window.location.href = 'index.php?message=info%20updated';
          }, 5000);
          ";
    }

    // $query = "SELECT first_name, last_name, adress, zipcode, city, state, country, telephone FROM client WHERE id = :id";
    // $statement = $db->prepare($query);
    // $statement->bindParam(':id', $_SESSION["signedInCustomer"]);
    // $statement->execute();
    // $_POST = $statement->fetchAll();
    ?>
    <form method="POST">
        <div>
            <input type="text" name="nfn" value="<?php echo $_POST["nfn"] ?>" required>
            <span></span>
            <label>First Name</label>
        </div>
        <div>
            <input type="text" name="nln" value="<?php echo $_POST['nln'] ?> " required>
            <span></span>
            <label>Last Name</label>
        </div>
        <div>
            <div>
                <input type="text" name="adress" value="<?php echo $_POST['nad'] ?>" required>
                <span></span>
                <label>adress</label>
            </div>
            <div>
                <input type="text" name="zipcode" value="<?php echo $_POST['npc'] ?>" required>
                <span></span>
                <label>Zipcode</label>
            </div>
        </div>
        <div>
            <div>
                <input type="text" name="city" value="<?php echo $_POST['nci'] ?>" required>
                <span></span>
                <label>City</label>
            </div>
            <div>
                <input type="text" name="state" value="<?php echo $_POST['nst'] ?>" required>
                <span></span>
                <label>State</label>
            </div>
            <div>
                <input type="text" name="telephone" value="<?php echo $_POST['ntel'] ?>" required>
                <span></span>
                <label>Telephone number</label>
            </div>
        </div>
        <div>
            <input type="text" name="country" id="country" value="<?php echo $_POST["nco"] ?>">
            <label>LAND</label>
        </div>
        <input type="submit" value="Gegevens Wijzigen" name="submitbtn">
        <?php
        ?>

</body>

</html>