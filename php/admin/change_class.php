<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/list_class.css">
    <title>Document</title>
    <style>
        #studentTable {
            border-collapse: collapse;
        }

        th,td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

    </style>
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
        $sql = "SELECT * FROM lop";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID Lớp</th>
                        <th>Giáo viên phụ trách</th>
                        <th>Tên lớp</th>
                        <th>Sĩ số</th>
                        <th>Chỉnh sửa</th>
                    </tr>";
        
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id_lop"] . "</td>
                        <td>" . $row["gv_phu_trach"] . "</td>
                        <td>" . $row["ten_lop"] . "</td>
                        <td>" . $row["so_luong_hs"] . "</td>
                        <td>
                            <form action='' method='get'>
                                <input type='hidden' name='id_lop' value='" . $row["id_lop"] . "'>
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
        if (isset($_GET['id_lop'])) {
            $id_lop = $_GET['id_lop'];
        
            // Lấy thông tin của dòng cần chỉnh sửa từ id_lop
            $sql = "SELECT * FROM lop WHERE id_lop = '$id_lop'";
            $result = $conn->query($sql);
        
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Hiển thị form để người dùng có thể chỉnh sửa thông tin của dòng này
    ?>

    <form class="change_class" action="" method="post">
        <h1 style = "text-align:center">Chỉnh sửa thông tin lớp</h1>
        <input type="hidden" name="id_lop" value="<?php echo $row['id_lop']; ?>">
        <label for="gv_phu_trach">Giáo viên phụ trách:</label>
        <input type="text" id="gv_phu_trach" name="gv_phu_trach" value="<?php echo $row['gv_phu_trach']; ?>"><br><br>
        <label for="ten_lop">Tên lớp:</label>
        <input type="text" id="ten_lop" name="ten_lop" value="<?php echo $row['ten_lop']; ?>"><br><br>
        <label for="so_luong_hs">Sĩ số:</label>
        <input type="text" id="so_luong_hs" name="so_luong_hs" value="<?php echo $row['so_luong_hs']; ?>"><br><br>
        <input type="submit" value="Lưu thay đổi">
    </form>

    <?php
            } else {
                echo "Không tìm thấy thông tin lớp cần chỉnh sửa";
            }
        }

    ?>

    <?php
        if (isset($_POST['id_lop'])) {
            $id_lop = $_POST['id_lop'];
            $gv_phu_trach = $_POST['gv_phu_trach'];
            $ten_lop = $_POST['ten_lop'];
            $so_luong_hs = $_POST['so_luong_hs'];
        
            $sql = "UPDATE lop SET gv_phu_trach = '$gv_phu_trach', ten_lop = '$ten_lop', so_luong_hs = '$so_luong_hs' WHERE id_lop = '$id_lop'";
        
            if ($conn->query($sql) === TRUE) {
                echo "<h2 style ='text-align:center; color:white; margin: 50px 0'>Cập nhật thông tin lớp thành công</h2>";
            } else {
                echo "Lỗi khi cập nhật thông tin lớp: " . $conn->error;
            }
        }
        $conn->close();
    ?>
</body>
</html>