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
    // database connection
    require_once("dbconnect.php");
    include "nav.php";

    // saving posts from the last page
    $productname = $_POST["productname"] ?? "";
    $quantity = $_POST["quantity"] ?? "";
    $pid = $_POST["pid"] ?? "";

    // making the price variable
    $query = $db->prepare("SELECT price FROM `product` WHERE productname = :productname;");
    $query->execute([
        ":productname" => $productname
    ]);
    $resultq = $query->fetch(PDO::FETCH_ASSOC);
    $price = $resultq !== false ? $resultq["price"] : 0;

    // getting the product old id
    $query2 = $db->prepare("SELECT id FROM `product` WHERE productname = :productname;");
    $query2->execute([
        ":productname" => $productname
    ]);
    $result = $query2->fetch(PDO::FETCH_ASSOC);
    $productid = $result["id"] ?? "";

    ?>

    <main>
        <form action="" method="post">
            <h3>weet je zeker dat je dit product wilt aanpassen</h3>
            <div>
                <label for="klant">product id:</label>
                <span><?php echo $productid ?></span>
            </div>
            <div>
                <label for="klant">product naam:</label>
                <span><?php echo $productname ?></span>
            </div>
            <div>
                <label for="klant">hoeveelheid:</label>
                <span><?php echo $quantity ?></span>
            </div>
            <div>
                <label for="klant">prijs voor 1 product:</label>
                <span><?php echo $price ?></span>
            </div>
            <input type="submit" name="confirmp" id="submitp" value="ja">
            <input type="submit" name="confirmk" id="submitk" value="nee">
            <?php  
            // saving old variables
                echo '<input type="hidden" name="pid" value="' . $pid . '">'; 
                echo '<input type="hidden" name="productname" value="' . $productname . '">'; 
                echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
                echo '<input type="hidden" name="oldproductname" value="' . $productname . '">';
            ?>
        </form>

        <?php 
        if (isset($_POST["confirmp"])) {
            // new page variables
            $pname = $_POST["productname"];
            $quantity = $_POST["quantity"];
            $purchaseid = $_POST["pid"];
            $oldproductname = $_POST["oldproductname"];
            
            // getting the new product id
            $query4 = $db->prepare("SELECT id FROM `product` WHERE productname = :productname;");
            $query4->execute([
                ":productname" => $_SESSION["oldproductname"]
            ]);
            $result4 = $query4->fetch(PDO::FETCH_ASSOC);
            $oldID = $result4["id"] ?? "";
            
            // debugging
            // echo $oldID;
            // quary to change the product in the order
            $query3 = $db->prepare("UPDATE purchaseline
                SET productid = :productid, price = :price, quantity = :quantity
                WHERE purchaseid = :opurchaseid AND productid = :oproductid;");
            $query3->execute([
                ":productid" => $productid,
                ":price" => $price,
                ":quantity" => $quantity,
                ":opurchaseid" => $purchaseid,
                ":oproductid" => $oldID
            ]);
            // getting rid of the session variables
            unset($_SESSION['counter']);
            unset($_SESSION["pid"]);
            echo '<script>window.location.replace("change-order.php")</script>';
        }
        // getting rid of the session variables
        if (isset($_POST["confirmk"])) {
            unset($_SESSION['counter']);
            unset($_SESSION["pid"]);
            echo '<script>window.location.replace("change-order.php")</script>';
        }
        ?>
    </main>
</body>

</html>
