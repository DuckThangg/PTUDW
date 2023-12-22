<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/allocation.css">

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
                <li><a href="">Phụ huynh</a></li>
                <li><a href="">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <div class="table">
    <?php
        require '../connect.php';
        mysqli_set_charset($conn, 'UTF8');

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_lop']) && isset($_POST['update_teacher'])) {
            $id_lop = $_POST['id_lop'];
            $update_teacher = $_POST['update_teacher'];
        
            // Kiểm tra xem ID giáo viên tồn tại trong bảng giao_vien hay không
            $check_teacher_query = "SELECT id_giao_vien FROM giao_vien WHERE id_giao_vien = '$update_teacher'";
            $check_teacher_result = $conn->query($check_teacher_query);
        
            if ($check_teacher_result->num_rows > 0) {
                // Nếu ID giáo viên tồn tại, thực hiện cập nhật trong bảng lop
                $sql_update_id_gv = "UPDATE lop SET id_gv_phu_trach = '$update_teacher' WHERE id_lop = '$id_lop'";
            
                if ($conn->query($sql_update_id_gv) === TRUE) {
                    // Cập nhật thành công ID giáo viên phụ trách, tiến hành lấy thông tin giáo viên và cập nhật gv_phu_trach
                    $sql_get_teacher_info = "SELECT ten_giao_vien FROM giao_vien WHERE id_giao_vien = '$update_teacher'";
                    $result = $conn->query($sql_get_teacher_info);
                
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $teacher_name = $row['ten_giao_vien'];
                        // Cập nhật trường gv_phu_trach trong bảng lop với thông tin từ bảng giao_vien
                        $sql_update_gv_phu_trach = "UPDATE lop SET gv_phu_trach = '$teacher_name' WHERE id_lop = '$id_lop'";
                        if ($conn->query($sql_update_gv_phu_trach) === TRUE) {
                            echo "<p>Cập nhật giáo viên phụ trách thành công!</p>";
                        } else {
                            echo "Lỗi khi cập nhật giáo viên phụ trách: " . $conn->error;
                        }
                    } else {
                        echo "<p>Không tìm thấy thông tin giáo viên!</p>";
                    }
                } else {
                    echo "Lỗi khi cập nhật ID giáo viên phụ trách: " . $conn->error;
                }
            } else {
                echo "<h1>Không tìm thấy id giáo viên!</h1>";
            }
        }

        $sql = "SELECT * FROM lop WHERE gv_phu_trach IS NULL OR gv_phu_trach = ''";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID Lớp</th>
                        <th>Giáo viên phụ trách</th>
                        <th>Tên lớp</th>
                        <th>Sĩ số</th>
                    </tr>";
        
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                echo "<tr class='$class'>
                        <td>" . $row["id_lop"] . "</td>
                        <td>
                            <form action='' method='post'>
                                <input type='hidden' name='id_lop' value='" . $row["id_lop"] . "'>
                                <input type='text' name='update_teacher' placeholder='Nhập id giáo viên'>
                                <input type='submit' value='Cập nhật'>
                            </form>
                        </td>
                        <td>" . $row["ten_lop"] . "</td>
                        <td>" . $row["so_luong_hs"] . "</td>
                    </tr>";
                $i++;
            }
            echo "</table>";
        } else {
            echo "Không có thông tin để hiển thị";
        }
        $conn->close();
    ?>
    </div>
</body>
</html>