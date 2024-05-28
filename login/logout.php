<?php
require_once '../includes/config.php';
session_start();

if (isset($_SESSION['personal'])) {
    session_destroy();
    header("Location:". BASE_URL . "login/");
    exit();
}

?>
