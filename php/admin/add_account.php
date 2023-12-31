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
                <li><a href="/PHP/BTL/php/parents">Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/admin/registration_form.php">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <div class="form">
        <form action="" method="get">
            <h2>Cấp tài khoản</h2>
            <div class="input-group">
                <label for="user_name">Tên đăng nhập</label>
                <input type="text" id="user_name" name="user_name" placeholder = "">
            </div>
            <div class="input-group">
                <label for="user_password">Mật khẩu </label>
                <input type="text" id="user_password" name="user_password" placeholder = "">
            </div>
            <div class="input-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" placeholder = "">
            </div>
            <div class="input-group">
                <label for="chuc_vu">Chức vụ --</label>
                <select name="chuc_vu">
                    <?php
                    require '../connect.php';
                    $sql = "SELECT DISTINCT chuc_vu FROM users"; 
                    mysqli_set_charset($conn, 'UTF8');
                    $result = $conn->query($sql);

                // Kiểm tra và đổ dữ liệu vào thẻ option
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['chuc_vu'] . "'>" . $row['chuc_vu'] . "</option>";
                        }
                        } else {
                            echo "<option value=''>No origin found</option>";
                        }
                        $conn->close();
                    ?>
                    </select>
            </div>
            <div class="input-group">
                <label for="full_name">Tên đầy đủ</label>
                <input type="text" id="full_name" name="full_name">
            </div>

            <input type="submit" value="Thêm tài khoản">
        </form>
    </div>
        
    <?php
        if (isset($_GET['user_name'])) {
            require "../connect.php";
            mysqli_set_charset($conn, 'UTF8');

            $user_name = $_GET['user_name'];
            $user_password = $_GET['user_password'];
            $phone = $_GET['phone'];
            $chuc_vu = $_GET['chuc_vu'];
            $full_name = $_GET['full_name'];
    
            $check_query = "SELECT * FROM users WHERE user_name = '$user_name'";
            $result = $conn->query($check_query);
            if ($result->num_rows > 0) {
                echo "<h1 style='text-align:center;color:red;margin-top:20px' >Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.</h1>";
            } else {
                // Thêm bản ghi vào CSDL nếu ID không trùng
                $insert_query = "INSERT INTO users (chuc_vu, user_name, user_password, phone, full_name) VALUES ('$chuc_vu', '$user_name', '$user_password', '$phone', '$full_name')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "<h1 style='text-align:center;color:white;margin-top:20px' >Cấp tài khoản thành công!</h1>";
                } else {
                    echo "Lỗi : " . $conn->error;
                }
            }
        }
    ?>

</body>
</html>