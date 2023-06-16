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
      header_remove();
      header("Location: index.php ");
      exit();
    }
    require_once("dbconnect.php");
    include "nav.php";
    ?>
  <!-- </header> -->
  <form method="post" action="add-country01-script.php">
    <h3>Voeg land toe</h3>
    <div>
      <label for="product">Naam Land:</label>
      <input type="text" id="product" name="country-name" required />
    </div>
    <div>
      <label for="product">LandenCode:</label>
      <input type="text" id="product" name="country-code" required />
        <?php
        // defines a Query for catorgory's
        $retreivecountry = $db->prepare("SELECT `name` FROM country");
        $retreivecountry->execute();
        $countrynames = $retreivecountry->fetchAll();
        // for each catorgory it will echo it in the select

        ?>
      </select>
    </div>
    <div>
      </select>
    </div>
    <input type="submit" name="submit" id="submit" value="voeg toe">
</body>

</html>
</body>

</html>