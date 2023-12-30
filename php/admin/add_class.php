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
            <h2>Mở thêm lớp học</h2>
            <div class="input-group">
                <label for="id_lop">ID lớp học</label>
                <input type="text" id="id_lop" name="id_lop" placeholder = "3 tuổi:M()03 -- 4 tuổi: C()04 -- 5 tuổi: L()05  Ví dụ:MA03">
            </div>
            <div class="input-group">
                <label for="id_loai_lop">ID loại lớp </label>
                <input type="text" id="id_loai_lop" name="id_loai_lop" placeholder = "M03 -- C04 -- L05">
            </div>
            <div class="input-group">
                <label for="ten_lop">Tên lớp</label>
                <input type="text" id="ten_lop" name="ten_lop" placeholder = "Mầm -- Cành -- Lá">
            </div>
            <div class="input-group">
                <label for="so_luong_hs">Số lượng học sinh</label>
                <input type="text" id="so_luong_hs" name="so_luong_hs">
            </div>
            <input type="submit" value="Mở lớp">
        </form>
    </div>
        
    <?php
        if (isset($_GET['id_lop'])) {
            require "../connect.php";
    
            $id_lop = $_GET['id_lop'];
            $id_loai_lop = $_GET['id_loai_lop'];
            $ten_lop = $_GET['ten_lop'];
            $so_luong_hs = $_GET['so_luong_hs'];
    
            // Kiểm tra trước khi thêm dữ liệu để tránh trùng lặp khóa chính và kiểm tra id_loai_lop
            $check_query = "SELECT lop.id_lop, loai_lop.id_loai_lop 
                            FROM lop 
                            LEFT JOIN loai_lop ON lop.id_loai_lop = loai_lop.id_loai_lop 
                            WHERE lop.id_lop = '$id_lop'";
            
            $result = $conn->query($check_query);
    
            if ($result->num_rows == 0) {
                // Nếu id_lop không trùng lặp và id_loai_lop tồn tại, thêm dữ liệu vào bảng lop
                $check_loai_lop_query = "SELECT id_loai_lop FROM loai_lop WHERE id_loai_lop = '$id_loai_lop'";
                $check_loai_lop_result = $conn->query($check_loai_lop_query);
    
                if ($check_loai_lop_result->num_rows > 0) {
                    $sql = "INSERT INTO lop (id_lop, id_loai_lop, ten_lop, so_luong_hs) VALUES ('$id_lop','$id_loai_lop','$ten_lop','$so_luong_hs')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<h2 style='color:white; text-align:center'>Mở lớp thành công</h2>";
                        echo "<button style='margin-left: 45%;'> <a href='/PHP/BTL/index.php'>Về trang chủ</a> </button>";
                    } else {
                        echo "Lỗi khi thêm dữ liệu: " . $conn->error;
                    }
                } else {
                    // Nếu id_loai_lop không tồn tại, hiển thị thông báo lỗi
                    echo "<h2 style='color:red; text-align:center'>Nhập sai thông tin , ID loại lớp không tồn tại</h2>";
                }
            } else {
                // Nếu id_lop đã tồn tại, hiển thị thông báo lỗi
                echo "<h2 style='color:red; text-align:center'>Nhập sai thông tin, id lớp này đã tồn tại, vui lòng nhập ID khác</h2>";
            }
    
            $conn->close();
        }
    ?>

</body>
</html>