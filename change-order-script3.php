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


    // saving posts  from the last page
    $pname = $_POST["productname"];
    $quantity = $_POST["quantity"];
    $purchaseid= $_POST["pid"];




// making the price variable
$query = $db->prepare("SELECT price FROM `product` WHERE productname = :productname;");
$query->execute([
    ":productname" => $pname
]);
$resultq = $query->fetch(PDO::FETCH_ASSOC);  //
$price = $resultq["price"];


// getting the product old id
$query2 = $db->prepare("SELECT id FROM `product` WHERE productname = :productname;");
$query2->execute([
    ":productname" => $pname
]);
$result = $query2->fetch(PDO::FETCH_ASSOC);  //
$pid = $result["id"];



if (isset($_POST["submitp"])) {
// new page variables
$nproductname= $_POST["productname"];


    $query3 = $db->prepare("UPDATE purchaseline
    SET purchaseid= :purchaseid, productid= :pid, price= :price, quantity= :quantity
    WHERE purchaseid= :purchaseid AND WHERE productid= :pname;");
$query3->execute([
    ":productid" => $pname
]);
}
    ?>

    <main>
        <form action="change-order-script3.php" method="post">
            <h3>pas product aan</h3>
            <div>
    <label for="klant">product id:</label>
    <span><?php echo $pid ?></span>
</div>
            <div>
    <label for="klant">product naam:</label>
    <span><?php echo $pname ?></span>
</div>
                <div>
                    <label for="klant">hoeveelheid:</label>
                    <span><?php echo $quantity ?></span>
                </div>

                <div>
                    <label for="klant">prijs voor 1 product:</label>
                    <span><?php 
                    
                    echo $price ?></span>
                </div>
                <input type="submit" name="confirmp" id="submitp" value="ja">
        </form>