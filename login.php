<?php
session_start();

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_input = $_POST['password'];
    
    $sql = "SELECT * FROM customer WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password_input, $row['password'])) {
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "ລະຫັດບໍ່ຖືກຕ້ອງ!";
        }
    } else {
        $error = "ບໍ່ພົບຜູ້ໃຊ້!";
    }
}
?>

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <title>ລັອກອິນ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- โหลดฟอนต์ Noto Sans Lao -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Lao', sans-serif;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 450px;
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            margin-top: 80px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        h2 {
            font-weight: bold;
            color: #c22574;
        }
        .btn-custom {
            background-color: rgb(242, 163, 203);
            border-color: rgb(246, 166, 206);
            color: white;
        }
        .btn-custom:hover {
            background-color: #c22574;
            border-color: #c22574;
            color: white;
        }
        .text-link {
            color: #c22574;
            text-decoration: none;
        }
        .text-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-container">
        <h2 class="text-center mb-4">ລັອກອິນ</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">ລະຫັດຜ່ານ</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">ເຂົ້າລະບົບ</button>
        </form>

        <div class="text-center mt-3">
            <a class="text-link" href="signup.php">ຍັງບໍ່ມີບັນຊີ? ສະໝັກທີ່ນີ້</a>
        </div>
    </div>
</div>
</body>
</html>
