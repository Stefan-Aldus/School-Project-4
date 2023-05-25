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
    include "nav.html";
    ?>
</header>
    <form method="post" action="add-product01-script.php">
          <h3>Voeg product toe</h3>
          <div>
          <label for="product">Naam product:</label>
          <input type="text" id="product" name="product-name" required />
          </div>
          <div>
          <label for="product">Ingredienten:</label>
          <input type="text" id="product" name="product-ingredients" required />
          </div>
          <div>
          <label for="product">allergien:</label>
          <input type="text" id="product" name="product-allergens" required />
          </div>
          <div>
          <label for="product">Prijs:</label>
          <input type="text" id="product" name="product-price" required />
          </div>
          <div>
          <label for="product">Category:</label>
          <select id="product" name="product-cat">
          <?php
            // defines a Query for catorgory's
            $retreiveCategories = $db->prepare("SELECT `name` FROM category");
            $retreiveCategories->execute();
            $categoryNames = $retreiveCategories->fetchAll();
            // for each catorgory it will echo it in the select
            foreach ($categoryNames as $categoryName) {
              echo '<option class="<3 Berkhout" value="' . $categoryName['name'] . '">' . $categoryName['name'] . '</option>';

            }
            ?>
            </select>
          </div>
          <div>
          <label for="product">Supplier:</label>
          <select id="product" name="product-company">
          <?php
            // defines a Query for catorgory's
            $retreiveCategories = $db->prepare("SELECT `company` FROM supplier");
            $retreiveCategories->execute();
            $companyNames = $retreiveCategories->fetchAll();
            // for each supplier it will echo it in the select
            foreach ($companyNames as $companyName) {
              echo '<option class="<3 Berkhout" value="' . $companyName['company'] . '">' . $companyName['company'] . '</option>';

            }
            ?>
            </select>
          </div>
          <input type="submit" name="submit" id="submit" value="voeg toe">
</body>

</html>
</body>
</html>