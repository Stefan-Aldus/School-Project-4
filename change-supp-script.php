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
    }
    include_once "./nav.php";
    require_once "dbconnect.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = $db->prepare("UPDATE supplier 
                            SET company = :company, 
                                adress = :adress, 
                                streetnr = :streetnr, 
                                zipcode = :zipcode, 
                                city = :city, 
                                state = :state, 
                                telephone = :telephone,
                                website = :website
                            WHERE id = :id");

        $update->bindParam(':company', $_POST["newemail"]);
        $update->bindParam(':adress', $_POST["nfn"]);
        $update->bindParam(':streetnr', $_POST['nln']);
        $update->bindParam(':zipcode', $_POST['nad']);
        $update->bindParam(':city', $_POST['npc']);
        $update->bindParam(':state', $_POST['state']);
        $update->bindParam(':telephone', $_POST['nci']);
        $update->bindParam(':website', $_POST['nst']);
        $update->bindParam(':id', $_POST["original"]);
        $update->execute();

        // Redirect to index.php after the update with a success message
        header("location: index.php?message=info%20updated");
        exit();
    } ?>
    <form method="POST">
        <div>
            <label for="pass">original company ID:</label>
            <input type="text" id="original" name="original" required />
        </div>
        <div>
            <input type="text" name="nfn" value="<?php echo $_POST["nfn"] ?>" required>
            <span></span>
            <label>Company</label>
        </div>
        <div>
            <input type="text" name="nln" value="<?php echo $_POST['nln'] ?> " required>
            <span></span>
            <label>Adress</label>
        </div>
        <div>
            <div>
                <input type="text" name="adress" value="<?php echo $_POST['nad'] ?>" required>
                <span></span>
                <label>Streetnr</label>
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
                <input type="text" name="nci" value="<?php echo $_POST['nci'] ?>" required>
                <span></span>
                <label>telephone</label>
            </div>
            <div>
                <input type="text" name="nst" value="<?php echo $_POST['nst'] ?>" required>
                <span></span>
                <label>website</label>
            </div>
        </div>
        <input class="gegevens_submit" type="submit" value="Gegevens Wijzigen">
        <?php
        ?>

</body>

</html>