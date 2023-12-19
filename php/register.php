<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Đăng nhập</title>
</head>
<body>
    <div style ="display:flex;gap: 50px; justify-content: center; width:100%; margin-top:120px">
        <div>
            <a  href="/PHP/BTL/index.php"> <img style="margin-top:70px" src="../images/icon-2.png" alt=""> </a>
        </div>
    
        <div class="form">
            <h2>Đăng kí</h2>
            <form action="" method="get">
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
                    require 'connect.php';
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

            $sql = "INSERT INTO users (user_name,user_password,chuc_vu,phone) VALUES ('$user_name','$user_password','$position','$phone')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<h2 style = 'color :white;text-align:center'> Đăng kí thành công, Hello $user_name </h2> <br>";
                echo "<button style='margin-left: 45%;'> <a href='/PHP/BTL/html/login.html'>Về trang đăng nhập</a> </button>";
            } else {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }
            
            $conn->close();
        }
    ?>
</body>
</html>