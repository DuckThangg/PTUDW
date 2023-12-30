<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/student.css">
    
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
                                echo "<li><a href='/PHP/BTL/php/admin/registration_form.php'>Đăng kí học</a></li>";
                            } elseif ($position === 'Phụ huynh') {
                                echo "<li><a href='/PHP/BTL/php/parents/register_student.php'>Đăng kí học</a></li>";
                            } else {
                            echo "ban chua dang nhap";
                            }
                        }   
                    } 
                ?>
            </ul>
        </div>
    </header>

    <?php
        require 'connect.php';
        
        mysqli_set_charset($conn, 'UTF8');
        $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
        if (isset($_SESSION['user_name'])){
            $user_name = $_SESSION['user_name'];

            $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $position = $row['chuc_vu'];

                if ($position === 'ADMIN') {
                    echo "<button><a href='/PHP/BTL/php/admin/add_student.php'>Thêm học sinh</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/change_student.php'>Cập nhật thông tin</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/list_class.php'>Xem thông tin đầy đủ học sinh</a></button>";
                } elseif ($position === 'Giáo viên') {
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Thêm sửa xóa học sinh</a></button>";
                    echo "<button><a href='/PHP/BTL/php/change_student.php'>Cập nhật thông tin</a></button>";
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Xem thông tin đầy đủ học sinh</a></button>";
                } elseif ($position === 'Phụ huynh') {
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Cập nhật thông tin</a></button>";
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
        $sql = "SELECT * FROM hoc_sinh";

        $result= $conn->query($sql);

        if($result->num_rows > 0){
            echo "<table class='my-table' border='2'>
                    <tr>
                        <th>ID Lớp</th>
                        <th>ID Học sinh</th>
                        <th>Tên học sinh</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Năm học</th>
                    </tr>";
            $i = 0;
            while($row = $result->fetch_assoc()) {
                $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                echo "<tr class='$class'>
                        <td>".$row["id_lop"]."</td>
                        <td>".$row["id_hoc_sinh"]."</td>
                        <td>".$row["ten_hoc_sinh"]."</td>
                        <td>".$row["ngay_sinh_hs"]."</td>
                        <td>".$row["gioi_tinh"]."</td>
                        <td>".$row["nam_hoc"]."</td>
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