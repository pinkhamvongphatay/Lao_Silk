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

$sql = "SELECT * FROM type_dress ORDER BY created_date DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h1>ໜ້າຈັດການປະເພດຊຸດ</h1>

    <!-- Add Button -->
    <a href="dress_type_add.php" class="btn btn-primary mb-3">ເພີ່ມປະເພດຊຸດ</a>

    <!-- Data Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>ຊື່ປະເພດຊຸດ</th>
                <th>ວັນທີສ້າງ</th>
                <th>ປັບປຸງ</th>
                <th>ຈັດການ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['type'] ?></td>
                    <td><?= $row['created_date'] ?></td>
                    <td><?= $row['updated_date'] ?></td>
                    <td>
                        <a href="dress_type_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">ແກ້ໄຂ</a>
                        <a href="dress_type_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ຢືນຢັນການລຶບ?')">ລຶບ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require('footer.php'); ?>
