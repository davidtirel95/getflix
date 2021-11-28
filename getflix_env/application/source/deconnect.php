<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ./register.php');
    exit();
}
unset($_SESSION['user']);
header('Location: ./register.php');

?>