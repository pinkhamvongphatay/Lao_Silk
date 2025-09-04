<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require('../db.php');

// รับ ID
if (!isset($_GET['id'])) {
    echo "ບໍ່ພົບ ID";
    exit;
}

$id = intval($_GET['id']);

// ดึงข้อมูลชุด
$sql = "SELECT * FROM dress WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    echo "ບໍ່ພົບຂໍ້ມູນ";
    exit;
}

$dress = $result->fetch_assoc();

// ดึงประเภทชุดทั้งหมด
$typeResult = $conn->query("SELECT * FROM type_dress");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $type_id = $_POST['type_id'];
    $updated_date = date("Y-m-d H:i:s");

    $img = $dress['img'];

    // หากอัพโหลดไฟล์ใหม่
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $newFilename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['img']['tmp_name'], "../images/" . $newFilename);

        // ลบไฟล์เก่า
        if (!empty($img) && file_exists("../images/" . $img)) {
            unlink("../images/" . $img);
        }

        $img = $newFilename;
    }

    // บันทึกข้อมูล
    $stmt = $conn->prepare("UPDATE dress SET size=?, color=?, length=?, width=?, qty=?, price=?, description=?, type_id=?, img=?, updated_date=? WHERE id=?");
    $stmt->bind_param("ssddiidsssi", $size, $color, $length, $width, $qty, $price, $description, $type_id, $img, $updated_date, $id);

    if ($stmt->execute()) {
        header("Location: dress.php");
        exit;
    } else {
        echo "ຜິດພາດ: " . $conn->error;
    }
}
?>

<?php require('layout.php'); ?>

<div class="container mt-4">
    <h2>ແກ້ໄຂຂໍ້ມູນຊຸດ</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-2"><label>ຂະໜາດ</label><input type="text" name="size" class="form-control" value="<?= $dress['size'] ?>"></div>
        <div class="mb-2"><label>ສີ</label><input type="text" name="color" class="form-control" value="<?= $dress['color'] ?>"></div>
        <div class="mb-2"><label>ຄວາມຍາວ</label><input type="number" name="length" class="form-control" value="<?= $dress['length'] ?>"></div>
        <div class="mb-2"><label>ຄວາມກວ້າງ</label><input type="number" name="width" class="form-control" value="<?= $dress['width'] ?>"></div>
        <div class="mb-2"><label>ຈຳນວນ</label><input type="number" name="qty" class="form-control" value="<?= $dress['qty'] ?>"></div>
        <div class="mb-2"><label>ລາຄາ</label><input type="number" step="0.01" name="price" class="form-control" value="<?= $dress['price'] ?>"></div>
        <div class="mb-2"><label>ຄຳອະທິບາຍ</label><textarea name="description" class="form-control"><?= $dress['description'] ?></textarea></div>
        <div class="mb-2">
            <label>ປະເພດ</label>
            <select name="type_id" class="form-control">
                <?php while($type = $typeResult->fetch_assoc()): ?>
                    <option value="<?= $type['id'] ?>" <?= $type['id'] == $dress['type_id'] ? 'selected' : '' ?>>
                        <?= $type['type'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>ຮູບພາບ</label><br>
            <?php if (!empty($dress['img'])): ?>
                <img src="../images/<?= $dress['img'] ?>" alt="thumbnail" width="100"><br>
            <?php endif; ?>
            <input type="file" name="img" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
        <a href="dress.php" class="btn btn-secondary">ຍ້ອນກັບ</a>
    </form>
</div>

<?php require('footer.php'); ?>
