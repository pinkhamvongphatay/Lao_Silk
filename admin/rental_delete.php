<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php require('../db.php');
$id = $_GET['id'];
$conn->query("DELETE FROM rental WHERE id=$id");
header('Location: rental.php');
