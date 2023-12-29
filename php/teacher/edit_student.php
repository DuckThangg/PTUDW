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
    <!-- Lấy thông tin học sinh được chỉ định -->
    <?php
    if (isset($_GET['ten_hoc_sinh']) && isset($_GET['ngay_sinh_hoc_sinh'])) {
        require "connect.php";
        mysqli_set_charset($conn, 'UTF8');

        $id_hoc_sinh = $_GET['id_hoc_sinh'];
        $ten_hoc_sinh = $_GET['ten_hoc_sinh'];
        $ngay_sinh_hs = $_GET['ngay_sinh_hoc_sinh'];
        

        $sql = "SELECT * FROM hoc_sinh WHERE id_hoc_sinh = '$id_hoc_sinh' OR (ten_hoc_sinh = '$ten_hoc_sinh' AND ngay_sinh_hs = '$ngay_sinh_hs') ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $gioi_tinh= $row['gioi_tinh'];
            $nam_hoc = $row['nam_hoc'];
            $id_lop = $row['id_lop'];
            
            // Từ id lớp truy vấn ra tên lớp của học sinh
            $sql_nameclass =  "SELECT * FROM lop WHERE id_lop ='$id_lop'";
            $result_nameclass = $conn->query($sql_nameclass);
            $name_class = $result_nameclass->fetch_assoc();
            $ten_lop =  $name_class['ten_lop'];
            $id_loai_lop = $name_class['id_loai_lop'];

            $sql_category = "SELECT * FROM loai_lop WHERE id_loai_lop ='$id_loai_lop'";
            $result_categoty = $conn->query($sql_category);
            $row_category = $result_categoty->fetch_assoc();
            $ten_loai_lop = $row_category['ten_loai_lop'];
        ?>
            <div class="form">
                <form action="" method="post">
                    <div class="back">
                        <a href="/PHP/BTL/php/teacher/student.php"><img src="/PHP/BTL/images/row_left.png" width="3%">Quay lại</a>
                    </div>
                    <h2>Sửa thông tin học sinh</h2>
                    <div class="container">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label for="id_hoc_sinh">ID học sinh</label>
                                    <input type="text" id="id_hoc_sinh" name="id_hoc_sinh" placeholder="<?php echo $row['id_hoc_sinh'];?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="ten_hoc_sinh">Tên học sinh </label>
                                    <input type="text" id="ten_hoc_sinh" name="ten_hoc_sinh" value="<?php echo $row['ten_hoc_sinh']; ?>">
                                </div>
                                <div class="input-group">
                                    <label for="ngay_sinh_hs">Ngày sinh</label>
                                    <input type="text" id="ngay_sinh_hs" name="ngay_sinh_hs" value="<?php echo $row['ngay_sinh_hs']; ?>">
                                </div>
                                <div class="input-group">
                                <label for="gioi_tinh">Giới tính</label>
                                <input type="text" id="gioi_tinh" name="gioi_tinh" value="<?php echo $gioi_tinh; ?>">
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="input-group">
                                <label for="loai_lop">Loại lớp</label><br>
                                <select id='loai_lop' name ='loai_lop'>
                                    <?php
                                        require 'connect.php';
                                        $sql = "SELECT * FROM loai_lop";
                                        $result = $conn->query($sql);
                                        $i = 0;
                                        while($i < $result->num_rows)
                                        {
                                            $row = $result->fetch_assoc();
                                            $class = $row["ten_loai_lop"];
                                            // $selected = ($origin == $_POST['origin']) ? 'selected="selected"' : '';
                                            if ($class == $ten_loai_lop) {
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
                                <input type="text" id="id_lop" name="id_lop" placeholder="<?php echo $id_lop; ?>"readonly>
                            </div>
                            <div class="input-group">
                                <label for="ten_lop">Tên lớp</label>
                                <input type="text" id="ten_lop" name="ten_lop" placeholder="<?php echo $ten_lop; ?>"readonly>
                            </div>
                            <div class="input-group">
                                <label for="nam_hoc">Năm học</label>
                                <input type="text" id="nam_hoc" name="nam_hoc" value="<?php echo $nam_hoc; ?>">
                            </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name='submit' class='submit' value="Sửa thông tin">
                </form>
                <?php
                    // Thực hiện cập nhật chỉnh sửa thông tin học sinh trong bảng học sinh
                    if(isset($_POST['submit'])){
                        $ten_update = $_POST['ten_hoc_sinh'];
                        $ngay_sinh_update = $_POST['ngay_sinh_hs'];
                        $gioi_tinh_update = $_POST['gioi_tinh'];
                        $nam_hoc_update = $_POST['nam_hoc'];
                        $sql_update = "UPDATE hoc_sinh SET ten_hoc_sinh='$ten_update', ngay_sinh_hs = '$ngay_sinh_update', gioi_tinh='$gioi_tinh_update', nam_hoc='$nam_hoc_update' WHERE id_hoc_sinh='$id_hoc_sinh'";
                        $result_update = $conn->query($sql_update);
                        if ($result_update === TRUE){
                            echo "Cập nhật thông tin thành công";
                        }
                        else{
                            echo "Cập nhật thông tin thất bại" . $conn->error;
                        }
                    }
                ?> 
            </div>
        <?php
            }
        } 
        ?>

</body>
</html>