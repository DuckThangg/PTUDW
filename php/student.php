<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">

    <link rel="stylesheet" href="../css/student.css">
    
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
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>

        <?php
        session_start();
        if (!isset($_SESSION['user_name']))
        {
            echo "
            <div>
                <ul>
                    <li><a href='/PHP/BTL/html/login.html'>Đăng nhập</a></li>
                    <li><a href='/PHP/BTL/php/register.php'>Đăng kí</a></li>
                </ul>
            </div> ";
            
        }
        if(isset($_SESSION['user_name'])){
            require 'connect.php';
            $user_name = $_SESSION['user_name'];
            $sql = "SELECT *FROM users WHERE user_name = '$user_name' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_role = $row['chuc_vu'];
                // Tài khoản đăng nhập là giáo viên
                if($user_role == 'Giáo viên'){
                    echo "
                        <div>
                            <ul>
                            <li><a href='/PHP/BTL/php/teacher/class.php'>Lớp học</a></li>
                            <li><a href='/PHP/BTL/php/teacher/student.php'>Học sinh</a></li>
                            <li><a href='/PHP/BTL/php/parents.php'>Phụ huynh</a></li>
                            <li><a href='/PHP/BTL/php/teacher/account.php'>Tài khoản</a></li>
                            <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }
                // Tài khoản đăng nhập là phụ huynh
                elseif($user_role == 'Phụ huynh'){
                    echo "
                        <div>
                            <ul>
                                <li><a href='/PHP/BTL/php/teacher.php'>Giáo viên</a></li>
                                <li><a href='/PHP/BTL/php/class.php'>Lớp học</a></li>
                                <li><a href='/PHP/BTL/php/parents/student.php'>Học sinh</a></li>
                                <li><a href='/PHP/BTL/php/parents/register_student.php'>Đăng ký học</a></li>
                                <li><a href='/PHP/BTL/php/teacher/account.php'>Tài khoản</a></li>
                                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }else{
                    echo "
                        <div>
                            <ul>
                                <li><a href='/PHP/BTL/php/teacher.php'>Giáo viên</a></li>
                                <li><a href='/PHP/BTL/php/class.php'>Lớp học</a></li>
                                <li><a href='/PHP/BTL/php/student.php'>Học sinh</a></li>
                                <li><a href='/PHP/BTL/php/parents.php'>Phụ huynh</a></li>
                                <li><a href='/PHP/BTL/php/admin/account.php'>Tài khoản</a></li>
                                <li><a href='/PHP/BTL/php/admin/registration_form.php'>Đăng kí học</a></li>
                                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }
            }
        }
        ?>
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
                    echo "<button style='margin:50px 50px 0 400px;'><a href='/PHP/BTL/php/admin/add_student.php'>Thêm học sinh</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/change_student.php'>Cập nhật thông tin</a></button>";
                    echo "<button><a href='/PHP/BTL/php/admin/info_student.php'>Xem thông tin đầy đủ học sinh</a></button>";
                } elseif ($position === 'Giáo viên') {
                    echo "<button style='margin:50px 50px 0 400px;'><a href='/PHP/BTL/php/list_class.php'>Thêm sửa xóa học sinh</a></button>";
                    echo "<button><a href='/PHP/BTL/php/change_student.php'>Cập nhật thông tin</a></button>";
                    echo "<button><a href='/PHP/BTL/php/list_class.php'>Xem thông tin đầy đủ học sinh</a></button>";
                } elseif ($position === 'Phụ huynh') {
                    echo "<button style='margin:50px 50px 0 400px;><a href='/PHP/BTL/php/list_class.php'>Cập nhật thông tin</a></button>";
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

    <button onclick="goToTop()" id="btnTop" title="Lên đầu trang">&#8593;</button>

    <script>
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            let btnTop = document.getElementById("btnTop");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                btnTop.style.display = "block"; /* Hiển thị nút khi cuộn xuống một khoảng cụ thể */
            } else {
                btnTop.style.display = "none"; /* Ẩn nút khi đầu trang */
            }
        }

        function goToTop() {
            document.body.scrollTop = 0; /* Đối với Safari */
            document.documentElement.scrollTop = 0; /* Đối với các trình duyệt khác */
        }

    </script>

</body>
</html>