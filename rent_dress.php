<?php
require "header.php";
include "db.php";

// ตรวจสอบว่ามีการเลือกชุดหรือไม่
if (!isset($_POST['selected_dresses']) || empty($_POST['selected_dresses'])) {
    echo "<div class='container mt-5'><div class='alert alert-warning text-center'>ກະລຸນາເລືອກຊຸດກ່ອນເຊົ່າ</div></div>";
    require "footer.php";
    exit();
}

$selected_ids = $_POST['selected_dresses'];
$id_list = implode(",", array_map('intval', $selected_ids));

// ดึงข้อมูลชุดจากฐานข้อมูล
$sql = "SELECT * FROM dress WHERE id IN ($id_list)";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
  <h2 class="mb-4 text-center">ເລືອກຊຸດນີ້</h2>

  <!-- ต้องเพิ่ม enctype="multipart/form-data" เพื่อให้ส่งไฟล์ได้ -->
  <form action="confirm_rent.php" method="POST" enctype="multipart/form-data">
    <div class="row">
      <?php
      $total = 0;
      while ($row = mysqli_fetch_assoc($result)) {
          $total += $row['price'];
      ?>
        <div class="col-md-4">
          <div class="card mb-4 shadow">
            <img src="images/<?php echo $row['img']; ?>" class="card-img-top" alt="dress image">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['color']; ?></h5>
              <p class="card-text">ລາຄາ: <?php echo number_format($row['price']); ?> Kip/2ມື້</p>
              <input type="hidden" name="selected_dresses[]" value="<?php echo $row['id']; ?>">
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="text-center mt-4">
      <p><strong>ລວມ:</strong> <?php echo number_format($total); ?> Kip</p>
      <input type="hidden" name="total_price" value="<?php echo $total; ?>">

      <!-- วันที่เริ่มเช่า -->
      <label for="start_rental_date"><strong>ວັນທີເລີ່ມເຊົ່າຊຸດ:</strong></label>
      <input type="date" name="start_rental_date" id="start_rental_date" class="form-control mb-3"
             required style="max-width: 300px; margin: auto;"
             value="<?php echo date('Y-m-d'); ?>">

      <button type="submit" class="btn btn-primary btn-lg mt-3">ຍືນຍັນການເຊົ່າຊຸດ</button>
    </div>
  </form>
</div>

<?php require "footer.php"; ?>
