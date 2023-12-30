<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/teachers.css">
    <title>Tài khoản</title>
    <style>
        h3 {
            margin: 0px 20px 10px 20px;
            text-align:center;
            font-size: 32px;
        }

        .row {
            margin: auto;
        }

        .row .col-md-3 {
            background-color: white;
            text-align: center;
            border-radius: 5px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .row .col-md-9 {
            width: 73.67%;
            border-radius: 5px;
            background-color: #d3f5e0;
            text-align: center;
        }

        img {
            width: 70%;
        }

        button {
            border-radius: 10px;
            padding:8px;
            font-size: 16px;
            background-color: #51ba54;
            color: white;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        button a {
            color: white;
        }

        button:hover a {
            color: white;
        }

        .head {
            border-bottom: 1px solid #c9cacc;
            margin-bottom: 10px;
            max-width: 100%;
            padding: 0px 15px 0px 15px;
            text-align:left;
        }

        .head a {
            border-bottom: 3px solid #0f75bc;
            color: #024da1;
            font-size: 18px;
            line-height: 41px;
            padding: 5px 0 10px;
            text-decoration: none;
            margin-right:10px;
        }

        .info {
            background-color: white;
        }

        p {
            margin: 10px
        }

        .edit-section {
            display: none;
        }
        h4{
            margin: 20px 0px;
        }
        input{
            padding: 5px;
        }
        .col-md-6{
            text-align:left;
            margin-bottom:10px;
            padding: 0px;

        }
    </style>

</head>

<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>
        <?php
            require "../connect.php";
            mysqli_set_charset($conn, 'UTF8');
            session_start();
            if (isset($_SESSION['user_name'])){
        ?>
            <div>
                <ul>
                    <li><a href="/PHP/BTL/php/class.php">Lớp học</a></li>
                    <li><a href="/PHP/BTL/php/parents/student.php">Học sinh</a></li>
                    <li><a href="/PHP/BTL/php/parents/account.php">Tài khoản</a></li>
                    <li><a href="/PHP/BTL/php/parents/register_student.php">Đăng kí học</a></li>
                    <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
                </ul>
            </div>
        <?php
            }else{
        ?>
            <div>
                <ul>
                    <li><a href="/PHP/BTL/php/class.php">Lớp học</a></li>
                    <li><a href="/PHP/BTL/php/parents/student.php">Học sinh</a></li>
                    <li><a href="/PHP/BTL/php/parents/account.php">Tài khoản</a></li>
                    <li><a style='color: red;' href='/PHP/BTL/html/login.html'>Đăng nhập</a></li>
                </ul>
            </div>
        <?php 
            }
        ?>
    </header>

    <div class="table">
        <h3>Chi tiết tài khoản</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img src="/PHP/BTL/images/account.png" alt="account">
                    <p>
                        <?php
                            if (isset($_SESSION['user_name'])){
                                //Hiển thị họ tên giáo viên
                                $user_name = $_SESSION['user_name'];
                                $sql_name = "SELECT * FROM giao_vien WHERE id_giao_vien = '$user_name'";
                                $result= $conn->query($sql_name);
                                if($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    echo "<h4>". $row['ten_giao_vien'] . "</h4>";
                                }
                            }else{
                                echo "<h4>" . "Không có thông tin để hiển thị" ."</h4>";
                            }
                        ?>
                    </p>
                </div>
                <!-- Hiển thị tên tài khoản và tạo nút chỉnh sửa mật khẩu -->
                <div class="col-md-9">
                    <div class="head">
                        <a href="/PHP/BTL/php/parents/account.php" style="border-bottom:none">Thông tin cơ bản</a>
                        <a href="/PHP/BTL/php/parents/account_user.php">Tài khoản</a>
                    </div>
                    <div class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4" style="text-align:left">
                                    <p>Tên tài khoản</p>
                                    <p>Mật khẩu</p>
                                </div>
                                <div class="col-md-8" style="text-align:left">
                                    <?php
                                        // Hiển thị ra user name và nút chỉnh sửa
                                        if (isset($_SESSION['user_name'])){
                                            $user_name = $_SESSION['user_name'];
                                            $sql = "SELECT * FROM users WHERE user_name = '$user_name'";
                                            $result= $conn->query($sql);
                                            if($result->num_rows > 0){
                                                $i = 0;
                                                while ($i< $result->num_rows) {
                                                    $row = $result->fetch_assoc();
                                                    echo "<p>" . $row["user_name"] . "</p>";
                                                    echo "<p>";
                                                    echo "<button id='editButton'>Thay đổi mật khẩu</button>";
                                                    echo "</p>";
                                                    $i++;
                                                }
                                            }
                                        }
                                        else{
                                            echo "<p>Không có thông tin hiển thị</p>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chỉnh sửa thông tin giáo viên -->
                    <div class="edit-section" id="editSection">
                        <h4>Chỉnh sửa tài khoản</h4>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6" style="padding-left:10px">
                                    <label for="newPassword">Mật khẩu mới: </label>
                                    <input type="password" id="newPassword" name="newPassword"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="rePassword">Nhập lại mật khẩu: </label>
                                    <input type="password" id="rePassword" name="rePassword"><br>
                                </div>
                            </div>
                            <button type="submit" name="submit">Save Changes</button>
                        </form>
                        <?php
                            if(isset($_POST['submit'])){
                                $newPassword = $_POST['newPassword'];
                                $rePassword = $_POST['rePassword'];

                                $user_name = $_SESSION['user_name'];

                                // Update password bảng user
                                $sql_update_name = "UPDATE users SET user_password = '$newPassword' WHERE user_name ='$user_name'";
                                $result_update_name = $conn->query($sql_update_name);
                                if ($newPassword===$rePassword) {
                                    if($result_update_name===TRUE){
                                        echo "Thay đổi mật khẩu thành công!";
                                    }
                                    else {
                                        echo "Thay đổi mật khẩu không thành công: " . $conn->error;
                                    }
                                } else {
                                    echo "Mật khẩu chưa khớp ";
                                }
                                $conn->close();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editButton').addEventListener('click', function (e) {
            e.preventDefault(); 
        document.getElementById('editSection').style.display = 'block';
    });
</script>

</body>

</html>
