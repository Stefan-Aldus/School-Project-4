<?php
session_start();


date_default_timezone_set('Europe/Amsterdam');
$date = date('Y-m-d h:i:s a', time());
echo $date;
?>