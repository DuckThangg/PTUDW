<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/insert_student.css">
    <title>Thêm học sinh</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>
    <?php
        require "connect.php";
        mysqli_set_charset($conn, 'UTF8');
        session_start();
        if (isset($_SESSION['user_name'])){
    ?>
        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
            </ul>
        </div>
    <?php
        }else{
    ?>
        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/html/login.html'>Đăng nhập</a></li>
            </ul>
        </div>
    <?php 
        }
    ?>
    </header>
    <div class="form">
        <form action="" method="get">
            <h2>Tìm học sinh</h2>
            <div class="input-group">
                <label for="id_lop">ID học sinh</label>
            </div>
            <input type="text" id="id_hoc_sinh" name="id_hoc_sinh">
            <input type="submit" value="Tìm">
        </form>
    </div>

    <?php
        if (isset($_SESSION['user_name'])){
            if(isset($_GET['id_hoc_sinh'])){

                $id_hs = $_GET['id_hoc_sinh'];

                $sql = "SELECT * FROM hoc_sinh WHERE id_hoc_sinh = '$id_hs'";
                
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    $row = $result->fetch_assoc();
    ?>

    <div class="form">
        <form action="" method="get">
            <h2>Thêm học sinh</h2>
            <!-- Form thêm học sinh vào lớp của 1 giáo viên-->
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <label for="id_hoc_sinh">ID học sinh</label>
                            <input type="text" id="id_hoc_sinh" name="id_hoc_sinh" value="<?php if(isset($_GET['id_hoc_sinh'])){ echo $id_hs; }?>"readonly>
                        </div>
                        <div class="input-group">
                            <label for="ten_hoc_sinh">Tên học sinh </label>
                            <input type="text" id="ten_hoc_sinh" name="ten_hoc_sinh" value="<?php if(isset($_GET['id_hoc_sinh'])) {echo $row['ten_hoc_sinh']; }?>">
                        </div>
                        <div class="input-group">
                            <label for="ngay_sinh_hs">Ngày sinh</label>
                            <input type="text" id="ngay_sinh_hs" name="ngay_sinh_hs" value="<?php if(isset($_GET['id_hoc_sinh'])) {echo $row['ngay_sinh_hs'];} ?>">
                        </div>
                        <div class="input-group">
                            <label for="gioi_tinh">Giới tính</label>
                            <input type="text" id="gioi_tinh" name="gioi_tinh" value="<?php if(isset($_GET['id_hoc_sinh'])) {echo $row['gioi_tinh']; }?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label for="id_loai_lop">Loại lớp</label><br>
                            <!-- Tạo ra select/option để lựa chọn loại lớp từ bảng loai_lop trong csdl -->
                            <select id='id_loai_lop' name ='id_loai_lop'>
                                <?php
                                    require 'connect.php';
                                    $sql = "SELECT * FROM loai_lop";
                                    $result = $conn->query($sql);
                                    $i = 1;
                                    while($i <= $result->num_rows)
                                    {
                                        $row = $result->fetch_assoc();
                                        $class = $row["ten_loai_lop"];
                                        // sau khi chọn và chạy web giá trị vẫn sẽ giữ nguyên không bị thay đổi trừ khi bị tác động
                                        if ($class == $_POST['id_loai_lop']) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo "<option value='$class' $selected>" . $row["ten_loai_lop"] . "</option>";
                                        $i++;
                                    }
                                ?>
                            </select><br>
                        </div>
                        <div class="input-group">
                            <label for="id_lop">ID lớp</label>
                            <input type="text" id="id_lop" name="id_lop">
                        </div>
                        <div class="input-group">
                            <label for="ten_lop">Tên lớp</label>
                            <input type="text" id="ten_lop" name="ten_lop" >
                        </div>
                        <div class="input-group">
                            <label for="nam_hoc">Năm học</label>
                            <input type="text" id="nam_hoc" name="nam_hoc">
                        </div>                
                    </div>
                </div>
            </div>
            <input type="submit" name='submit' class='submit' value="Thêm học sinh">
        </form>
    </div>
        
    <?php
        if (isset($_GET['submit'])) { 
            require "connect.php";
            mysqli_set_charset($conn, 'UTF8');

            $id_lop = $_GET['id_lop'];
            $id_hoc_sinh = $_GET['id_hoc_sinh'];
            $ten_hoc_sinh = $_GET['ten_hoc_sinh'];
            $ngay_sinh_hs = $_GET['ngay_sinh_hs'];
            $gioi_tinh = $_GET['gioi_tinh'];
            $nam_hoc = $_GET['nam_hoc'];

            $check_query = "SELECT * FROM hoc_sinh WHERE id_hoc_sinh = '$id_hoc_sinh'";
            $result = $conn->query($check_query);

            if ($result->num_rows > 0) {
                echo "<h1 style='text-align:center;color:red;margin-top:20px' >ID học sinh đã tồn tại. Vui lòng chọn ID khác.</h1>";
            } else {
                // Thêm bản ghi vào CSDL nếu ID không trùng
                $insert_query = "UPDATE hoc_sinh SET id_lop='$id_lop', nam_hoc='$nam_hoc' WHERE id_hoc_sinh='$id_hoc_sinh'";
                if ($conn->query($insert_query) === TRUE) {
                    echo "<h1 style='text-align:center;color:white;margin-top:20px' >Cập nhật thông tin học sinh thành công!</h1>";
                } else {
                    echo "Lỗi khi cập nhật thông tin học sinh: " . $conn->error;
                }
            }
        }
    ?>

    <?php
            }else{
                echo"<div class='none'>
                        <h3>Hãy nhập vào id học sinh</h3>
                    </div>";
            }
        }
    }
    ?>

</body>
</html>