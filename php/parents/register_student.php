<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/register_student.css">
    <title>Thêm học sinh</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/parents/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/parents/student.php">Học sinh</a></li>
                <li><a href="/PHP/BTL/php/parents/register_student.php">Phiếu đăng ký</a></li>
                <li><a href="/PHP/BTL/php/parents/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
            </ul>
        </div>
    </header>

    <div class="form">
        <form action="" method="get">
            <h2>Phiếu đăng ký</h2>
            <!-- Form thêm học sinh -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <label for="ten_hoc_sinh">Tên học sinh </label>
                            <input type="text" id="ten_hoc_sinh" name="ten_hoc_sinh" placeholder = "">
                        </div>
                        <div class="input-group">
                            <label for="ngay_sinh_hs">Ngày sinh</label>
                            <input type="text" id="ngay_sinh_hs" name="ngay_sinh_hs" placeholder = "Ví dụ : 1997-12-28">
                        </div>
                        <div class="input-group">
                            <label for="gioi_tinh">Giới tính</label>
                            <input type="text" id="gioi_tinh" name="gioi_tinh">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <label for="dia_chi">Địa chỉ</label>
                            <input type="text" id="dia_chi" name="dia_chi">
                        </div>
                        <div class="input-group">
                            <label for="ten_phu_huynh">Tên phụ huynh </label>
                            <input type="text" id="ten_phu_huynh" name="ten_phu_huynh" placeholder = "">
                        </div>
                        <div class="input-group">
                            <label for="so_dien_thoai">SĐT</label>
                            <input type="text" id="so_dien_thoai" name="so_dien_thoai" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <label for="id_lop">Loại lớp</label><br>
                            <!-- Tạo ra select/option để lựa chọn loại lớp từ bảng loai_lop trong csdl -->
                            <select id='id_lop' name ='id_lop'>
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
                                        if ($class == $_POST['id_lop']) {
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
                            <label for="ten_lop">ID loại lớp</label>
                            <input type="text" id="ten_lop" name="ten_lop" >
                        </div>
                        <div class="input-group">
                            <label for="nam_hoc">Năm học</label>
                            <input type="text" id="nam_hoc" name="nam_hoc">
                        </div>                
                    </div>
                </div>
            </div>
            <input type="submit" name='submit' class='submit' value="Đăng ký">
        </form>
    </div>
        
    <?php
        if (isset($_GET['id_hoc_sinh'])) {
            require "connect.php";
            mysqli_set_charset($conn, 'UTF8');

            $id_hoc_sinh = $_GET['id_hoc_sinh'];
            $ten_hoc_sinh = $_GET['ten_hoc_sinh'];
            $ngay_sinh_hs = $_GET['ngay_sinh_hs'];
            $gioi_tinh = $_GET['gioi_tinh'];
            $nam_hoc = $_GET['nam_hoc'];
    
            $check_query = "SELECT * FROM phieu_dang_ky WHERE id_phieu = '$id_hoc_sinh'";
            $result = $conn->query($check_query);

            if ($result->num_rows > 0) {
                echo "<h1 style='text-align:center;color:red;margin-top:20px' >ID học sinh đã tồn tại. Vui lòng chọn ID khác.</h1>";
            } else {
                // Thêm bản ghi vào CSDL nếu ID không trùng
                $insert_query = "INSERT INTO phieu_dang_ky (ten_hoc_sinh, ngay_sinh_hs, gioi_tinh_hs,dia_chi_hs,loai_lop_dang_ky,ten_phu_huynh,dien_thoai_phu_huynh, nam_hoc) VALUES ('$id_hoc_sinh', '$ten_hoc_sinh', '$ngay_sinh_hs', '$gioi_tinh', '$nam_hoc')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "<h1 style='text-align:center;color:white;margin-top:20px' >Thêm học sinh thành công!</h1>";
                } else {
                    echo "Lỗi khi thêm học sinh: " . $conn->error;
                }
            }
        }
    ?>

</body>
</html>