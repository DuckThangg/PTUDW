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
        $sql = "SELECT * FROM hoc_sinh";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID học sinh</th>
                        <th>ID lớp</th>
                        <th>Tên học sinh</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Năm học</th>
                    </tr>";
        
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id_hoc_sinh"] . "</td>
                        <td>" . $row["id_lop"] . "</td>
                        <td>" . $row["ten_hoc_sinh"] . "</td>
                        <td>" . $row["ngay_sinh_hs"] . "</td>
                        <td>" . $row["gioi_tinh"] . "</td>
                        <td>" . $row["nam_hoc"] . "</td>
                        <td>
                            <form action='' method='get'>
                                <input type='hidden' name='id_hoc_sinh' value='" . $row["id_hoc_sinh"] . "'>
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
        if (isset($_GET['id_hoc_sinh'])) {
            $id_hoc_sinh = $_GET['id_hoc_sinh'];
        
            // Lấy thông tin của dòng cần chỉnh sửa từ id_hoc_sinh
            $sql = "SELECT * FROM hoc_sinh WHERE id_hoc_sinh = '$id_hoc_sinh'";
            $result = $conn->query($sql);
        
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Hiển thị form để người dùng có thể chỉnh sửa thông tin của dòng này
    ?>

    <form class="change_class" action="" method="post">
        <h1 style = "text-align:center">Chỉnh sửa thông tin học sinh</h1>
        <input type="hidden" name="id_hoc_sinh" value="<?php echo $row['id_hoc_sinh']; ?>">
        <label for="ten_hoc_sinh">Tên học sinh</label>
        <input type="text" id="ten_hoc_sinh" name="ten_hoc_sinh" value="<?php echo $row['ten_hoc_sinh']; ?>"><br><br>
        <label for="ngay_sinh_hs">Ngày sinh:</label>
        <input type="text" id="ngay_sinh_hs" name="ngay_sinh_hs" value="<?php echo $row['ngay_sinh_hs']; ?>"><br><br>
        <label for="gioi_tinh">Giới tính:</label>
        <input type="text" id="gioi_tinh" name="gioi_tinh" value="<?php echo $row['gioi_tinh']; ?>"><br><br>
        <label for="nam_hoc">Năm học:</label>
        <input type="text" id="nam_hoc" name="nam_hoc" value="<?php echo $row['nam_hoc']; ?>"><br><br>
        <input type="submit" value="Lưu thay đổi">
    </form>

    <?php
            } else {
                echo "Không tìm thấy thông tin lớp cần chỉnh sửa";
            }
        }

    ?>

    <?php
        if (isset($_POST['id_hoc_sinh'])) {
            $ten_hoc_sinh = $_POST['ten_hoc_sinh'];
            $ngay_sinh_hs = $_POST['ngay_sinh_hs'];
            $gioi_tinh = $_POST['gioi_tinh'];
            $nam_hoc = $_POST['nam_hoc'];

        
            $sql = "UPDATE hoc_sinh SET ten_hoc_sinh = '$ten_hoc_sinh', ngay_sinh_hs = '$ngay_sinh_hs', gioi_tinh ='$gioi_tinh', nam_hoc ='$nam_hoc' WHERE id_hoc_sinh = '$id_hoc_sinh'";
        
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