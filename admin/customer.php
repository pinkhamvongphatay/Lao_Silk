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

// ดึงข้อมูลลูกค้าจากฐานข้อมูล
$sql = "SELECT * FROM customer ORDER BY created_date DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h1>ໜ້າຈັດການຂອງລູກຄ້າ</h1>
    <a href="customer_add.php" class="btn btn-primary mb-3">ເພີ່ມລູກຄ້າ</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>ຊື່ຜູ້ໃຊ້</th>
                <th>ເບີໂທ</th>
                <th>ວັນທີສ້າງ</th>
                <th>ປັບປຸງ</th>
                <th>ຈັດການ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['customer_id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['tel'] ?></td>
                <td><?= $row['created_date'] ?></td>
                <td><?= $row['updated_date'] ?></td>
                <td>
                    <a href="customer_edit.php?id=<?= $row['customer_id'] ?>" class="btn btn-warning btn-sm">ແກ້ໄຂ</a>
                    <a href="customer_delete.php?id=<?= $row['customer_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ຢືນຢັນການລຶບ?')">ລຶບ</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require('footer.php'); ?>
