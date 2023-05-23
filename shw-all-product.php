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
			include "nav.html";
		?>
<main class="flexverticalcenter">
        <h2 class="spacebelowabove">Overzicht van alle producten</h2>
    <?php
    if (!isset($_SESSION["signedInCustomer"])) {
        echo 'Je moet ingelogd zijn om te bestellen! <br>';
    }
        // Verbinding maken met de database 
        require_once("dbconnect.php");

        // Alle producten ophalen met de bijbehorende gegevens
        $query = $db->prepare("SELECT product.*, category.name AS Category, supplier.company AS Supplier FROM product 
        INNER JOIN category ON category.id = product.categoryid 
        INNER JOIN supplier ON product.supplierid = supplier.id;");
        $query->execute();
        $resultq = $query->fetchAll(PDO::FETCH_ASSOC);

        // als er geen klanten aanwezig zijn, dan een foutboodschap
        if ($query->rowCount() == 0)
        {
            echo "<h2>Er zijn géén gegevens gevonden voor deze informatie. </h2>";
            die();
        }

        echo "<table class='tableformat'>";
        echo "<thead>
              <th>Product naam</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Prijs per product</th>
              <th>Hoeveelheid</th>
              </thead>";
        echo "<tbody>";

        // Alle gegevens uit purchase op het scherm tonen
        foreach ($resultq as $data) {
            echo '<form action="" method="post">';
            echo "<tr>";
            echo "<td>".$data["productname"]."</td>";
            echo "<td>".$data["Category"]."</td>";
            echo "<td>".$data["Supplier"]."</td>";
            echo "<td> € ".$data["price"]."</td>";
            echo '<td> <input type="number" name="number" id="number"></td>';
        
            if (!isset($_SESSION["signedInCustomer"])) {
                echo '<td> <input type="submit" name="add" value="add to cart"></td>';
            }

        
            // Store the $data values in hidden input fields
            echo '<input type="hidden" name="productname" value="'.$data["productname"].'">';
            echo '<input type="hidden" name="category" value="'.$data["Category"].'">';
            echo '<input type="hidden" name="supplier" value="'.$data["Supplier"].'">';
            echo '<input type="hidden" name="price" value="'.$data["price"].'">';
                    
            echo "</tr>";
            echo "</form>";
        }
        
        if (isset($_POST["add"])) {
            $number = $_POST["number"];
            // checks if atleast 1 is selected
            if($number < 0){
                echo "teweinig geselecteerd";
            }

            else{
                // Retrieve the stored $data values
            $productName = $_POST["productname"];
            $category = $_POST["category"];
            $supplier = $_POST["supplier"];
            $price = $_POST["price"];
            $cost = $price * $number;
        
        
            // Debugging: you can display the stored values
            echo "Added to cart: ".$productName.", Category: ".$category.", Supplier: ".$supplier.", Prijs: € ".$cost. " , Hoeveelheid: ".$number;
            }
            
            
        }

        
    ?>
    </main>
</body>
</html>