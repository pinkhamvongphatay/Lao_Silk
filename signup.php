<?php
// เชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";
$password = "";
$dbname = "laosilk";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// เมื่อมีการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_raw = $_POST['password'];
    $tel = trim($_POST['tel']);

    // ตรวจสอบว่าซ้ำไหม
    $check_sql = "SELECT * FROM customer WHERE username = ? OR tel = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $tel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "ຊື່ຜູ້ໃຊ້ ຫຼື ເບີໂທນີ້ມີຢູ່ແລ້ວ!";
    } else {
        // บันทึกใหม่
        $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO customer (username, password, tel, created_date, updated_date) 
                       VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $username, $password_hash, $tel);

        if ($stmt->execute()) {
            // สำเร็จ -> ไปหน้า login.php
            header("Location: login.php");
            exit();
        } else {
            $error = "ຜິດພາດໃນການສະໝັກ: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <title>ສະໝັກສະມາຊິກ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ฟอนต์ Noto Sans Lao -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Lao', sans-serif;
            background-color: rgb(250, 251, 252);
        }
        h2 {
            color: rgb(43, 41, 43);
            font-weight: bold;
        }
        .btn-primary {
            background-color: rgb(242, 163, 203);
            border-color: rgb(246, 166, 206);
        }
        .btn-primary:hover {
            background-color: #c22574;
            border-color: #c22574;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #c22574;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">ສະໝັກສະມາຊິກ</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
            <input type="text" name="username" class="form-control" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">ສ້າງລະຫັດຜ່ານ</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ເບີໂທ</label>
            <input type="text" name="tel" class="form-control" required value="<?= isset($tel) ? htmlspecialchars($tel) : '' ?>">
        </div>

        <button type="submit" class="btn btn-primary w-100">ສະໝັກ</button>
    </form>

    <div class="back-link">
        <a href="login.php">ມີບັນຊີແລ້ວ? ກັບໄປທີ່ຫນ້າລັອກອິນ</a>
    </div>
</div>
</body>
</html>
