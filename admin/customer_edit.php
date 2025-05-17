<?php
require('layout.php');
require('../db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM customer WHERE customer_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    $sql = "UPDATE customer SET username='$username', updated_date=NOW() WHERE customer_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: customer.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ແກ້ໄຂລູກຄ້າ</div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
                    <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
                </div>
                <button type="submit" class="btn btn-success">ບັນທຶກ</button>
                <a href="customer.php" class="btn btn-secondary">ຍົກເລີກ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>