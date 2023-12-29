<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/teachers.css">
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
                <li><a href="/PHP/BTL/php/parents.php">Phụ huynh</a></li>
                <li><a href="">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <?php
        require 'connect.php';
        
        mysqli_set_charset($conn, 'UTF8');
        session_start();
        $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
        if (isset($_SESSION['user_name'])){
            $user_name = $_SESSION['user_name'];

            $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $position = $row['chuc_vu'];

                if ($position === 'ADMIN') {
                    echo "<button><a href='/PHP/BTL/php/admin/add_teacher.php'>Thêm giáo viên</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/delete_teacher.php'>Xóa giáo viên</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/change_teacher.php'>Thay đổi thông tin giáo viên</a></button>";
                } elseif ($position === 'Giáo viên') {
                    echo "<button><a href='/PHP/BTL/php/admin/list_class.php'>Thay đổi thông tin</a></button>";
                } elseif ($position === 'Phụ huynh') {
                } 
            } else {
                echo "ban chua dang nhap";
            }   
        } 
    ?>
    
    <div class="table">
    <?php
        require 'connect.php';
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
                    </tr>";
                $i++;
            }
            echo "</table>";
        }
        else{
            echo "Không có thông tin để hiển thị";
        }
        $conn->close();
    ?>
    </div>

</body>
</html>