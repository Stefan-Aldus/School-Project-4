<?php
session_start();

$_SESSION["signedInCustomer"] = 7;
echo "Logged in with userid " . $_SESSION["signedInCustomer"]
    ?>