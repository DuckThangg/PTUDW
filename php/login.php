<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Đăng nhập</title>
    <style>
        .container{
            margin: 150px auto;
            background-color: #c2f4c2;
            text-align:center;
            padding: 50px;
            width: 60%;
            border-radius:10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 1);
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img  src="../images/icon-2.png" alt="">
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

    <?php
        require "connect.php";
        //Nếu đăng nhập (nhập user name và password)
        if(isset($_GET['user_name'])){
            $user_name = $_GET['user_name'];
            $user_password = $_GET['user_password'];
            $sql = "SELECT * FROM users WHERE user_name = '$user_name' AND user_password = '$user_password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                session_start();
                $_SESSION['user_name'] = $user_name;
                echo "<h1 style='text-align: center; margin-top: 200px;'>Đăng nhập thành công, Xin chào $user_name </h1>";
                echo "<a href='/PHP/BTL/index.php'>Về trang chủ</a>";
                header("Location: /PHP/BTL/index.php");
            } else {
                echo"<div class='container'>
                        <h1>Tài khoản hoặc mật khẩu sai</h1>
                    </div>";
                // require "index.html";
            }
        }
        else{
            echo"<div class='container'>
                    <h1>Bạn chưa đăng nhập tài khoản</h1>
                </div>";
        }
        $conn->close(); 
    ?>
</body>
</html>