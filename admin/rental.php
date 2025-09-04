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

// Handle search input
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = "";

if (!empty($search)) {
    $searchEscaped = $conn->real_escape_string($search);
    $whereClause = "WHERE c.username LIKE '%$searchEscaped%' OR e.username LIKE '%$searchEscaped%' OR r.id LIKE '%$searchEscaped%'";
}

$sql = "SELECT r.*, 
               e.username AS employee_name,
               c.username AS customer_name
        FROM rental r
        LEFT JOIN employees e ON r.employee_id = e.id
        LEFT JOIN customer c ON r.customer_id = c.customer_id
        $whereClause
        ORDER BY r.id DESC";

$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h1>ລາຍງານການເຊົ່າຊຸດ</h1>

    <form method="get" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control d-print-none" placeholder="ຄົ້ນຫາລູກຄ້າ, ພະນັກງານ, ID">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary d-print-none">ຄົ້ນຫາ</button>
            <a href="" class="btn btn-secondary d-print-none">ລ້າງ</a>
        </div>
        <div class="col-md-2 offset-md-4 text-end">
            <button class="btn btn-success d-print-none" onclick="window.print(); return false;">🖨️ ພິມລາຍງານ</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ລູກຄ້າ</th>
                <th>ລາຄາລວມ</th>
                <th>ວັນເລີ່ມເຊົ່າ</th>
                <th>ວັນຄືນ</th>
                <th>ພະນັກງານ</th>
                <th>ສະຖານະ</th>
                <th>ລາຍການຊຸດທີ່ເຊົ່າ</th>
                <th>ຈັດການ</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $totalAmount = 0;
        while($row = $result->fetch_assoc()): 
            $totalAmount += $row['total_price'];
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name'] ?? '-') ?></td>
                <td><?= number_format($row['total_price']) ?> Kip</td>
                <td><?= $row['start_rental_date'] ?></td>
                <td><?= $row['return_date'] ?></td>
                <td><?= htmlspecialchars($row['employee_name'] ?? '-') ?></td>
               
                <td>
                    <form method="post" action="rental_toggle_status.php" class="d-print-none">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-sm <?= $row['status'] === 'ຈອງແລ້ວ' ? 'btn-success' : 'btn-secondary' ?>">
                            <?= $row['status'] ?>
                        </button>
                    </form>
                </td>
                <td>
                    <?php
                    $rental_id = $row['id'];
                    $detail_sql = "
                        SELECT rd.*, d.size, d.color, d.price, d.img
                        FROM rental_detail rd
                        LEFT JOIN dress d ON rd.dress_id = d.id
                        WHERE rd.rental_id = $rental_id
                    ";
                    $details_result = $conn->query($detail_sql);

                    if ($details_result->num_rows > 0): ?>
                        <ul class="list-unstyled">
                            <?php while($d = $details_result->fetch_assoc()): ?>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <?php if ($d['img']): ?>
                                            <img src="../images/<?= htmlspecialchars($d['img']) ?>" alt="Dress Image" style="width: 50px; height: auto; margin-right: 10px;">
                                        <?php endif; ?>
                                        <div>
                                            <strong>Size:</strong> <?= htmlspecialchars($d['size']) ?>,
                                            <strong>Color:</strong> <?= htmlspecialchars($d['color']) ?>,
                                            <strong>Price:</strong> <?= number_format($d['price']) ?> Kip
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="rental_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning d-print-none">ແກ້ໄຂ</a>
                    <a href="rental_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger d-print-none" onclick="return confirm('ຢືນຢັນການລຶບ')">ລຶບ</a>
                </td>
            </tr>
        <?php endwhile; ?>

        <!-- ລວມຍອດ -->
        <tr class="table-success fw-bold">
            <td colspan="2" class="text-end">ຍອດລວມການຈອງ:</td>
            <td><?= number_format($totalAmount) ?> Kip</td>
            <td colspan="6"></td>
        </tr>
        </tbody>
    </table>
</div>

<?php require('footer.php'); ?>
