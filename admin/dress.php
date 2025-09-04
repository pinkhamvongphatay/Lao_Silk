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

// ดึงข้อมูลชุดทั้งหมด พร้อมชื่อประเภท
$sql = "SELECT dress.*, type_dress.type 
        FROM dress 
        LEFT JOIN type_dress ON dress.type_id = type_dress.id 
        ORDER BY dress.id DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2>ຈັດການຂໍ້ມູນຊຸດ</h2>
    <a href="dress_add.php" class="btn btn-success mb-3">ເພີ່ມຊຸດໃໝ່</a>

  <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>ຮູບ</th> <!-- New image column -->
            <th>ຂະໜາດ</th>
            <th>ສີ</th>
            <th>ຄວາມຍາວ</th>
            <th>ຄວາມກວ້າງ</th>
            <th>ຈຳນວນ</th>
            <th>ລາຄາ</th>
            <th>ປະເພດ</th>
            <th>ຄຳອະທິບາຍ</th>
            <th>ຈັດການ</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <?php if (!empty($row['img'])): ?>
                            <img src="../images/<?= htmlspecialchars($row['img']) ?>" width="80" height="80" style="object-fit: cover;" />
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['size'] ?></td>
                    <td><?= $row['color'] ?></td>
                    <td><?= $row['length'] ?></td>
                    <td><?= $row['width'] ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['type'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <a href="dress_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">ແກ້ໄຂ</a>
                        <a href="dress_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ຢືນຢັນການລຶບ')">ລຶບ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="11" class="text-center text-danger">ບໍ່ພົບຂໍ້ມູນ</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</div>

<?php require('footer.php'); ?>
