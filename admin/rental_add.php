<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php require('layout.php'); require('../db.php');

$customers = $conn->query("SELECT * FROM customer");
$employees = $conn->query("SELECT * FROM employees");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = $_POST['total_price'];
    $return_date = $_POST['return_date'];
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];

    $sql = "INSERT INTO rental (total_price, return_date, customer_id, employee_id)
            VALUES ('$total', '$return_date', '$customer_id', '$employee_id')";
    $conn->query($sql);
    header('Location: rental.php');
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">ເພີ່ມການໃຫ້ເຊົ່າ</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>ລາຄາລວມ</label>
                    <input type="number" step="0.01" name="total_price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>ວັນຄືນ</label>
                    <input type="date" name="return_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label>ລູກຄ້າ</label>
                    <select name="customer_id" class="form-control" required>
                        <?php while($c = $customers->fetch_assoc()): ?>
                            <option value="<?= $c['customer_id'] ?>"><?= $c['username'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                 <div class="col-md-4 mb-3">
                <label class="form-label">ຮູບພາບ</label>
                <input type="file" name="img" class="form-control">
            </div>
                <div class="mb-3">
                    <label>ພະນັກງານ</label>
                    <select name="employee_id" class="form-control" required>
                        <?php while($e = $employees->fetch_assoc()): ?>
                            <option value="<?= $e['id'] ?>"><?= $e['username'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
            </form>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
