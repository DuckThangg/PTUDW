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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('#checkForm').onsubmit = check;

            document.querySelector('#editButton').addEventListener('click', function () {
                document.querySelector('#editSection').style.display = 'block';
            });
        });

        function check() {
                const newPassword = document.querySelector("#newPassword").value;
                const rePassword = document.querySelector("#rePassword").value;

                //Check pass có ít nhất ký tự hoa /thường/ số
                const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

                if (newPassword === "" || rePassword === "") {
                    alert("Không được để trống");
                }
                else{
                    if(newPassword.length >= 8 && rePassword === newPassword && passwordRegex.test(newPassword)){
                        alert("Cập nhật thông tin thành công!")
                    }
                    else{
                        if(newPassword.length < 8){
                            alert("Mật khẩu yêu cầu 8 ký tự trở lên!")
                        }
                        else if(newPassword != rePassword ){
                            alert("Mật khẩu không trùng nhau!")
                        }
                    }
                }
            window.location.reload();
        }
    </script>
</head>

<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>
        <?php
            require "header.php";
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
                        <a href="/PHP/BTL/php/teacher/account.php" style="border-bottom:none">Thông tin cơ bản</a>
                        <a href="/PHP/BTL/php/teacher/account_user.php">Tài khoản</a>
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
                        <form id='checkForm' action="" method="POST">
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
                                $sql_update_name = "UPDATE users 
                                    SET user_password = '$newPassword' 
                                    WHERE user_name ='$user_name' 
                                    AND CHAR_LENGTH('$newPassword') >= 8 
                                    AND '$newPassword' REGEXP BINARY '[A-Z]'";

                                $result_update_name = $conn->query($sql_update_name);
                                if ($newPassword===$rePassword && strlen($newPassword) > 8) {
                                    if($result_update_name===TRUE){
                                        echo "Thay đổi mật khẩu thành công!";
                                    }
                                    else {
                                        echo "Thay đổi mật khẩu không thành công: " . $conn->error;
                                    }
                                } else {
                                    echo "Mật khẩu chưa đúng yêu cầu ";
                                }
                                $conn->close();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

</body>

</html>
