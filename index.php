<?php require "header.php"; ?>

<!-- ฟอนต์ Noto Sans Lao -->
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao&display=swap" rel="stylesheet">

<style>
  /* ฟอนต์ทั้งหน้า */
  body, h1, h2, p, button, .price, .form-check-label {
    font-family: 'Noto Sans Lao', sans-serif;
  }

  /* พื้นหลังครีม-ขาว */
  body {
    background: linear-gradient(to bottom, #fef5e7, #ffffff);
  }

  .hero-wrap {
    background-color: #fdf1dc;
    position: relative;
  }

  .overlay {
    background: rgba(245, 222, 179, 0.4);
  }

  /* ปุ่มเช่าใหญ่สีครีม-น้ำตาลทอง */
  .btn-rent {
    background-color: #b97a3d;
    border: none;
    color: white;
    font-size: 1.4rem;
    padding: 14px 45px;
    border-radius: 999px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(185, 122, 61, 0.2);
    transition: all 0.3s ease;
  }

  .btn-rent:hover {
    background-color: #a46531;
    box-shadow: 0 6px 14px rgba(164, 101, 49, 0.3);
  }

  /* Card ชุด */
  .car-wrap {
    background-color: #fef5e7;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .car-wrap:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(185, 122, 61, 0.2);
  }

  .img {
    background-size: cover;
    background-position: center;
    height: 250px;
  }

  .text.p-3 {
    background-color: #fff;
    border-top: 1px solid #f3e0c8;
  }

  .price {
    color: #b97a3d;
    font-weight: bold;
  }

  /* ปุ่ม Checkbox แบบปุ่มกด สวยงาม */
  .form-check {
    margin-top: 12px;
    text-align: center;
  }

  .form-check-input.custom-checkbox {
    display: none;
  }

  .form-check-label.custom-label {
    display: inline-block;
    background-color: #fff;
    color: #a46531;
    border: 2px solid #b97a3d;
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .form-check-input.custom-checkbox:checked + .custom-label {
    background-color: #b97a3d;
    color: white;
  }

  .form-check-label.custom-label:hover {
    background-color: #f5e5d3;
  }

  /* รายละเอียดชุดในการ์ด */
  .dress-details {
    list-style: none;
    padding-left: 0;
    color: #6e5845;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 10px;
  }

  .dress-details li {
    margin-bottom: 4px;
  }
</style>

<form action="rent_dress.php" method="POST">
  <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/lao_silk.jpeg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text justify-content-center align-items-center">
        <div class="col-lg-8 ftco-animate">
          <div class="text w-100 text-center mb-md-5 pb-md-5">
            <h1 class="mb-4">Fast &amp; Easy Way To Rent A Dress</h1>
            <p style="font-size: 18px;">ຄົ້ນຫາຊຸດຜ້າໄຫມລາວດັ້ງເດີມໄດ້ງ່າຍ ແລະ ເຊົ່າໄດ້ທັນທີ</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-no-pt bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          <span class="subheading">ຊຸດທີ່ນຳສະເໜີ</span>
          <h2 class="mb-2">New Collection</h2>
        </div>
      </div>

      <div class="row">
        <?php
        include "db.php";

        $sql = "SELECT * FROM dress";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $img = $row['img'];
          $color = $row['color'];
          $size = $row['size'];
          $length = $row['length'];
          $width = $row['width'];
          $qty = $row['qty'];
          $price = $row['price'];
          $type_id = $row['type_id'];
          $description = $row['description'];
        ?>
          <div class="col-md-4 mb-4">
            <div class="car-wrap rounded ftco-animate shadow-sm">
              <div class="img rounded d-flex align-items-end" style="background-image: url('images/<?php echo $img; ?>');"></div>
              <div class="text p-3">
                <h2 class="mb-2"><?= htmlspecialchars($color) ?> (<?= htmlspecialchars($type_id) ?>)</h2>
                
                <ul class="dress-details">
                  <li><strong>Size:</strong> <?= htmlspecialchars($size) ?></li>
                  <li><strong>Length:</strong> <?= htmlspecialchars($length) ?> cm</li>
                  <li><strong>Width:</strong> <?= htmlspecialchars($width) ?> cm</li>
                  <li><strong>Qty available:</strong> <?= htmlspecialchars($qty) ?></li>
                  <li><strong>Description:</strong> <?= htmlspecialchars($description) ?></li>
                </ul>

                <div class="d-flex mb-3">
                  <p class="price ml-auto"><?= number_format($price) ?> Kip<span>/2day</span></p>
                </div>

                <div class="form-check">
                  <input class="form-check-input custom-checkbox" type="checkbox" name="selected_dresses[]" value="<?= $id ?>" id="dress<?= $id ?>">
                  <label class="form-check-label custom-label" for="dress<?= $id ?>">ເລືອກຊຸດນີ້</label>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-rent btn-lg">ເຊົ່າຊຸດທີ່ເລືອກ</button>
      </div>
    </div>
  </section>
</form>

<?php require "footer.php"; ?>
