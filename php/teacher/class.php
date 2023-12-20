<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lớp học</title>
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/class.css">
    <style>
        .my-table th, .my-table td{
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>

</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                <li><a href=''>Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
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
                        <th>Thao tác</th>
                    </tr>";

            $i = 0;
            while($row = $result->fetch_assoc()) {
                $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                echo "<tr class='$class'>
                        <td>".$row["id_lop"]."</td>
                        <td>".$row["gv_phu_trach"]."</td>
                        <td>".$row["ten_lop"]."</td>
                        <td>".$row["so_luong_hs"]."</td>
                        <td style='width:20%'>";
                            if($position === 'Giáo viên') {
                                echo "<a href='/PHP/BTL/php/teacher/list_class.php' style='margin-right:10px'><img src='/PHP/BTL/images/account.png' style='width:20%'></a>";
                                echo "<a href='/PHP/BTL/php/teacher/list_class.php'><img src='/PHP/BTL/images/account.png' style='width:20%'></a>";
                            };
                        "</td>;
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