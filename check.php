<?php
// checking if user is signed in as a customer
// if the user is not signed in ( session variable isnt set)
// it will redirect you to you desired website ( for now home page until login is there)
if (!isset($_SESSION["signedInCustomer"])) {
    header("Location: http://localhost/po4/index.php ");
exit();

}
?>