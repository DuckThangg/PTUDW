<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/teachers.css">
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
            <a href="/PHP/BTL/index.php"> <img  src="../../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher.php">Giáo viên</a></li>
                <li><a href="/PHP/BTL/php/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/student.php">Học sinh</a></li>
                <li><a href="/PHP/BTL/php/parents.php">Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/admin/registration_form.php">Đăng kí học</a></li>
            </ul>
        </div>
    </header>

    <?php
        require '../connect.php';
        
        mysqli_set_charset($conn, 'UTF8');
        session_start();
        $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
        // if (isset($_SESSION['user_name'])){
        //     $user_name = $_SESSION['user_name'];

        //     $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
        //     $result = $mysqli->query($query);

        //     if ($result && $result->num_rows > 0) {
        //         $row = $result->fetch_assoc();
        //         $position = $row['chuc_vu'];

        //         if ($position === 'ADMIN') {
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thêm giáo viên</a></button>";
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Xóa giáo viên</a></button>";
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thay đổi thông tin giáo viên</a></button>";
        //         } elseif ($position === 'Giáo viên') {
        //             echo "<button><a href='/PHP/BTL/php/list_class.php'>Thay đổi thông tin</a></button>";
        //         } elseif ($position === 'Phụ huynh') {
        //         } 
        //     } else {
        //         echo "ban chua dang nhap";
        //     }   
        // } 
    ?>
    <form style="text-align:center" action="" method="post">
    
        <div class="table">
        <?php
            require '../connect.php';
            mysqli_set_charset($conn, 'UTF8');
            $sql = "SELECT * FROM phieu_dang_ky";

            $result= $conn->query($sql);

            if($result->num_rows > 0){
                echo "<table class='my-table' border='2'>
                        <tr>
                            <th>ID phiếu</th>
                            <th>Tên học sinh</th>
                            <th>Ngày sinh </th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th>Loại lớp đăng kí</th>
                            <th>Tên phụ huynh</th>
                            <th>Số điện thoại</th>
                            <th>Năm học</th>
                            <th>Duyệt</th>
                        </tr>";

                $i = 0;
                while($row = $result->fetch_assoc()) {
                    $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                    echo "<tr class='$class'>
                            <td>".$row["id_phieu"]."</td>
                            <td>".$row["ten_hoc_sinh"]."</td>
                            <td>".$row["ngay_sinh_hs"]."</td>
                            <td>".$row["gioi_tinh_hs"]."</td>
                            <td>".$row["dia_chi_hs"]."</td>
                            <td>".$row["loai_lop_dang_ky"]."</td>
                            <td>".$row["ten_phu_huynh"]."</td>
                            <td>".$row["dien_thoai_phu_huynh"]."</td>
                            <td>".$row["nam_hoc"]."</td>
                            <td><input type='checkbox' name='approve[]' value='".$row["id_phieu"]."'></td>
                        </tr>";
                    $i++;
                }
                echo "</table>";
            }
            else{
                echo "Không có thông tin để hiển thị";
            }
        ?>
        </div>
        <input style="padding:10px;font-size:15px;" type="submit" name="submit" value="Phê duyệt">
    </form>

    <?php
        require '../connect.php';
        mysqli_set_charset($conn, 'UTF8');
                
        // Kiểm tra nút submit được nhấn
        if (isset($_POST['submit'])) {
            // Kiểm tra xem 'approve' có tồn tại và là mảng không
            if (isset($_POST['approve']) && is_array($_POST['approve']) && !empty($_POST['approve'])) {
                foreach ($_POST['approve'] as $approveId) {
                    $sql_select = "SELECT * FROM phieu_dang_ky WHERE id_phieu = '$approveId'";
                    $result = $conn->query($sql_select);
                
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    
                        // Thêm dữ liệu của học sinh vào bảng hoc_sinh
                        $sql_insert_hoc_sinh = "INSERT INTO hoc_sinh (id_hoc_sinh, ten_hoc_sinh, ngay_sinh_hs, gioi_tinh, nam_hoc)
                                                VALUES ('HS".$row["id_phieu"]."', '".$row["ten_hoc_sinh"]."', '".$row["ngay_sinh_hs"]."', '".$row["gioi_tinh_hs"]."', '".$row["nam_hoc"]."')";
                        $conn->query($sql_insert_hoc_sinh);
                    
                        // Thêm dữ liệu của phụ huynh vào bảng phu_huynh
                        $sql_insert_phu_huynh = "INSERT INTO phu_huynh (id_phu_huynh, ten_phu_huynh, dien_thoai_ph)
                                                VALUES ('PH".$row["id_phieu"]."', '".$row["ten_phu_huynh"]."', '".$row["dien_thoai_phu_huynh"]."')";
                        $conn->query($sql_insert_phu_huynh);

                        // Thêm dữ liệu của phụ huynh vào bảng lich_su_dang_ki
                        $sql_insert_lich_su = "INSERT INTO lich_su_dang_ki (id_phieu,ten_hoc_sinh, ngay_sinh_hs, gioi_tinh_hs, dia_chi_hs, loai_lop_dang_ky, ten_phu_huynh, dien_thoai_phu_huynh, nam_hoc)
                                           VALUES ('".$row["id_phieu"]."','".$row["ten_hoc_sinh"]."', '".$row["ngay_sinh_hs"]."', '".$row["gioi_tinh_hs"]."', '".$row["dia_chi_hs"]."', '".$row["loai_lop_dang_ky"]."', '".$row["ten_phu_huynh"]."', '".$row["dien_thoai_phu_huynh"]."', '".$row["nam_hoc"]."')";
                        $conn->query($sql_insert_lich_su);

                    // Xóa dữ liệu từ bảng phieu_dang_ky
                        $sql_delete = "DELETE FROM phieu_dang_ky WHERE id_phieu = '$approveId'";
                        $conn->query($sql_delete);
                    }
                }
                echo "Thêm dữ liệu thành công!";
            } else {
                echo "Vui lòng chọn ít nhất một bản ghi để thêm.";
            }
        }
?>


</body>
</html>