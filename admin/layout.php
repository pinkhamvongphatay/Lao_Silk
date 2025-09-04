<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts Lao -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao+Looped:wght@100..900&family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: "Noto Sans Lao", sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background-color:rgb(247, 170, 208); /* Pink */
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;985987
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color:rgb(253, 183, 220); /* Darker Pink */
            text-decoration: none;
        }
        .sidebar a i {
            font-size: 18px;
            margin-right: 10px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa; /* Light Gray */
            overflow-y: auto;
        }
        .logo {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-print-none">
    <div class="logo">🌸 ເຈ່ນນີ້ເຊົ່າຊຸດໄຫມ</div>
    <a href="index.php"><i class="bi bi-house-door-fill"></i>ໜ້າຫລັກ</a>
    <a href="customer.php"><i class="bi bi-people-fill"></i>ຂໍ້ມູນລູກຄ້າ</a>
    <a href="employees.php"><i class="bi bi-person-badge-fill"></i>ຂໍ້ມູນພະນັກງານ</a>
    <a href="dress.php"><i class="bi bi-box-seam-fill"></i>ຂໍ້ມູນຊຸດໄຫມ</a>
    <a href="dress_type.php"  ><i class="bi bi-tags-fill"></i>ຂໍ້ມູນປະເພດຊຸດໄຫມ</a>
    <a href="rental.php"><i class="bi bi-bag-fill"></i>ຂໍ້ມູນການເຊົ່າຊຸດໄຫມ</a>
</div>

<!-- Main Content -->
<div class="content">
<!-- เนื้อหาของแต่ละหน้าจะมาแสดงที่นี่ -->

