<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/list_class.css">
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
                <li><a href="">Phụ huynh</a></li>
                <li><a href="">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <div class="form">
        <form action="" method="get">
            <h2>Thêm học sinh</h2>
            <div class="input-group">
                <label for="id_hoc_sinh">ID học sinh</label>
                <input type="text" id="id_hoc_sinh" name="id_hoc_sinh" placeholder = "HSxx (xx là số)">
            </div>
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
            <div class="input-group">
                <label for="nam_hoc">Năm học</label>
                <input type="text" id="nam_hoc" name="nam_hoc">
            </div>
            <input type="submit" value="Thêm học sinh">
        </form>
    </div>
        
    <?php
        if (isset($_GET['id_hoc_sinh'])) {
            require "../connect.php";
            mysqli_set_charset($conn, 'UTF8');

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
                $insert_query = "INSERT INTO hoc_sinh (id_hoc_sinh, ten_hoc_sinh, ngay_sinh_hs, gioi_tinh, nam_hoc) VALUES ('$id_hoc_sinh', '$ten_hoc_sinh', '$ngay_sinh_hs', '$gioi_tinh', '$nam_hoc')";
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