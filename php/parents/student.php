<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/teachers.css">
    <link rel="stylesheet" href="../../css/list_class.css">
    <title>Thông tin học sinh</title>
    <style>
        .submit {
            border-radius: 10px;
            padding:8px;
            font-size: 16px;
            background-color: #51ba54;
            color: white;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }

        input{
            padding: 5px;
        }
        
    </style>
</head>

<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                    <li><a href='/PHP/BTL/php/parents/teacher.php'>Giáo viên</a></li>
                    <li><a href="/PHP/BTL/php/parents/class.php">Lớp học</a></li>
                    <li><a href="/PHP/BTL/php/parents/student.php">Học sinh</a></li>
                <?php
                    require '../connect.php';
                    
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
                        
                            if ($position === 'Phụ huynh') {
                                echo "<li><a href='/PHP/BTL/php/parents/register_student.php'>Đăng kí học</a></li>";
                            } else {
                            echo "ban chua dang nhap";
                            }
                        }   
                    } 
                ?>
                <li><a href="/PHP/BTL/php/parents/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>

            </ul>
        </div>
    </header>
    

    <div class="table">
        <h3>Thông tin học sinh</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img src="/PHP/BTL/images/account.png" alt="account">
                    <p>
                        <?php
                        if(isset($_SESSION['user_name'])){
                            $sql = "SELECT *FROM hoc_sinh
                                    WHERE id_hoc_sinh IN (
                                    SELECT id_hoc_sinh
                                    FROM giam_ho
                                    WHERE ten_phu_huynh = (
                                        SELECT full_name
                                        FROM users
                                        WHERE user_name = '$user_name'
                                    ))";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0){
                                $row = $result->fetch_assoc();
                                echo "<h4>". $row['ten_hoc_sinh'] . "</h4>";
                                echo "<form action='' method='get'>
                                        <input type='hidden' name='id_hoc_sinh' value='" . $row["id_hoc_sinh"] . "'>
                                        <input type='submit' class='submit' value='Chỉnh sửa'>
                                    </form>";
                            }
                            else{
                                echo "<p>Không có thông tin hiển thị</p>";
                            }
                        }else{
                            echo "<p>Không có thông tin hiển thị</p>";
                        }
                        ?>
                    </p>
                </div>
                <div class="col-md-9">
                    <div class="head">
                        <a href="/PHP/BTL/php/parents/account.php">Thông tin chi tiết</a>
                    </div>
                    <div class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5" style="text-align:left">
                                    <p>ID học sinh</p>
                                    <p>ID lớp</p>
                                    <p>Họ và tên</p>
                                    <p>Ngày sinh</p>
                                    <p>Năm học</p>
                                </div>
                                <!-- Hiển thị thông tin chi tiết của học sinh từ phiếu đăng ký với phieu_dang_ky.id_phieu = hoc_sinh.id_phieu -->
                                <div class="col-md-7" style="text-align:left">
                                    <?php
                                    if(isset($_SESSION['user_name'])){
                                        $sql = "SELECT *FROM hoc_sinh
                                        WHERE id_hoc_sinh IN (
                                            SELECT id_hoc_sinh
                                            FROM giam_ho
                                            WHERE ten_phu_huynh = (
                                                SELECT full_name
                                                FROM users
                                                WHERE user_name = '$user_name'
                                            ))";
                                    $result = $conn->query($sql);
                                        if($result->num_rows > 0){
                                            $i = 0;
                                            while ($i<$result->num_rows) {
                                                $row = $result->fetch_assoc();
                                                echo "<p>" . ($row["id_hoc_sinh"] ). "</p>";
                                                echo "<p>" . ($row["id_lop"]) . "</p>";
                                                echo "<p>" . ($row["ten_hoc_sinh"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["ngay_sinh_hs"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["nam_hoc"] ?? "Không có") . "</p>";
                                                $i++;
                                            }
                                        }
                                        else{
                                            echo "<p>Không có thông tin hiển thị</p>";
                                        }
                                    }else{
                                        echo "<p>Không có thông tin hiển thị</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
