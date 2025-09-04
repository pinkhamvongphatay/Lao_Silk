<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า
    $username = trim($_POST['username']);
    $password_raw = trim($_POST['password']);
    $tel = trim($_POST['tel']);
    $role = trim($_POST['role']);

    // ✅ ตรวจว่าช่องสำคัญว่างไหม
    if (empty($username) || empty($password_raw) || empty($role)) {
        // กลับไปหน้า employees.php พร้อม error
        header("Location: employees.php?error=1");
        exit();
    }

    // ✅ เข้ารหัสรหัสผ่าน
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // ✅ เพิ่มข้อมูล
    $stmt = $conn->prepare("INSERT INTO employees (username, password, tel, role, created_date, updated_date) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssss", $username, $password, $tel, $role);

    if ($stmt->execute()) {
        header("Location: employees.php?success=1");
    } else {
        header("Location: employees.php?error=2");
    }

    exit();
}
?>
