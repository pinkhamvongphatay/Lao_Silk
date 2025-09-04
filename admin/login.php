<?php
session_start();
include '../db.php';

// สำหรับทดสอบ hash password (ไม่จำเป็นต้องใช้ในโปรแกรมจริง)
$hashedPassword = password_hash("12345", PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // เตรียมคำสั่ง SQL เพื่อป้องกัน SQL Injection และดึง role มาด้วย
    $stmt = $conn->prepare("SELECT id, username, password, role FROM employees WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            // ตั้งค่า Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // เปลี่ยนเส้นทางไปหน้าแรก
            header("Location: index.php");
            exit();
        } else {
            $error = "❌ ລະຫັດບໍ່ຖືກຕ້ອງ";
        }
    } else {
        $error = "❌ ບໍ່ພົບບັນຊີຜູ້ໃຊ້";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Noto Sans Lao', sans-serif;
        } body
    </style>
</head>
<body style="background-color: #f7f7f7;">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-center bg-light">
                    <h4>🔐 Admin Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="post" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">👤 Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">🔑 Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #E89ABE; color: white;">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center text-muted small">
                    &copy; <?php echo date("Y"); ?> | Rental System
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
