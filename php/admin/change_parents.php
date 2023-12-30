<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/list_class.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher.php">Giáo viên</a></li>
                <li><a href="/PHP/BTL/php/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/student.php">Học sinh</a></li>
                <li><a href="/PHP/BTL/php/parents.php">Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/admin/registration_form.php">Đăng kí học</a></li>
            </ul>
        </div>
    </header>
    <div class="table">
    <?php
        require '../connect.php';
        mysqli_set_charset($conn, 'UTF8');
        $sql = "SELECT * FROM phu_huynh";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID Phụ huynh</th>
                        <th>Tên Phụ huynh</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Số điện thoại</th>
                    </tr>";
        
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id_phu_huynh"] . "</td>
                        <td>" . $row["ten_phu_huynh"] . "</td>
                        <td>" . $row["ngay_sinh_ph"] . "</td>
                        <td>" . $row["gioi_tinh_ph"] . "</td>
                        <td>" . $row["dien_thoai_ph"] . "</td>
                        <td>
                            <form action='' method='get'>
                                <input type='hidden' name='id_phu_huynh' value='" . $row["id_phu_huynh"] . "'>
                                <input type='submit' value='Chỉnh sửa'>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "Không có thông tin để hiển thị";
        }
    ?>
    </div>
    <?php
        // Kiểm tra nếu id_lop được truyền vào từ trang danh sách
        if (isset($_GET['id_phu_huynh'])) {
            $id_phu_huynh = $_GET['id_phu_huynh'];
        
            // Lấy thông tin của dòng cần chỉnh sửa từ id_phu_huynh
            $sql = "SELECT * FROM phu_huynh WHERE id_phu_huynh = '$id_phu_huynh'";
            $result = $conn->query($sql);
        
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Hiển thị form để người dùng có thể chỉnh sửa thông tin của dòng này
    ?>

    <form class="change_class" action="" method="post">
        <h1 style = "text-align:center">Chỉnh sửa thông tin phụ huynh</h1>
        <input type="hidden" name="id_phu_huynh" value="<?php echo $row['id_phu_huynh']; ?>">
        <label for="ten_phu_huynh">Tên phụ huynh</label>
        <input type="text" id="ten_phu_huynh" name="ten_phu_huynh" value="<?php echo $row['ten_phu_huynh']; ?>"><br><br>
        <label for="ngay_sinh_ph">Ngày sinh:</label>
        <input type="text" id="ngay_sinh_ph" name="ngay_sinh_ph" value="<?php echo $row['ngay_sinh_ph']; ?>"><br><br>
        <label for="gioi_tinh_ph">Giới tính:</label>
        <input type="text" id="gioi_tinh_ph" name="gioi_tinh_ph" value="<?php echo $row['gioi_tinh_ph']; ?>"><br><br>
        <label for="dien_thoai_ph">Điện thoại:</label>
        <input type="text" id="dien_thoai_ph" name="dien_thoai_ph" value="<?php echo $row['dien_thoai_ph']; ?>"><br><br>
        <input type="submit" value="Lưu thay đổi">
    </form>

    <?php
            } else {
                echo "Không tìm thấy thông tin lớp cần chỉnh sửa";
            }
        }

    ?>

    <?php
        if (isset($_POST['id_phu_huynh'])) {
            $ten_phu_huynh = $_POST['ten_phu_huynh'];
            $ngay_sinh_ph = $_POST['ngay_sinh_ph'];
            $gioi_tinh_ph = $_POST['gioi_tinh_ph'];
            $dien_thoai_ph = $_POST['dien_thoai_ph'];

        
            $sql = "UPDATE phu_huynh SET ten_phu_huynh = '$ten_phu_huynh', ngay_sinh_ph = '$ngay_sinh_ph', gioi_tinh_ph ='$gioi_tinh_ph', dien_thoai_ph ='$dien_thoai_ph' WHERE id_phu_huynh = '$id_phu_huynh'";
            
            if ($conn->query($sql) === TRUE) {
                echo "<h2 style ='text-align:center; color:white; margin: 50px 0'>Cập nhật thông tin giáo viên thành công</h2>";
            } else {
                echo "Lỗi khi cập nhật thông tin giáo viên: " . $conn->error;
            }
        }
        $conn->close();
    ?>
</body>
</html>