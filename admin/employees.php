<?php 
require('layout.php'); 
require('../db.php'); 
?>

<div class="container mt-4">
    <h1>ໜ້າຈັດການຂໍ້ມູນຂອງພະນັກງານ</h1>

    <!-- Employee Form -->
    <div class="card mt-3">
        <div class="card-header">ເພີ່ມພະນັກງານ</div>
        <div class="card-body">
            <form action="employees_add.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">ຊື່ຜູ້ໃຊ້</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ລະຫັດຜ່ານ</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ເບີໂທ</label>
                    <input type="text" name="tel" class="form-control">

                </div>
                <button type="submit" class="btn btn-primary">ເພີ່ມ</button>
            </form>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="card mt-4">
        <div class="card-header">ລາຍການພະນັກງານ</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ຊື່ຜູ້ໃຊ້</th>
                        <th>ເບີໂທ</th>
                        <th>ວັນທີສ້າງ</th>
                        <th>ວັນທີອັບເດດ</th>
                        <th>ຈັດການ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM employees ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['tel']}</td>
                                    <td>{$row['created_date']}</td>
                                    <td>{$row['updated_date']}</td>
                                    <td>
                                        <a href='employees_edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>ແກ້ໄຂ</a>
                                        <a href='employees_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"ຕ້ອງການລຶບຈິງບໍ?\")'>ລຶບ</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>ບໍ່ມີຂໍ້ມູນ</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>
