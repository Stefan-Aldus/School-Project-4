<?php
if (!isset($_SESSION["signedInCustomer"])) {
    header_remove();
    header("Location: login.php ");
    exit();
}

?>