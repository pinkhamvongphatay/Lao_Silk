<?php
require "header.php";
include "db.php";

// ตรวจสอบว่ามี id ของชุดหรือไม่
if (!isset($_GET['id'])) {
    echo "<div class='container mt-5'><p>No dress selected.</p></div>";
    require "footer.php";
    exit();
}

$dress_id = $_GET['id'];

// ดึงข้อมูลชุดจากฐานข้อมูล
$sql = "SELECT * FROM dress WHERE id = $dress_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<div class='container mt-5'><p>Dress not found.</p></div>";
    require "footer.php";
    exit();
}

$dress = mysqli_fetch_assoc($result);

// ถ้ามีการยืนยันการเช่า
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $return_date = $_POST['return_date'];
    $price_per_day = $dress['price'];

    // คำนวณจำนวนวัน
    $today = date('Y-m-d');
    $days = (strtotime($return_date) - strtotime($today)) / (60 * 60 * 24);
    if ($days < 1) $days = 1;

    $total_price = $price_per_day * $days;

    // บันทึกลงฐานข้อมูล
    $insert = "INSERT INTO rental (total_price, return_date, customer_id) 
               VALUES ('$total_price', '$return_date', '$customer_id')";

    if (mysqli_query($conn, $insert)) {
        echo "<div class='container mt-5'><p class='text-success'>Rental confirmed! Total price: " . number_format($total_price) . " Kip</p></div>";
    } else {
        echo "<div class='container mt-5'><p class='text-danger'>Error: " . mysqli_error($conn) . "</p></div>";
    }

    require "footer.php";
    exit();
}
?>

<div class="container mt-5 mb-5">
    <h2>Confirm Rental</h2>
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?php echo $dress['img']; ?>" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <form method="POST">
                <p><strong>Description:</strong> <?php echo $dress['description']; ?></p>
                <p><strong>Price per day:</strong> <?php echo number_format($dress['price']); ?> Kip</p>
                
                <div class="form-group">
                    <label for="customer_id">Customer ID:</label>
                    <input type="number" name="customer_id" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="return_date">Return Date:</label>
                    <input type="date" name="return_date" class="form-control" required>
                </div>

                <!-- แสดง QR ให้ลูกค้าแสกนจ่าย -->
                <div class="mt-4 mb-4 text-center">
                    <h5>ชำระเงินโดยสแกน QR ด้านล่าง</h5>
                    <img src="images/payment_qr.jpeg" alt="QR Payment" class="img-fluid border rounded" style="max-width: 300px;">
                    <p class="mt-2 text-muted">หลังจากชำระแล้ว กรุณากดยืนยันการเช่า</p>
                </div>

                <button type="submit" class="btn btn-success mt-3">Confirm</button>
            </form>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
