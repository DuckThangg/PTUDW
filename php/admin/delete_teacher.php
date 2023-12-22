<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/teachers.css">
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

    <?php
        require '../connect.php';
        
        mysqli_set_charset($conn, 'UTF8');
        session_start();
        $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
        // if (isset($_SESSION['user_name'])){
        //     $user_name = $_SESSION['user_name'];

        //     $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
        //     $result = $mysqli->query($query);

        //     if ($result && $result->num_rows > 0) {
        //         $row = $result->fetch_assoc();
        //         $position = $row['chuc_vu'];

        //         if ($position === 'ADMIN') {
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thêm giáo viên</a></button>";
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Xóa giáo viên</a></button>";
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thay đổi thông tin giáo viên</a></button>";
        //         } elseif ($position === 'Giáo viên') {
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thay đổi thông tin</a></button>";
        //         } elseif ($position === 'Phụ huynh') {
        //         } 
        //     } else {
        //         echo "ban chua dang nhap";
        //     }   
        // } 
    ?>
    <form style="text-align:center" action="" method="post">
    
        <div class="table">
        <?php
            require '../connect.php';
            mysqli_set_charset($conn, 'UTF8');
            $sql = "SELECT * FROM giao_vien";

            $result= $conn->query($sql);

            if($result->num_rows > 0){
                echo "<table class='my-table' border='2'>
                        <tr>
                            <th>ID giáo viên</th>
                            <th>Tên giáo viên</th>
                            <th>Giới tính</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Lớp phụ trách</th>
                            <th>Xóa</th>
                        </tr>";

                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                    echo "<tr class='$class'>
                            <td>".$row["id_giao_vien"]."</td>
                            <td>".$row["ten_giao_vien"]."</td>
                            <td>".$row["gioi_tinh_gv"]."</td>
                            <td>".$row["ngay_sinh_gv"]."</td>
                            <td>".$row["dien_thoai_gv"]."</td>
                            <td>".$row["lop_phu_trach"]."</td>
                            <td><input type='checkbox' name='delete[]' value='".$row["id_giao_vien"]."'></td>
                        </tr>";
                    $i++;
                }
                echo "</table>";
            }
            else{
                echo "Không có thông tin để hiển thị";
            }
        ?>
        </div>
        <input style="padding:10px;font-size:15px;" type="submit" name="submit" value="Xóa giáo viên">
    </form>

    <?php

    if (isset($_POST['submit'])) {
        if (!empty($_POST['delete'])) {
            foreach ($_POST['delete'] as $deleteId) {
                $deleteId = (int)$deleteId; // Chuyển đổi ID sang kiểu số nguyên để tránh tấn công SQL injection

                $sql = "DELETE FROM giao_vien WHERE id_giao_vien = $deleteId"; // Query xóa dữ liệu từ CSDL
                if ($conn->query($sql) !== TRUE) {
                    echo "Lỗi khi xóa bản ghi: " . $conn->error;
                }
            }
            echo "Xóa thành công!";
        } else {
            echo "Vui lòng chọn ít nhất một bản ghi để xóa.";
        }
    }
    $conn->close();
    ?>


</body>
</html>