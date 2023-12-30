<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/list_class.css">
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
                <li><a href="/PHP/BTL/php/parents.php">Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/admin/registration_form.php">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <div class="form">
        <form action="" method="get">
            <h2>Thêm giáo viên</h2>
            <div class="input-group">
                <label for="id_giao_vien">ID Giáo viên</label>
                <input type="text" id="id_giao_vien" name="id_giao_vien" placeholder = "">
            </div>
            <div class="input-group">
                <label for="ten_giao_vien">Tên giáo viên </label>
                <input type="text" id="ten_giao_vien" name="ten_giao_vien" placeholder = "">
            </div>
            <div class="input-group">
                <label for="ngay_sinh_gv">Ngày sinh</label>
                <input type="text" id="ngay_sinh_gv" name="ngay_sinh_gv" placeholder = "Ví dụ : 1997-12-28">
            </div>
            <div class="input-group">
                <label for="gioi_tinh_gv">Giới tính</label>
                <input type="text" id="gioi_tinh_gv" name="gioi_tinh_gv">
            </div>
            <div class="input-group">
                <label for="dien_thoai_gv">Điện thoại</label>
                <input type="text" id="dien_thoai_gv" name="dien_thoai_gv">
            </div>
            <input type="submit" value="Thêm giáo viên">
        </form>
    </div>
        
    <?php
        if (isset($_GET['id_giao_vien'])) {
            require "../connect.php";
            mysqli_set_charset($conn, 'UTF8');

            $id_giao_vien = $_GET['id_giao_vien'];
            $ten_giao_vien = $_GET['ten_giao_vien'];
            $ngay_sinh_gv = $_GET['ngay_sinh_gv'];
            $gioi_tinh_gv = $_GET['gioi_tinh_gv'];
            $dien_thoai_gv = $_GET['dien_thoai_gv'];
    
            $check_query = "SELECT * FROM giao_vien WHERE id_giao_vien = '$id_giao_vien'";
            $result = $conn->query($check_query);

            if ($result->num_rows > 0) {
                echo "<h1 style='text-align:center;color:red;margin-top:20px' >ID giáo viên đã tồn tại. Vui lòng chọn ID khác.</h1>";
            } else {
                // Thêm bản ghi vào CSDL nếu ID không trùng
                $insert_query = "INSERT INTO giao_vien (id_giao_vien, ten_giao_vien, ngay_sinh_gv, gioi_tinh_gv, dien_thoai_gv) VALUES ('$id_giao_vien', '$ten_giao_vien', '$ngay_sinh_gv', '$gioi_tinh_gv', '$dien_thoai_gv')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "<h1 style='text-align:center;color:white;margin-top:20px' >Thêm giáo viên thành công!</h1>";
                } else {
                    echo "Lỗi khi thêm giáo viên: " . $conn->error;
                }
            }
        }
    ?>

</body>
</html>