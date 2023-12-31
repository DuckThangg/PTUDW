<?php
            require "connect.php";
            mysqli_set_charset($conn, 'UTF8');
            session_start();
            $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
            if (isset($_SESSION['user_name'])){
        ?>
            <div>
                <ul>
                    <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                    <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                    <li><a href='/PHP/BTL/php/teacher/parents.php'>Phụ huynh</a></li>
                    <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                    <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                </ul>
            </div>
        <?php
            }else{
        ?>
            <div>
                <ul>
                    <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                    <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                    <li><a href='/PHP/BTL/php/teacher/parents.php'>Phụ huynh</a></li>
                    <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                    <li><a style='color: red;' href='/PHP/BTL/html/login.html'>Đăng nhập</a></li>
                </ul>
            </div>
        <?php 
            }
    ?>