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
            document.querySelector('#editButton').addEventListener('click', function () {
                document.querySelector('#editSection').style.display = 'block';
            });
        });
    </script>

</head>

<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>
        <?php
            require 'header.php';
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
                                $sql_name = "SELECT * FROM phu_huynh WHERE ten_phu_huynh = (SELECT full_name FROM users WHERE user_name = '$user_name')";
                                $result= $conn->query($sql_name);
                                if($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    echo "<h4>". $row['ten_phu_huynh'] . "</h4>";
                                }
                            }
                            else{
                                echo "<h4>" . "Không có thông tin để hiển thị" . "</h4>";
                            }
                        ?>
                    </p>
                    <?php
                        //Chức năng sửa thông tin giáo viên
                        if (isset($_SESSION['user_name'])){
                            $user_name = $_SESSION['user_name'];

                            $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $position = $row['chuc_vu'];
                                if ($position === 'Phụ huynh') {
                                    echo "<button id='editButton'>Chỉnh sửa thông tin</button>";
                                } 
                            } else {
                                echo "ban chua dang nhap";
                            }   
                        } 
                    ?>
                </div>
                <div class="col-md-9">
                    <div class="head">
                        <a href="/PHP/BTL/php/parents/account.php">Thông tin cơ bản</a>
                        <a href="/PHP/BTL/php/parents/account_parents.php"style="border-bottom:none">Tài khoản</a>
                    </div>
                    <div class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4" style="text-align:left">
                                    <p>ID phụ huynh</p>
                                    <p>Tên phụ huynh</p>
                                    <p>Ngày sinh</p>
                                    <p>Giới tính</p>
                                    <p>Điện thoại</p>
                                </div>
                                <div class="col-md-8" style="text-align:left">
                                <?php
                                    if (isset($_SESSION['user_name'])){
                                        $user_name = $_SESSION['user_name'];
                                        $sql = " SELECT * FROM phu_huynh WHERE ten_phu_huynh = (SELECT full_name FROM users WHERE user_name = '$user_name')";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            $id_phu_huynh = $row["id_phu_huynh"];
                                            $name = $row["ten_phu_huynh"];
                                            $date = $row["ngay_sinh_ph"];
                                            $gender = $row["gioi_tinh_ph"];
                                            $sdt = $row["dien_thoai_ph"];

                                            echo "<p>" . ($id_phu_huynh ?? "Không có") . "</p>";
                                            echo "<p>" . ($name ?? "Không có") . "</p>";
                                            echo "<p>" . ($date ?? "Không có") . "</p>";
                                            echo "<p>" . ($gender ?? "Không có") . "</p>";
                                            echo "<p>" . ($sdt ?? "Không có") . "</p>";
                                        } 
                                    }else {
                                        echo "<p>Không có thông tin hiển thị</p>";
                                    }



                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chỉnh sửa thông tin giáo viên -->
                    <div class="edit-section" id="editSection">
                        <h4>Thay đổi thông tin</h4>
                        <form action="" method="POST">
                            <div class="row" style="text-align:left">
                                <div class="col-md-6">
                                    <label for="newName">Tên phụ huynh:</label>
                                    <input type="text" id="newName" name="newName" value="<?php echo $name;?>"><br>
                                    <br>
                                    <label for="newPhone">Số điện thoại:</label>
                                    <input type="number" id="newPhone" name="newPhone" value="<?php echo $sdt;?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="newPhone">Ngày sinh:</label>
                                    <input type="Date" id="newDate" name="newDate" value="<?php echo $date;?>"><br>
                                    <br>
                                    <label for="newGender">Giới tính:</label>
                                    <select id="newGender" name="newGender">
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </div>
                            </div><br>
                            <button type="submit" name="submit">Save Changes</button>
                        </form>
                        <?php
                            if(isset($_POST['submit'])){
                                $newName = $_POST['newName'];
                                $newPhone = $_POST['newPhone'];
                                $newDate = $_POST['newDate'];
                                $newGender = $_POST['newGender'];

                                $user_name = $_SESSION['user_name'];
                                //Update bảng ph
                                $sql_update_parents = "UPDATE phu_huynh SET ten_phu_huynh = '$newName', dien_thoai_ph = '$newPhone', 
                                            ngay_sinh_ph = '$newDate', gioi_tinh_ph = '$newGender' 
                                            WHERE id_phu_huynh =(SELECT id_phu_huynh FROM phu_huynh 
                                            WHERE ten_phu_huynh = (SELECT full_name FROM users WHERE user_name = '$user_name'))";

                                $result_update = $conn->query($sql_update_parents);
                                
                                // Update fullname bảng user
                                $sql_update_name = "UPDATE users SET full_name = '$newName'WHERE user_name ='$user_name'";
                                $result_update_name = $conn->query($sql_update_name);
                                if ($result_update && $result_update_name) {
                                    echo "Chỉnh sửa thành công!";
                                } else {
                                    echo "Chỉnh sửa không thành công: " . $conn->error;
                                }
                                $conn->close();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
