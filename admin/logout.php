<?php
session_start();
session_unset();  // เคลียร์ session ทั้งหมด
session_destroy(); // ทำลาย session

// ส่งไปหน้า login.php พร้อมข้อความ
header("Location: login.php?message=loggedout");
exit();
