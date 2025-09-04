<?php require('layout.php'); ?>
<?php require('rental_silk/db.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $date = date("Y-m-d H:i:s");

    // ตรวจสอบว่ามี username ซ้ำหรือไม่
    $check = $conn->query("SELECT * FROM customer WHERE username = '$username'");
    if ($check->num_rows > 0) {
        echo "<div class='alert alert-danger'>Username นี้ถูกใช้แล้ว</div>";
    } else {
        $sql = "INSERT INTO customer (username, password, updated_date)
                VALUES ('$username', '$password', '$date')";
        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>สมัครสมาชิกเรียบร้อยแล้ว</div>";
        } else {
            echo "<div class='alert alert-danger'>เกิดข้อผิดพลาด: " . $conn->error . "</div>";
        }
    }
}
?>

<div class="container mt-4">
    <h2>ຟອມສະໝັກສະມາຊິກ</h2>
    <form method="post">
        <div class="mb-3">
            <label>ຊື່ຜູ້ໃຊ້ (Username)</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ລະຫັດຜ່ານ (Password)</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">ສະໝັກ</button>
    </form>
</div>

<?php require('footer.php'); ?>
