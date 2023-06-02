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
            <label for="klant">id:</label>
            <input type="text" id="klant" name="clientid" readonly value="<?php echo $_POST["clientid"] ?>" />
        </div>
        <div>
        <label for="klant">voornaam:</label>
            <input type="text" id="klant" name="client-f-name" readonly value="<?php echo $_POST["client-f-name"] ?>" />
        </div>
        <div>
        <label for="klant">achternaam:</label>
            <input type="text" id="klant" name="client-l-name" readonly value="<?php echo $_POST["client-l-name"] ?>" />
        </div>
        <div>
        <label for="klant">email klant</label>
            <input type="text" id="klant" name="email" readonly value="<?php echo $_POST["email"] ?>" />
        </div>
        <div>
            <label for="klant">adress</label>
            <input type="text" id="klant" name="adress" readonly value="<?php echo $_POST['adress']; ?>" />
        </div>
        <div>
            <label for="klant">zipcode</label>
            <input type="text" id="klant" name="zipcode" readonly
                value="<?php echo $_POST['zipcode']; ?>" />
        </div>
        <div>
            <label for="klant">city</label>
            <input type="text" id="klant" name="city" readonly
                value="<?php echo $_POST['city']; ?>" />
        </div>
        <div>
            <label for="klant">land</label>
            <input type="text" id="klant" name="country" readonly
                value="<?php echo $_POST['country']; ?>" />
        </div>
        <div>
            <label for="klant">state</label>
            <input type="text" id="klant" name="state" readonly
                value="<?php echo $_POST['state']; ?>" />
        </div>
        <div>
            <label for="klant">telefoon nummer</label>
            <input type="text" id="klant" name="telephone" readonly
                value="<?php echo $_POST['telephone']; ?>" />
        </div>
        <div>
            <label for="klant">isadmin</label>
            <input type="text" id="klant" name="isadmin" readonly
                value="<?php echo $_POST['isadmin']; ?>" />
        </div>
        <input type="submit" name="confirm" id="submit" value="weet u zeker dat het klopt?">
        <input type="submit" name="denie" id="submit" value="nee het klopt niet!">
        </form>




        <?php
function delete($db){
    try {
        $delcustomer = $db->prepare("DELETE FROM client WHERE ID = :id");
    } catch (PDOException $e) {
        die("FOUT IN SQL QUERY " . $e->getMessage());
    }

    $id = $_POST["clientid"];
    $delcustomer->execute([
        ":id" => $id
    ]);
    echo '<script>window.location.replace("remove-client.php")</script>';
}


if (isset($_POST["submit"])) {
    // Else checks if the final submit form is submitted, and calls the addtodb function
    // echo ("TEST1");
}
if (isset($_POST["confirm"])) {
    
    delete($db);
    echo ("TEST2");
} elseif (isset($_POST["submit"])) {
} 
        ?>
    </main>
</body>
</html>