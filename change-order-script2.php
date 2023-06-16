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
    
    if (!isset($_SESSION["signedInAdmin"])) {
        header_remove();
        header("Location: login.php ");
        exit();
    }
    require_once("dbconnect.php");
    include "nav.php";



    ?>

    <main>
        <form action="change-order-script3.php" method="post">
            <h3>pas product aan</h3>
            <?php  
            // saving old variables
                $pid= $_POST["pid"];
                echo '<input type="hidden" name="pid" value="' . $pid . '">'; 
                $oldproductname =  $_POST["oldproductname"];
                echo '<input type="hidden" name="oldproductname" value="' . $oldproductname . '">'; 
                ?>
           
            <div>
                <label for="klant">naam:</label>
                <select id="product" name="productname">
                <?php
                // defines a Query for product's
                $retreiveProducts = $db->prepare("SELECT productname FROM `product`;");
                $retreiveProducts->execute();
                $productNames = $retreiveProducts->fetchAll();
                // for each catorgory it will echo it in the select
                foreach ($productNames as $productName) {
                    $selected = ($productName['productname'] === $_SESSION["oldproductname"]) ? 'selected' : '';
                    echo '<option class="<3 Berkhout" ' . $selected . '>' . $productName['productname'] . '</option>';
                }


                ?>
                <div>
                    <label for="klant">hoeveelheid:</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo $_POST["quantity"] ?>" />
                </div>

                
                <input type="submit" name="confirm" id="submit" value="verander">
                <?php  
                // saving other old variables
                $pid = $_POST["pid"];
                echo '<input type="hidden" name="pid" value="' . $pid . '">'; 
                $oldproductname =  $_POST["oldproductname"];
                echo '<input type="hidden" name="oldproductname" value="' . $oldproductname . '">'; 
                ?>
                
                
        </form>




        <?php


        
        ?>
    </main>
</body>

</html>