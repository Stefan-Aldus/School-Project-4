<?php
session_start();

$_SESSION["signedInAdmin"] = 7;
echo "Logged in with userid " . $_SESSION["signedInAdmin"]
    ?>