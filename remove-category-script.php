<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="company.css">
</head>
<?php

if (!isset($_SESSION["selected-catid"]) && !isset($_SESSION["selected-catname"])) {
    header("Location: remove-category.php");
    exit();
}

require_once "dbconnect.php";

if (isset($_POST["confirm-remove-cat"])) {
    $selectedCatId = $_SESSION["selected-catid"];
    $selectedCatName = $_SESSION["selected-catname"];

    try {
        $query2 = $db->prepare("DELETE FROM category WHERE ID = :catid");
        $query2->bindParam(":catid", $selectedCatId);
        $query2->execute();
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    header("Location: Index.php");
    exit();
}
?>

<body>
    <?php
    include "nav.php";
    session_start();
    ?>
    <h1>Welkom bij de Bread Company</h1>
    <h2>Hier staan alle categorien zonder actieve bestellingen!</h2>

    <table class="tableformat">
        <thead>
            <th>Category ID</th>
            <th>Category Naam</th>
        </thead>
        <tbody>
            <tr>
                <form method="post" action="">
                    <td>
                        <?php echo $_SESSION["selected-catid"]; ?>
                        <input type="hidden" name="selected-catid" value="<?php echo $_SESSION["selected-catid"]; ?>">
                    </td>
                    <td>
                        <?php echo $_SESSION["selected-catname"]; ?>
                        <input type="hidden" name="selected-catname"
                            value="<?php echo $_SESSION["selected-catname"]; ?>">
                    </td>
                    <td>
                        <input type="submit" name="cancel-remove-cat" value="Annuleren">
                        <input type="submit" name="confirm-remove-cat" value="Verwijderen">
                    </td>
                </form>
            </tr>
        </tbody>
    </table>
</body>

</html>