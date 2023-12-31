<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/class.css">
    <title>Lớp học</title>
    <style>
        .my-table th, .my-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img src="../../images/icon-2.png" alt=""> </a>
        </div>
        <?php
            require "header.php";
        ?>
    </header>

    <form style="text-align:center" action="" method="post" id="registrationForm">
        <div class="table">
            <?php
                require 'connect.php';
                mysqli_set_charset($conn, 'UTF8');

                if (isset($_SESSION['user_name'])) {
                    $user_name = $_SESSION['user_name'];

                    $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $position = $row['chuc_vu'];

                        if ($position === 'Giáo viên') {
                            $classQuery = "SELECT * FROM lop WHERE id_gv_phu_trach = '$user_name'";
                            $classResult = $conn->query($classQuery);

                            if ($classResult && $classResult->num_rows > 0) {
                                echo "<table class='my-table' border='2'>
                                        <tr>
                                            <th>ID Lớp</th>
                                            <th>Tên lớp</th>
                                            <th>Sĩ số</th>
                                        </tr>";

                                while ($classRow = $classResult->fetch_assoc()) {
                                    echo "<tr style='background-color:#a8e6cf'>
                                            <td>" . $classRow["id_lop"] . "</td>
                                            <td>" . $classRow["ten_lop"] . "</td>
                                            <td>" . $classRow["so_luong_hs"] . "</td>
                                        </tr>";
                                }

                                echo "</table>";
                            } else {
                                $update = "UPDATE lop
                                    JOIN giao_vien ON lop.id_gv_phu_trach = giao_vien.id_giao_vien
                                    SET lop.gv_phu_trach = giao_vien.ten_giao_vien;
                                ";
                                $result= $conn->query($update);

                                $sql = "SELECT * FROM lop";

                                $result= $conn->query($sql);

                                if($result->num_rows > 0){
                                    echo "<table class='my-table' border='2'>
                                        <tr>
                                            <th>ID Lớp</th>
                                            <th>Giáo viên phụ trách</th>
                                            <th>Tên lớp</th>
                                            <th>Sĩ số</th>
                                            <th>Đăng ký</th>
                                        </tr>";

                                    $i = 0;
                                    while($row = $result->fetch_assoc()) {
                                        $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                                        echo "<tr class='$class'>
                                                <td>".$row["id_lop"]."</td>
                                                <td>".$row["gv_phu_trach"]."</td>
                                                <td>".$row["ten_lop"]."</td>
                                                <td>".$row["so_luong_hs"]."</td>
                                                <td><input type='checkbox'  name='register[]' value='".$row["id_lop"]."'></td>
                                            </tr>";
                                        $i++;
                                    }
                                    echo "</table>";
                                    echo '<input style="margin-top:20px;padding:10px;font-size:15px;" type="submit" name="submit" value="Đăng ký lớp học" id="registerButton">';
                                }
                            }
                        } else {
                            echo "Bạn không phải là giáo viên.";
                        }
                    } else {
                        echo "Lỗi khi kiểm tra chức vụ: " . $conn->error;
                    }
                } else {
                    echo "Bạn chưa đăng nhập.";
                }
            ?>
        </div>
    </form>

    <?php
    if (isset($_POST['submit']) && isset($_SESSION['user_name'])) {
        if (!empty($_POST['register'])) {
            $user_name = $_SESSION['user_name'];

            $query_teacher ="SELECT * FROM giao_vien WHERE id_giao_vien ='$user_name'";
            $result_teacher = $conn->query($query_teacher);
            $row = $result_teacher->fetch_assoc();
            $nameTeacher = $row['ten_giao_vien'];

            $sql_check_class = "SELECT COUNT(*) as count FROM lop WHERE id_gv_phu_trach = '$user_name'";
            $result_check_class = $conn->query($sql_check_class);

            if ($result_check_class && $result_check_class->num_rows > 0) {
                $row = $result_check_class->fetch_assoc();
                $class_count = $row['count'];

                foreach ($_POST['register'] as $registerId) {
                    // Check if the class is already registered by another teacher
                    $check_class = "SELECT id_gv_phu_trach FROM lop WHERE id_lop='$registerId'";
                    $result_check = $conn->query($check_class);
                    $row_check = $result_check->fetch_assoc();
                    $check_teacher = $row_check['id_gv_phu_trach'];

                    if ($class_count == 0 && $check_teacher == NULL) {
                        $updateRegistration = "UPDATE lop SET id_gv_phu_trach = '$user_name', gv_phu_trach = '$nameTeacher' WHERE id_lop = '$registerId'";
                        $update = "UPDATE giao_vien SET lop_phu_trach = '$registerId' WHERE id_giao_vien = '$user_name'";
                        $update_lpt="UPDATE lop_phu_trach SET id_giao_vien = '$user_name' WHERE id_lop = '$registerId'";

                        $resultUpdateRegistration = $conn->query($updateRegistration);
                        $resultUpdate = $conn->query($update);
                        $resultUpdate_lpt = $conn->query($update_lpt);
                        
                        if ($conn->query($updateRegistration) !== TRUE || $conn->query($update) !== TRUE || $conn->query($update_lpt) !== TRUE) {
                            echo "Lỗi khi cập nhật dữ liệu: " . $conn->error;
                        }
                    } else {
                        echo '<script>alert("Lớp đã có người đăng ký hoặc bạn đã được phân công cho một lớp. Không thể đăng ký.");</script>';
                    }
                }
            } else {
                echo "Lỗi khi kiểm tra phân công lớp: " . $conn->error;
            }
        } else {
            echo "Vui lòng chọn ít nhất một lớp để đăng ký.";
        }
    }
    $conn->close();
    ?>
</body>
</html>
