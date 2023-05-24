<?php
if (!isset($_SESSION["signedInAdmin"])) {
    header_remove();
    header("Location: login.php ");
    exit();
}

?>