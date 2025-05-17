<?php
require('layout.php');
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO customer (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: customer.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ເພີ່ມລູກຄ້າ</div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ລະຫັດຜ່ານ</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">ເພີ່ມ</button>
                <a href="customer.php" class="btn btn-secondary">ຍົກເລີກ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>