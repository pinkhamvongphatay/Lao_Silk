<?php
require('../db.php');

$id = $_GET['id'];
$sql = "DELETE FROM type_dress WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: dress_type.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
