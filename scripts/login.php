<?php
session_start();

$_SESSION["signedInAdmin"] = 9;
echo "Logged in with userid " . $_SESSION["signedInAdmin"]
    ?>