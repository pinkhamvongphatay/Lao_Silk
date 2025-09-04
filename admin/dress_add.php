<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
// File: dress_add.php
require('layout.php');
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $type_id = $_POST['type_id'];
    $created_date = date('Y-m-d H:i:s');
    $updated_date = $created_date;

    // Upload image
    $img_name = '';
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $img_name = time() . '_' . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], '../images/' . $img_name);
    }

    $sql = "INSERT INTO dress (size, color, length, width, qty, price, img, updated_date, created_date, description, type_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddiissssi", $size, $color, $length, $width, $qty, $price, $img_name, $updated_date, $created_date, $description, $type_id);

    if ($stmt->execute()) {
        header("Location: dress.php");
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch dress types
$typeResult = $conn->query("SELECT * FROM type_dress");
?>

<div class="container mt-4">
    <h2>ເພີ່ມຊຸດ</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">ຂະໜາດ</label>
                <input type="text" name="size" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">ສີ</label>
                <input type="text" name="color" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">ຄວາມຍາວ</label>
                <input type="number" step="0.01" name="length" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">ຄວາມກວ້າງ</label>
                <input type="number" step="0.01" name="width" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">ຈຳນວນ</label>
                <input type="number" name="qty" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">ລາຄາ</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">ຮູບພາບ</label>
                <input type="file" name="img" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">ປະເພດຊຸດ</label>
                <select name="type_id" class="form-select" required>
                    <option value="">-- ເລືອກປະເພດ --</option>
                    <?php while ($type = $typeResult->fetch_assoc()): ?>
                        <option value="<?= $type['id'] ?>"><?= $type['type'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">ຄຳອະທິບາຍ</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
    </form>
</div>

<?php require('footer.php'); ?>