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
    if (!isset($_SESSION["signedInAdmin"])) {
      header_remove();
      header("Location: index.php ");
      exit();
    }
    require_once("dbconnect.php");
    include "nav.php";
    ?>
  </header>
  <form method="post" action="add-category01script.php">
    <h3>Voeg Category toe</h3>
      <label for="product">Naam category:</label>
      <input type="text" id="category" name="category-name" required />
    </div>
    <input type="submit" name="submit" id="submit" value="voeg toe">
</body>

</html>
</body>

</html>