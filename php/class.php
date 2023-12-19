<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/class.css">

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
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Xem thông tin lớp học</a></button>";
                    echo "<button><a href='/PHP/BTL/php/allocation.php'>Phân bổ giáo viên phụ trách </a></button>";
                    echo "<button><a href='/PHP/BTL/php/add_class.php'>Mở thêm lớp học</a></button>";
                    echo "<button><a href='/PHP/BTL/php/change_class.php'>Thay đổi thông tin lớp học</a></button>";
                } elseif ($position === 'Giáo viên') {
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Đăng kí mở lớp</a></button>";
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Xem thông tin lớp học</a></button>";
                } elseif ($position === 'Phụ huynh') {
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Xem thông tin lớp học</a></button>";
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
        $sql = "SELECT * FROM lop";

        $result= $conn->query($sql);

        if($result->num_rows > 0){
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID Lớp</th>
                        <th>Giáo viên phụ trách</th>
                        <th>Tên lớp</th>
                        <th>Sĩ số</th>
                    </tr>";

            $i = 0;
            while($row = $result->fetch_assoc()) {
                $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                echo "<tr class='$class'>
                        <td>".$row["id_lop"]."</td>
                        <td>".$row["gv_phu_trach"]."</td>
                        <td>".$row["ten_lop"]."</td>
                        <td>".$row["so_luong_hs"]."</td>
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