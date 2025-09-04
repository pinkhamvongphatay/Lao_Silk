<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Lao', sans-serif;
            background-color: #f8f9fa;
        }
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .dashboard-header {
            background: linear-gradient(90deg, #e89abe, #f7c1dc);
            color: white;
            padding: 30px 20px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .dashboard-header h2 {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

<div class="dashboard-header text-center">
    <h2><i class="bi bi-speedometer2"></i> ຫນ້າຄວບຄຸມລະບົບ Admin</h2>
    <p>ສະບາຍດີ, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
</div>

<div class="container mt-5">
    <div class="row justify-content-center g-4">
        <?php
        $cards = [
            ["title" => "ຈັດການລູກຄ້າ", "icon" => "bi-person", "link" => "customer.php"],
            ["title" => "ຈັດການພະນັກງານ", "icon" => "bi-people", "link" => "employees.php"],
            ["title" => "ຈັດການຊຸດ", "icon" => "bi-bag", "link" => "dress.php"],
            ["title" => "ປະເພດຊຸດ", "icon" => "bi-tags", "link" => "dress_type.php"],
            ["title" => "ການເຊົ່າຊຸດ", "icon" => "bi-calendar-check", "link" => "rental.php"],
        ];

        foreach ($cards as $card) {
            echo '
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <i class="bi ' . $card["icon"] . ' fs-1 text-primary mb-2"></i>
                        <h6 class="card-title">' . $card["title"] . '</h6>
                        <a href="' . $card["link"] . '" class="btn btn-outline-primary mt-2">ເຂົ້າໄປ</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <div class="text-center mt-5">
        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

</body>
</html>
