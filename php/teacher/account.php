<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/teachers.css">
    <title>Tài khoản</title>
</head>

<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="/PHP/BTL/images/icon-2.png" alt=""> </a>
        </div>
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
                            $result = $mysqli->query($query);

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
                        <form action="" method="POST">
                            <div class="row" style="text-align:left">
                                <div class="col-md-6">
                                    <label for="newName">Tên giáo viên:</label>
                                    <input type="text" id="newName" name="newName" value="<?php echo $name;?>"><br>
                                    <br>
                                    <label for="newPhone">Số điện thoại:</label>
                                    <input type="number" id="newPhone" name="newPhone" value="<?php echo $sdt;?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="newPhone">Ngày sinh:</label>
                                    <input type="Date" id="newDate" name="newDate" value="<?php echo $ns;?>"><br>
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

                                //Update bảng giáo viên
                                $sql_update_teacher = "UPDATE giao_vien SET ten_giao_vien = '$newName', dien_thoai_gv = '$newPhone',
                                    ngay_sinh_gv = '$newDate', gioi_tinh_gv = '$newGender' WHERE id_giao_vien = '$user_name'";

                                $result_update = $conn->query($sql_update_teacher);
                                // Update fullname bảng user
                                $sql_update_name = "UPDATE users SET fullname = '$newName', ngay_sinh = '$newDate', phone = '$newPhone' WHERE user_name ='$user_name'";
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

    <script>
        document.getElementById('editButton').addEventListener('click', function (e) {
            e.preventDefault(); 
        document.getElementById('editSection').style.display = 'block';
    });
</script>

</body>

</html>
