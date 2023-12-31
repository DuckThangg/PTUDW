<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
    <style>
        #studentTable {
            border-collapse: collapse;
        }

        th,td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>


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
            require './php/connect.php';
            $user_name = $_SESSION['user_name'];
            $sql = "SELECT *FROM users WHERE user_name = '$user_name' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_role = $row['chuc_vu'];
                // Tài khoản đăng nhập là giáo viên
                if($user_role == 'Giáo viên'){
                    echo "
                        <div>
                            <ul id='menu-list'>
                            <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/teacher/class.php'>Lớp học</a></li>
                            <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/teacher/student.php'>Học sinh</a></li>
                            <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/parents.php'>Phụ huynh</a></li>
                            <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/teacher/account.php'>Tài khoản</a></li>
                            <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }
                // Tài khoản đăng nhập là phụ huynh
                elseif($user_role == 'Phụ huynh'){
                    echo "
                        <div>
                            <ul>
                                <li><a href='/PHP/BTL/php/teacher.php'>Giáo viên</a></li>
                                <li><a href='/PHP/BTL/php/class.php'>Lớp học</a></li>
                                <li><a href='/PHP/BTL/php/parents/student.php'>Học sinh</a></li>
                                <li><a href='/PHP/BTL/php/parents/register_student.php'>Đăng ký học</a></li>
                                <li><a href='/PHP/BTL/php/parents/account.php'>Tài khoản</a></li>
                                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }else{
                    echo "
                        <div>
                            <ul id='menu-list'>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/teacher.php'>Giáo viên</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/class.php'>Lớp học</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/student.php'>Học sinh</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/parents.php'>Phụ huynh</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/teacher/account.php'>Tài khoản</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a href='/PHP/BTL/php/admin/registration_form.php'>Đăng kí học</a></li>
                                <li onmouseover='moveItem(this, true)' onmouseout='moveItem(this, false)'><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                            </ul>
                        </div> ";
                }
            }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const loginSuccess = urlParams.get('login_success');

            if (loginSuccess === 'true') {
                setTimeout(function() {
                    alert('Đăng nhập thành công');
                }, 100); // Thời gian trễ 500ms (0.5 giây)
            }
        });


        function moveItem(element, isOver) {
            if (isOver) {
                element.style.transform = 'translateY(-5px)'; // Di chuyển lên trên 10px khi di chuột vào
                element.style.fontWeight = 'normal'; // Chữ đậm hơn khi di chuột vào
            } else {
                element.style.transform = 'translateY(0)'; // Reset vị trí khi di chuột ra
                element.style.fontWeight = 'bold'; // Trở về font-weight bình thường khi di chuột ra
            }
        }
    </script>
</body>
</html>