
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php 
require('layout.php'); 
require('../db.php'); 

?>

<div class="container mt-4">
    <h1>ໜ້າຈັດການຂໍ້ມູນຂອງພະນັກງານ</h1>

    <?php 
    // แก้ไขการเช็ค role - ลบ whitespace และแปลงเป็น lowercase
    $userRole = isset($_SESSION['role']) ? trim(strtolower($_SESSION['role'])) : '';
    $canManage = ($userRole === 'admin' || $userRole === 'owner');
    
    if ($canManage): 
    ?>
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
                <div class="mb-3">
                    <label class="form-label">ສິດຂອງຜູ້ໃຊ້</label>
                    <select name="role" class="form-control">
                        <option value="staff">ພະນັກງານ</option>
                        <option value="admin">Admin</option>
                        <option value="owner">ເຈົ້າຂອງຮ້ານ</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">ເພີ່ມ</button>
            </form>
        </div>
    </div>
    <!-- ถ้าไม่มีสิทธิ์ -->
    <?php else: ?>
  
    <?php endif; ?>

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
                        <th>ສິດຜູ້ໃຊ້</th>
                        <th>ວັນທີສ້າງ</th>
                        <th>ວັນທີອັບເດດ</th>
                        <?php if ($canManage): ?>
                        <th>ຈັດການ</th>
                        <?php else: ?>
                        <!-- ไม่แสดงคอลัมน์จัดการ -->
                        <th style="display:none;">ຈັດການ
                        </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM employees ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // แปลง role
                            if ($row['role'] === 'staff') {
                                $roleLabel = 'ພະນັກງານ';
                            } elseif ($row['role'] === 'admin') {
                                $roleLabel = 'Admin';
                            } elseif ($row['role'] === 'owner') {
                                $roleLabel = 'ເຈົ້າຂອງຮ້ານ';
                            } else {
                                $roleLabel = 'ພະນັກງານ';
                            }
                            
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['tel']}</td>
                                    <td>{$roleLabel}</td>
                                    <td>{$row['created_date']}</td>
                                    <td>{$row['updated_date']}</td>";
                            
                            // แสดงปุ่มจัดการเฉพาะ admin และ owner + debug
                            if ($canManage) {
                                echo "<td>
                                        <a href='employees_edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>ແກ້ໄຂ</a>
                                        <a href='employees_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"ຕ້ອງການລຶບຈິງບໍ?\")'>ລຶບ</a>
                                      </td>";
                            } else {
                                // Debug: แสดงเหตุผลที่ไม่มีปุ่ม
                                echo "<td style='display:none;'>
                                        <small class='text-danger'>❌ ไม่มีสิทธิ์: Role = [{$userRole}]</small>
                                      </td>";
                            }
                            
                            echo "</tr>";
                        }
                    } else {
                        $colspan = $canManage ? '7' : '6';
                        echo "<tr><td colspan='{$colspan}' class='text-center'>ບໍ່ມີຂໍ້ມູນ</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require('footer.php'); ?>