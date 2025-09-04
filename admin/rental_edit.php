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

$id = $_GET['id'];
$data = $conn->query("
    SELECT rental.*, customer.username 
    FROM rental 
    JOIN customer ON customer.customer_id = rental.customer_id 
    WHERE id=$id
")->fetch_assoc();
$employees = $conn->query("SELECT * FROM employees");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_price = $_POST['total_price'];
    $return_date = $_POST['return_date'];
    $employee_id = $_POST['employee_id'];

    $sql = "UPDATE rental SET 
                total_price='$total_price', 
                return_date='$return_date',
                employee_id='$employee_id',
                updated_date=NOW()
            WHERE id=$id";

    $conn->query($sql);
    header('Location: rental.php');
    exit;
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ແກ້ໄຂການໃຫ້ເຊົ່າ</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>ລາຄາລວມ</label>
                    <input type="number" step="0.01" name="total_price" class="form-control" 
                           value="<?= htmlspecialchars($data['total_price']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>ວັນຄືນ</label>
                    <input type="date" name="return_date" class="form-control" 
                           value="<?= htmlspecialchars($data['return_date']) ?>">
                </div>
                <div class="mb-3">
                    <label>ID ລູກຄ້າ</label>
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($data['customer_id']) ?>" readonly>
                    <!-- ซ่อนค่า customer_id เพื่อให้ยังส่งไปกับฟอร์ม -->
                    <input type="hidden" name="customer_id" value="<?= htmlspecialchars($data['customer_id']) ?>">
                </div>
                <div class="mb-3"> 
                    <label>ຊື່ລູກຄ້າ</label>
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($data['username']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>ພະນັກງານ</label>
                    <select name="employee_id" class="form-control">
                        <?php while($e = $employees->fetch_assoc()): ?>
                            <option value="<?= $e['id'] ?>" <?= $e['id'] == $data['employee_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['username']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success">ບັນທຶກ</button>
                <a href="rental.php" class="btn btn-secondary">ຍ້ອນກັບ</a>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
