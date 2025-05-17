<?php
require('layout.php');
require('../db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM employees WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $tel = $_POST['tel'];
    
    $sql = "UPDATE employees SET username='$username', tel='$tel', update_date=NOW() WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: employees.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ແກ້ໄຂຂໍ້ມູນພະນັກງານ</div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
                    <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ເບີໂທ</label>
                    <input type="text" name="tel" class="form-control" value="<?= $row['tel'] ?>">
                </div>
                <button type="submit" class="btn btn-success">ບັນທຶກ</button>
                <a href="employees.php" class="btn btn-secondary">ຍົກເລີກ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
