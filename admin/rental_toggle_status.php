<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require('../db.php');

// ตรวจสอบว่าได้รับ POST และมีค่า id มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // ดึงสถานะปัจจุบันจากฐานข้อมูล
    $sql = "SELECT status FROM rental WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['status'];

        // เปลี่ยนสถานะ
        if ($currentStatus === 'ຈອງແລ້ວ') {
            $newStatus = 'ຍັງບໍ່ຈອງ';
        } else {
            $newStatus = 'ຈອງແລ້ວ';
        }

        // อัปเดตสถานะใหม่ลงฐานข้อมูล
        $updateSql = "UPDATE rental SET status = '$newStatus' WHERE id = $id";
        $conn->query($updateSql);
    }
}

// กลับไปหน้า rental หรือ rental_report หลังจากกดปุ่ม
header('Location: rental.php');
exit;
