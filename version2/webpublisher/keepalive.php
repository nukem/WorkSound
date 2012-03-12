<?php
session_start();
$_SESSION['keep_alive'] = $_GET['date'];
header("HTTP/1.0 404 Not Found");
?>