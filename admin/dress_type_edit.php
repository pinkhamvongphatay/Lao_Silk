<?php
require('layout.php');
require('../db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM type_dress WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    
    $sql = "UPDATE type_dress SET type='$type', updated_date=NOW() WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dress_type.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ແກ້ໄຂປະເພດຊຸດ</div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ປະເພດຊຸດ</label>
                    <input type="text" name="type" class="form-control" value="<?= $row['type'] ?>" required>
                </div>
                <button type="submit" class="btn btn-success">ບັນທຶກ</button>
                <a href="dress_type.php" class="btn btn-secondary">ຍົກເລີກ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
