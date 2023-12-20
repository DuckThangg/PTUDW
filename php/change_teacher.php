<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/list_class.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher.php">Giáo viên</a></li>
                <li><a href="/PHP/BTL/php/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/student.php">Học sinh</a></li>
                <li><a href="">Phụ huynh</a></li>
                <li><a href="">Đăng kí học</a></li>
            </ul>
        </div>
    </header>
    <div class="table">
    <?php
        require 'connect.php';
        mysqli_set_charset($conn, 'UTF8');
        $sql = "SELECT * FROM giao_vien";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID giáo viên</th>
                        <th>Tên giáo viên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Số điện thoại</th>
                        <th>Lớp phụ trách</th>
                    </tr>";
        
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id_giao_vien"] . "</td>
                        <td>" . $row["ten_giao_vien"] . "</td>
                        <td>" . $row["ngay_sinh_gv"] . "</td>
                        <td>" . $row["gioi_tinh_gv"] . "</td>
                        <td>" . $row["dien_thoai_gv"] . "</td>
                        <td>" . $row["lop_phu_trach"] . "</td>
                        <td>
                            <form action='' method='get'>
                                <input type='hidden' name='id_giao_vien' value='" . $row["id_giao_vien"] . "'>
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
        if (isset($_GET['id_giao_vien'])) {
            $id_giao_vien = $_GET['id_giao_vien'];
        
            // Lấy thông tin của dòng cần chỉnh sửa từ id_giao_vien
            $sql = "SELECT * FROM giao_vien WHERE id_giao_vien = '$id_giao_vien'";
            $result = $conn->query($sql);
        
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Hiển thị form để người dùng có thể chỉnh sửa thông tin của dòng này
    ?>

    <form class="change_class" action="" method="post">
        <h1 style = "text-align:center">Chỉnh sửa thông tin giáo viên</h1>
        <input type="hidden" name="id_giao_vien" value="<?php echo $row['id_giao_vien']; ?>">
        <label for="ten_giao_vien">Tên giáo viên</label>
        <input type="text" id="ten_giao_vien" name="ten_giao_vien" value="<?php echo $row['ten_giao_vien']; ?>"><br><br>
        <label for="ngay_sinh_gv">Ngày sinh:</label>
        <input type="text" id="ngay_sinh_gv" name="ngay_sinh_gv" value="<?php echo $row['ngay_sinh_gv']; ?>"><br><br>
        <label for="gioi_tinh_gv">Giới tính:</label>
        <input type="text" id="gioi_tinh_gv" name="gioi_tinh_gv" value="<?php echo $row['gioi_tinh_gv']; ?>"><br><br>
        <label for="dien_thoai_gv">Điện thoại:</label>
        <input type="text" id="dien_thoai_gv" name="dien_thoai_gv" value="<?php echo $row['dien_thoai_gv']; ?>"><br><br>
        <input type="submit" value="Lưu thay đổi">
    </form>

    <?php
            } else {
                echo "Không tìm thấy thông tin lớp cần chỉnh sửa";
            }
        }

    ?>

    <?php
        if (isset($_POST['id_giao_vien'])) {
            $ten_giao_vien = $_POST['ten_giao_vien'];
            $ngay_sinh_gv = $_POST['ngay_sinh_gv'];
            $gioi_tinh_gv = $_POST['gioi_tinh_gv'];
            $dien_thoai_gv = $_POST['dien_thoai_gv'];

        
            $sql = "UPDATE giao_vien SET ten_giao_vien = '$ten_giao_vien', ngay_sinh_gv = '$ngay_sinh_gv', gioi_tinh_gv ='$gioi_tinh_gv', dien_thoai_gv ='$dien_thoai_gv' WHERE id_giao_vien = '$id_giao_vien'";
        
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