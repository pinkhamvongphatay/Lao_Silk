<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tel = $_POST['tel'];
    
    $sql = "INSERT INTO employees (username, password, tel) 
            VALUES ('$username', '$password', '$tel')";

    if ($conn->query($sql) === TRUE) {
        header("Location: employees.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
