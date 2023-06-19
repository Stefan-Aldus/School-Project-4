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
  <!-- <header> -->
    <?php
    session_start();
    if (!isset($_SESSION["signedInAdmin"])) {
      header("Location: index.php");
      exit();
    }
    require_once("dbconnect.php");
    include "nav.php";
    ?>
  <!-- </header> -->

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h3>Voeg Category toe</h3>
    <div>
      <label for="category">Naam category:</label>
      <input type="text" id="category-name" name="category-name" readonly value="<?php echo $_POST['category-name']; ?>" />
    </div>
    <input type="submit" name="confirm" value="Confirm" />
    <p>Weet u zeker dat u deze category wilt toevoegen? Zo niet, keer dan alstublieft terug naar de vorige pagina.</p>
  </form>

  <?php
  function sanitizeInput($value)
  {
    // Sanitize user input
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
  }

  function addToDB($db)
  {
    $hasError = false;

    try {
      $query = $db->prepare("SELECT count(*) FROM category WHERE name = :name");
      $query->bindValue(":name", $_POST["category-name"]);
      $query->execute();
    } catch (PDOException $e) {
      die($e->getMessage());
    }

    $results = $query->fetch();

    if ($results[0] >= 1) {
      echo 'Category bestaat al';
      echo '<script>window.location.replace("add-category01.php")</script>';
      exit();
    }

    $filteredName = sanitizeInput($_POST["category-name"]);

    try {
      $addcategory = $db->prepare("INSERT INTO category (`name`) 
          VALUES (:name)");
    } catch (PDOException $e) {
      die("FOUT IN SQL QUERY " . $e->getMessage());
    }

    $retrievecatid = $db->prepare("SELECT id FROM category WHERE name = :name");
    $retrievecatid->execute([":name" => $_POST["category-name"]]);
    $catid = $retrievecatid->fetch();

    $addcategory->execute([
      ":name" => $filteredName,
    ]);

    if ($addcategory->rowCount() === 0) {
      $hasError = true;
    }

    if ($hasError) {
      exit("Er is een fout opgetreden bij het toevoegen van de category.");
    } else {
      echo '<script>window.location.replace("add-category01.php")</script>';
    }
  }

  if (isset($_POST["confirm"])) {
    addToDB($db);
  } else {
    exit("U heeft deze pagina op de verkeerde manier bezocht!");
  }
  ?>

</body>

</html>