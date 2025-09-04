<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require('layout.php');
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    
    $sql = "INSERT INTO type_dress (type) VALUES ('$type')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dress_type.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ເພີ່ມປະເພດຊຸດ</div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ປະເພດຊຸດ</label>
                    <input type="text" name="type" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">ເພີ່ມ</button>
                <a href="dress_type.php" class="btn btn-secondary">ຍົກເລີກ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
