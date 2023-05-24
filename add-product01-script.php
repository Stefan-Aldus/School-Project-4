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
    if (!isset($_SESSION["signedInCustomer"])) {
        header_remove();
        header("Location: index.php ");
        exit();
    }

    
    
    require_once("dbconnect.php");
    include "nav.html";
    ?>
</header>
    <form method="post" action="add-product01.php">
          <h3>Voeg product toe</h3>
          <div>
          <label for="product">Naam product:</label>
          <input type="text" id="product" name="product-name" readonly value="<?php echo $_POST["product-name"] ?>" />
          </div>
          <div>
          <label for="product">Ingredienten: (optioneel)</label>
          <input type="text" id="product" name="product-ingredients" readonly value="<?php echo $_POST['product-ingredients']; ?>" />
          </div>
          <div>
          <label for="product">allergien: (optioneel)</label>
          <input type="text" id="product" name="product-allergens" readonly value="<?php echo $_POST['product-allergens']; ?>" />
          </div>
          <div>
          <label for="product">Prijs:</label>
          <input type="text" id="product" name="product-price" readonly value="<?php echo $_POST['product-price']; ?>" />
          </div>
          <div>
          <label for="product">Category:</label>
          <input type="text" id="product" name="product-cat" readonly value="<?php echo $_POST['product-cat']; ?>" />
          </div>
          <div>
          <label for="product">Supplier:</label>
          <input type="text" id="product" name="product-company" readonly value="<?php echo $_POST['product-company']; ?>" />
          </div>
          <input type="submit" name="confirm" id="submit" value="weet u zeker dat het klopt?">
          <input type="submit" name="denie" id="submit" value="nee het klopt niet!">
</body>
<?php
        // using to filter 
        function sanitizeInput($value)
    {
        // Sanitize user input
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    ;
    function addToDB($db) {
        $filteredName = sanitizeInput($_POST["product-name"]);
        $filteredingredients = sanitizeInput($_POST["product-ingredients"]);
        $filteredAllergens = sanitizeInput($_POST["product-allergens"]);
        $filteredPrice = sanitizeInput($_POST["product-price"]);
        try {
            $retrievecatid = $db->prepare("SELECT ID FROM category WHERE `name` = :name");
            $retrievecompid = $db->prepare("SELECT ID FROM supplier WHERE `company` = :company");
            $addprod = $db->prepare("INSERT INTO product (`productname`, `ingredients`, `allergens`, `price`, `categoryid`, `supplierid`, `isinactive`) 
            VALUES (:productname,:ingredients, :allergens, :price, :categoryid, :supplierid, :isinactive)");
        } catch (PDOException $e) {
            die("FOUT IN SQL QUERY " . $e->getMessage());
        }

        $retrievecompid->execute([":company" => $_POST["product-company"] ]);
        $compid = $retrievecompid->fetch();
        $retrievecatid->execute([":name" => $_POST["product-cat"] ]);
        $catid = $retrievecatid->fetch();
        
        // variable to set inactive to 0 by default
        $isinactive = 0;


        $addprod->execute([
            ":productname" => $filteredName,
            ":ingredients" => $filteredingredients,
            ":allergens" => $filteredAllergens,
            ":price" => $filteredPrice,
            ":categoryid" => $catid['ID'],
            ":supplierid" => $compid['ID'],
            ":isinactive" => $isinactive
        ]);
    };
        
    // Checks if the original form is submitted, and calls the filterinput function
    if (isset($_POST["submit"])) {
        // Else checks if the final submit form is submitted, and calls the addtodb function
        
    } elseif (isset($_POST["confirm"])) {
        addToDB($db);
    } 
    
    elseif (isset($_POST["denie"])) {
        header_remove();
        header("Location: add-product01.php ");
    }
    else {
        // Else exits the program
        exit("U heeft deze pagina op de verkeerde manier bezocht!");
    }

        ?>
</html>
</body>
</html>