<?php
session_start();

if (isset($_POST["logoutconfirm"])) {
    // if (isset($_SESSION["signedInCustomer"])) {
    unset($_SESSION["signedInAdmin"]);
    // sleep(5);

    $message = "Successfully Logged Out";
    $url = "index.php?message=" . urlencode($message);
    header("Location: " . $url);
    exit;

    // }
} elseif (isset($_POST["logoutcancel"])) {
    header("Location: Index.php");
    $message = "U bent niet uitgelogd";
    $url = "index.php?message=" . urlencode($message);
    header("Location: " . $url);
    exit;
} else {
    header("Location: Index.php");
}

?>