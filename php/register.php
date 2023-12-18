<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Đăng ký</title>
</head>
<body>
    <div style ="display:flex;gap: 50px; justify-content: center; width:100%">
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>
    
        <div class="form">
            <h2>Đăng kí</h2>
            <form action="" method="get">
                <div class="input-group">
                    <label for="user_fullname">Họ và tên</label>
                    <input type="text" id="user_fullname" name="user_fullname">
                </div>
                <div class="input-group">
                    <label for="user_date">Ngày sinh</label>
                    <input type="date" id="user_date" name="user_date">
                </div>
                <div class="input-group">
                    <label for="user_name">Tên đăng nhập</label>
                    <input type="text" id="user_name" name="user_name">
                </div>
                <div class="input-group">
                    <label for="user_password">Mật khẩu</label>
                    <input type="password" id="user_password" name="user_password">
                </div>

                <div class="input-group">
                    <label for="position">Chức vụ </label>
                    <select name="position">
                    <?php
                // Kết nối CSDL và truy vấn dữ liệu
                    require 'connect.php';
                    $sql = "SELECT DISTINCT chuc_vu FROM users"; // Thay 'flights' bằng tên bảng của bạn
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
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone">
                </div>
                <input type="submit" value="Đăng kí">
            </form>
        </div>
    </div>



    <?php
        if (isset($_GET['user_name'])) {
            require "connect.php";
            
            $user_name = $_GET['user_name'];
            $user_password = $_GET['user_password'];
            $position = $_GET['position'];
            $phone = $_GET['phone'];
            $fullname = $_GET['user_fullname'];
            $birthday = $_GET['user_date'];

            // Truy vấn kiểm tra đã có user_name
            $check_sql = "SELECT * FROM users WHERE user_name = '$user_name'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
            } else {
                $insert_sql = "INSERT INTO users (user_name, user_password, chuc_vu, phone, fullname, ngay_sinh) VALUES ('$user_name', '$user_password', '$position', '$phone', '$fullname', '$birthday')";

                if ($conn->query($insert_sql) === TRUE) {
                    echo "Đăng kí thành công, Hello $user_name <br>";
                    echo "<a href='/PHP/BTL/html/login.html'>Về trang đăng nhập</a> ";
                } else {
                    echo "Lỗi: " . $insert_sql . "<br>" . $conn->error;
                }
            }
            
            $conn->close();
        }
    ?>

</body>
</html>
