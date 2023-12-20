<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/student.css">
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search_input");
            filter = input.value.toUpperCase();
            table = document.getElementById("studentTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                if (i === 0) { 
                    continue;
                }
                var found = false;
                for (var j = 0; j <= 6; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
    <title>Học sinh</title>
</head>
<body>
    <header>
        <div>
            <a href="/PHP/BTL/index.php"> <img  src="../images/icon-2.png" alt=""> </a>
        </div>

        <div>
            <ul>
                <li><a href="/PHP/BTL/php/teacher/class.php">Lớp học</a></li>
                <li><a href="/PHP/BTL/php/teacher/student.php">Học sinh</a></li>
                <li><a href=''>Phụ huynh</a></li>
                <li><a href="/PHP/BTL/php/teacher/account.php">Tài khoản</a></li>
                <li><a style='color: red;' href='/PHP/BTL/php/logout.php'>Đăng xuất</a></li>
            </ul>
        </div>
    </header>

    <?php
        require 'connect.php';
        
        mysqli_set_charset($conn, 'UTF8');
        session_start();
        $mysqli = new mysqli("localhost", "root", "", "truong_mam_non");// có thể bỏ nếu k báo lỗi k tìm thấy biến mysqli
        if (isset($_SESSION['user_name'])){
            $user_name = $_SESSION['user_name'];

            $query = "SELECT chuc_vu FROM users WHERE user_name = '$user_name'";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $position = $row['chuc_vu'];
            } else {
                echo "ban chua dang nhap";
            }   
        } 
    ?>

<div class="container table">
        <div class="row">
            <div class="col-md-8 search-container">
                <form method="post">
                    <label for="searchFilter">Lọc theo:</label>
                    <select id="searchFilter" name="searchFilter" >
                        <option style="color:gray">--Chọn--</option>
                        <option value="ten_hoc_sinh" <?php $searchFilter = isset($_POST['searchFilter']) ? $_POST['searchFilter'] : '';  echo ($searchFilter == 'ten_hoc_sinh');?>>Tên học sinh</option>
                        <option value="id_hoc_sinh" <?php $searchFilter = isset($_POST['searchFilter']) ? $_POST['searchFilter'] : '';  echo ($searchFilter == 'id_hoc_sinh'); ?>>ID Học sinh</option>
                        <option value="ngay_sinh" <?php $searchFilter = isset($_POST['searchFilter']) ? $_POST['searchFilter'] : ''; echo ($searchFilter == 'Ngày sinh');?>>Ngày sinh</option>
                        <option value="gioi_tinh" <?php $searchFilter = isset($_POST['searchFilter']) ? $_POST['searchFilter'] : ''; echo ($searchFilter == 'Ngày sinh');?>>Giới tính</option>
                    </select>
                    <label for="search">Tìm kiếm:</label>
                    <input type="text" id="search" name="search" class="search-input" value="<?php if(isset($_POST['search'])){echo $_POST['search'];};?>">
                    <button type="submit" id="searchButton">Tìm kiếm</button>
                </form>
            </div> 
            <!-- <div class="col-md-6">
                <a>Hiển thị</a>
                <select>

                </select>
                <a>kết quả trên một trang</a>
            </div> -->
            
            <div class="col-md-3">
                <form method="post" class="">
                    <button>Thêm học sinh</button>
                </form>
            </div>
        </div>
        <h3 class="text-center mb-3">Danh sách học sinh</h3>

        <?php
            $user_name = $_SESSION['user_name'];
            $searchFilter = isset($_POST['searchFilter']) ? $_POST['searchFilter'] : '';
            $searchValue = isset($_POST['search']) ? $_POST['search'] : '';


            
            // Đưa ra id lớp giáo viên phụ trách
            $sql_name = "SELECT users.*, giao_vien.* FROM users LEFT JOIN giao_vien ON SOUNDEX(users.fullname) = SOUNDEX(giao_vien.ten_giao_vien) WHERE users.user_name = '$user_name'";
            $result_name = $conn->query($sql_name);
            $row = $result_name->fetch_assoc();
            $id_class = $row['lop_phu_trach'];
            $sql = "SELECT * FROM hoc_sinh WHERE id_lop LIKE '%$id_class%'";

            if (!empty($searchValue)) {
                switch ($searchFilter) {
                    case 'ten_hoc_sinh':
                        $sql .= " AND ten_hoc_sinh LIKE '%$searchValue%'";
                        break;
                    case 'id_hoc_sinh':
                        $sql .= " AND id_hoc_sinh LIKE '%$searchValue%'";
                        break;
                    case 'ngay_sinh':
                        $sql .= " AND (ngay_sinh_hs LIKE '%$searchValue%' 
                            OR DATE_FORMAT(ngay_sinh_hs, '%d/%m/%Y') LIKE '%$searchValue%'
                            OR DATE_FORMAT(ngay_sinh_hs, '%Y-%m-%d') LIKE '%$searchValue%')";
                        break;
                    case 'gioi_tinh':
                        $sql .= "AND (gioi_tinh LIKE '%$searchValue%')";
                }
            }
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table id='studentTable' class='my-table' border='2'>
                    <tr style='text-align:center'>
                        <th>ID Lớp</th>
                        <th>ID Học sinh</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Năm học</th>
                        <th>Thao tác</th>
                    </tr>";
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $class = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                    echo "<tr class='$class'>
                            <td>".$row["id_lop"]."</td>
                            <td>".$row["id_hoc_sinh"]."</td>
                            <td>".$row["ten_hoc_sinh"]."</td>
                            <td>".$row["ngay_sinh_hs"]."</td>
                            <td>".$row["gioi_tinh"]."</td>
                            <td>".$row["nam_hoc"]."</td>
                            <td style='width:20%'>";
                                if($position === 'Giáo viên') {
                                    echo "<a href='/PHP/BTL/php/teacher/list_class.php' style='margin-right:10px'><img src='/PHP/BTL/images/account.png' style='width:20%'></a>";
                                    echo "<a href='/PHP/BTL/php/teacher/list_class.php' style='margin-right:10px'><img src='/PHP/BTL/images/account.png' style='width:20%'></a>";
                                    echo "<a href='/PHP/BTL/php/teacher/list_class.php'><img src='/PHP/BTL/images/account.png' style='width:20%'></a>";
                                };
                            "</td>";
                        "</tr>";
                $i++;
                }
            } else {
                echo "<tr><td>Không tìm thấy kết quả.</td></tr>";
            }

            echo '</table>';

            $conn->close();
        ?>
    </div>
</body>
</html>