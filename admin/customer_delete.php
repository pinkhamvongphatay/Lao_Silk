<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
require('../db.php');

$id = $_GET['id'];
$sql = "DELETE FROM customer WHERE customer_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: customer.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>