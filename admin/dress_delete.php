<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require('../db.php');

// ตรวจสอบว่ามี ID ที่ส่งมาหรือไม่
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ดึงชื่อไฟล์รูปภาพก่อนลบ
    $selectImg = "SELECT img FROM dress WHERE id = $id";
    $imgResult = $conn->query($selectImg);
    if ($imgResult && $imgResult->num_rows > 0) {
        $imgRow = $imgResult->fetch_assoc();
        $imgFile = $imgRow['img'];

        // ลบรูปภาพจากโฟลเดอร์ถ้ามี
        if (!empty($imgFile)) {
            $imgPath = "../images/" . $imgFile;
            if (file_exists($imgPath)) {
                unlink($imgPath); // ลบไฟล์รูปภาพ
            }
        }
    }

    // ลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM dress WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dress.php"); // กลับไปหน้ารายการ
        exit();
    } else {
        echo "ຜິດພາດໃນການລຶບ: " . $conn->error;
    }
} else {
    echo "ບໍ່ພົບ ID ທີ່ຈະລຶບ";
}
?>
