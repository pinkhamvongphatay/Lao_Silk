<?php
include "db.php";
session_start();

//check login
if(!isset($_SESSION['customer_id']))
{
    header('Location:login.php');
}

$customer_id = $_SESSION['customer_id'] ?? null;
if (!$customer_id) {
    showError("ກະລຸນາເຂົ້າສູ່ລະບົບກ່ອນ!", true);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['selected_dresses'])) {
    showError("ບໍ່ພົບຂໍ້ມູນທີ່ເລືອກເຊົ່າ!", true);
}

// รับค่าจากฟอร์ม
$selected_dresses = $_POST['selected_dresses'];
$total_price = $_POST['total_price'];
$start_rental_date = $_POST['start_rental_date'];

$today = date('Y-m-d');
if ($start_rental_date < $today) {
    showError("ບໍ່ສາມາດເລືອກວັນຍ້ອນຫຼັງໄດ້", false);
}

// ✅ return date = start + 2 days
$date = new DateTime($start_rental_date);
$date->modify('+2 days');
$return_date = $date->format('Y-m-d');

// บันทึกการเช่า
$sql = "INSERT INTO rental (customer_id, total_price, start_rental_date, return_date)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("idss", $customer_id, $total_price, $start_rental_date, $return_date);

if ($stmt->execute()) {
    $rental_id = $stmt->insert_id;
    $insert_detail = $conn->prepare("INSERT INTO rental_detail (rental_id, dress_id) VALUES (?, ?)");

    foreach ($selected_dresses as $dress_id) {
        $dress_id = intval($dress_id);
        $insert_detail->bind_param("ii", $rental_id, $dress_id);
        $insert_detail->execute();
    }

    $ids_in = implode(",", array_map('intval', $selected_dresses));
    $result = $conn->query("SELECT * FROM dress WHERE id IN ($ids_in)");
    renderConfirmation($rental_id, $start_rental_date, $return_date, $result, $total_price);
} else {
    showError("ຜິດພາດໃນການບັນທຶກການເຊົ່າ: " . $conn->error, true);
}

$conn->close();

// === Function แสดงข้อผิดพลาดแบบสวย ===
function showError($message, $goBackToHome = false) {
    ?>
    <!DOCTYPE html>
    <html lang="lo">
    <head>
        <meta charset="UTF-8">
        <title>ແຈ້ງເຕືອນ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
     <style>
            body {
                font-family: 'Noto Sans Lao', sans-serif;
                background-color: rgb(245, 236, 214);
            }
            .card {
                border-radius: 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .card-header {
                background-color: rgb(251, 248, 225);
                color: #000;
            }
            .btn-primary {
                background-color: #f5e5d3;
                border-color: #d63384;
                color: #000;
            }
            .btn-primary:hover {
                background-color: #eac7b0;
                border-color: #ad2065;
                color: #000;
            }
            .text-success {
                color: #a25c2f !important;
            }
        </style>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="alert alert-warning text-center">
                <h4><?= htmlspecialchars($message) ?></h4>
                <div class="mt-4">
                    <?php if ($goBackToHome): ?>
                        <a href="index.php" class="btn btn-secondary">ກັບໄປຫນ້າຫຼັກ</a>
                    <?php else: ?>
                        <a href="javascript:history.back()" class="btn btn-warning">ເລືອກວັນເຊົ່າໃໝ່</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// === Function แสดงการยืนยัน ===
function renderConfirmation($rental_id, $start_rental_date, $return_date, $result, $total_price) {
    ?>
    <!DOCTYPE html>
    <html lang="lo">
    <head>
        <meta charset="UTF-8">
        <title>ຢືນຢັນການເຊົ່າ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Noto Sans Lao', sans-serif;
                background-color: rgb(245, 236, 214);
            }
            .card {
                border-radius: 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .card-header {
                background-color: rgb(251, 248, 225);
                color: #000;
            }
            .btn-primary {
                background-color: #f5e5d3;
                border-color: #d63384;
                color: #000;
            }
            .btn-primary:hover {
                background-color: #eac7b0;
                border-color: #ad2065;
                color: #000;
            }
            .text-success {
                color: #a25c2f !important;
            }
        </style>
    </head>
    <body>
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header text-center">
                <h3>ຢືນຢັນການເຊົ່າຊຸດລາວ</h3>
            </div>
            <div class="card-body">
                <p><strong>ລະຫັດການເຊົ່າ:</strong> <?= $rental_id ?></p>
                <p><strong>ວັນເລີ່ມເຊົ່າ:</strong> <?= htmlspecialchars($start_rental_date) ?></p>
                <p><strong>ວັນຄືນ:</strong> <?= htmlspecialchars($return_date) ?></p>
                <hr>
                <h5 class="mb-3">ລາຍການຊຸດທີ່ເຊົ່າ</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ຮູບພາບ</th>
                                <th>ລາຍລະອຽດຊຸດ</th>
                                <th>ລາຄາ/2ມື້ (Kip)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td style="width: 130px;">
                                        <img src="images/<?= htmlspecialchars($row['img']) ?>" class="img-fluid rounded">
                                    </td>
                                    <td>
                                        <strong>ສີ:</strong> <?= htmlspecialchars($row['color']) ?><br>
                                        <strong>ໄຊສ໌:</strong> <?= htmlspecialchars($row['size']) ?><br>
                                        <strong>ຄວາມຍາວ:</strong> <?= htmlspecialchars($row['length']) ?> cm<br>
                                        <strong>ຄວາມກວ້າງ:</strong> <?= htmlspecialchars($row['width']) ?> cm<br>
                                        <strong>ຄຳອະທິບາຍ:</strong> <?= htmlspecialchars($row['description']) ?>
                                    </td>
                                    <td><?= number_format($row['price']) ?></td>
                                </tr>
                                
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <h5>ລາຄາລວມທັງໝົດ: <span class="text-success fw-bold"><?= number_format($total_price) ?> Kip</span></h5>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="index.php" class="btn btn-primary">ກັບໄປຫນ້າຫຼັກ</a>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}
?>
