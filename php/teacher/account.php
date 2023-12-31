<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/teachers.css">
    <script src="/PHP/BTL/js/check_account.js"></script>
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
            const name = document.querySelector("#newName").value;
            const date = document.querySelector("#newDate").value;
            const phone = document.querySelector("#newPhone").value;

            if (name === "" || date === "" || phone === "") {
                alert("Bạn đã nhập thiếu thông tin. Vui lòng kiểm tra lại.");
            } else {
                if (phone.length >= 10) {
                    alert("cập nhật thông tin thành công!");
                } else {
                    alert("Số điện thoại không hợp lệ");
                }
                return phone.length >= 10;
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
                                $sql_name = "SELECT *FROM giao_vien WHERE id_giao_vien = '$user_name'";
                                $result= $conn->query($sql_name);
                                if($result->num_rows > 0){
                                    $row = $result->fetch_assoc();
                                    echo "<h4>". $row['ten_giao_vien'] . "</h4>";
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
                                if ($position === 'Giáo viên') {
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
                        <a href="/PHP/BTL/php/teacher/account.php">Thông tin cơ bản</a>
                        <a href="/PHP/BTL/php/teacher/account_user.php"style="border-bottom:none">Tài khoản</a>
                    </div>
                    <div class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4" style="text-align:left">
                                    <p>Lớp phụ trách</p>
                                    <p>Tên giáo viên</p>
                                    <p>Mã giáo viên</p>
                                    <p>Giới tính</p>
                                    <p>Ngày sinh</p>
                                    <p>Điện thoại</p>
                                </div>
                                <div class="col-md-8" style="text-align:left">
                                <?php
                                    if (isset($_SESSION['user_name'])){
                                        $user_name = $_SESSION['user_name'];
                                        $sql = "SELECT * FROM giao_vien WHERE id_giao_vien = '$user_name'";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            $name = $row["ten_giao_vien"];
                                            $id_lop = $row["lop_phu_trach"];
                                            $id_gv = $row["id_giao_vien"];
                                            $gender = $row["gioi_tinh_gv"];
                                            $ns = $row["ngay_sinh_gv"];
                                            $sdt = $row["dien_thoai_gv"];

                                            echo "<p>" . ($id_lop ?? "Không có") . "</p>";
                                            echo "<p>" . ($name ?? "Không có") . "</p>";
                                            echo "<p>" . ($id_gv ?? "Không có") . "</p>";
                                            echo "<p>" . ($gender ?? "Không có") . "</p>";
                                            echo "<p>" . ($ns ?? "Không có") . "</p>";
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
                        <form id ="checkForm" action="" method="POST">
                            <div class="row" style="text-align:left">
                                <div class="col-md-6">
                                    <label for="newName">Tên giáo viên:</label>
                                    <input type="text" id="newName" name="newName" value="<?php echo $name;?>"><br>
                                    <br>
                                    <label for="newPhone">Số điện thoại:</label>
                                    <input type="number" id="newPhone" name="newPhone" value="<?php echo $sdt;?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="newDate">Ngày sinh:</label>
                                    <input type="date" id="newDate" name="newDate" value="<?php echo $ns;?>"><br>
                                    <br>
                                    <label for="newGender">Giới tính:</label>
                                    <select id="newGender" name="newGender">
                                        <option value="Nam" <?php if ($gender === 'Nam') echo 'selected'; ?>>Nam</option>
                                        <option value="Nữ" <?php if ($gender === 'Nữ') echo 'selected'; ?>>Nữ</option>
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

                                //Update bảng giáo viên
                                $sql_update_teacher = "UPDATE giao_vien SET ten_giao_vien = '$newName', dien_thoai_gv = '$newPhone',
                                    ngay_sinh_gv = '$newDate', gioi_tinh_gv = '$newGender' WHERE id_giao_vien = '$user_name'";

                                $result_update = $conn->query($sql_update_teacher);
                                // Update fullname bảng user
                                $sql_update_name = "UPDATE users SET full_name = '$newName', phone = '$newPhone' WHERE user_name ='$user_name'";
                                $result_update_name = $conn->query($sql_update_name);
                                if ($result_update && $result_update_name && $newName != NULL && $newPhone!=NULL && $newDate!=NULL) {
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
