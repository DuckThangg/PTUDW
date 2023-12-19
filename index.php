<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="./images/icon-2.png" alt=""> </a>
        </div>

        <?php
        session_start();
        if (!isset($_SESSION['user_name']))
        {
            echo "
            <div>
                <ul>
                    <li><a href='/PHP/BTL/html/login.html'>Đăng nhập</a></li>
                    <li><a href='/PHP/BTL/php/register.php'>Đăng kí</a></li>
                </ul>
            </div> ";
            
        }
        if(isset($_SESSION['user_name'])){
            echo "
                <div>
                    <ul>
                        <li><a href='/PHP/BTL/php/teacher.php'>Giáo viên</a></li>
                        <li><a href='/PHP/BTL/php/class.php'>Lớp học</a></li>
                        <li><a href='/PHP/BTL/php/student.php'>Học sinh</a></li>
                        <li><a href=''>Phụ huynh</a></li>
                        <li><a href=''>Đăng kí học</a></li>
                        <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                    </ul>
                </div> ";
        }
        ?>

    </header>

    <div class="greeting">

        <div>
            <h1>Chào mừng đến với trang web quản lí trường mầm non</h1>
            <p>Bố mẹ đồng hành với mọi hoạt động của con ở trường</p>
            <button><a href="">Đăng kí học cho bé ngay </a></button>
        </div>
        <div>
            <img src="./images/family.png" alt="">
        </div>
    </div>

</body>
</html>