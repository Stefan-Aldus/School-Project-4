<?php
session_start();


if (isset($_SESSION["signedInCustomer"])) {
    unset($_SESSION["signedInCustomer"]);
    echo "Logged out user";
} elseif (isset($_SESSION["signedInAdmin"])) {
    unset($_SESSION["signedInAdmin"]);
    echo "Logged out admin";
} else {
    echo "You were not logged in";
}
?>