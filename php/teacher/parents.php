<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/student.css">
    <title>Phụ huynh</title>
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

    <?php
        if (isset($_SESSION['user_name'])) {
            $user_name = $_SESSION['user_name'];
    
            $query = "SELECT chuc_vu, lop_phu_trach FROM users JOIN giao_vien ON users.user_name = giao_vien.id_giao_vien WHERE user_name = '$user_name'";
            $result = $conn->query($query);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $position = $row['chuc_vu'];
            } else {
                echo "Bạn chưa đăng nhập";
            }   
        } 
    ?>

<div class="container table">
        <div class="row">
            <div class="col-md-8 search-container">
                <!-- Tìm kiếm theo lựa chọn -->
                <form method="post">
                    <label for="searchFilter">Lọc theo:</label>
                    <select id="searchFilter" name="searchFilter">
                        <option style="color: gray">--Chọn--</option>
                        <option value="ten" <?php echo (isset($_POST['searchFilter']) && $_POST['searchFilter'] == 'ten') ? 'selected' : ''; ?>>Họ và tên</option>
                        <option value="id" <?php echo (isset($_POST['searchFilter']) && $_POST['searchFilter'] == 'id') ? 'selected' : ''; ?>>ID</option>
                        <option value="quan_he" <?php echo (isset($_POST['searchFilter']) && $_POST['searchFilter'] == 'quan_he') ? 'selected' : ''; ?>>Quan hệ</option>
                    </select>
                    <label for="search">Tìm kiếm:</label>
                    <input type="text" id="search" name="search" class="search-input" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                    <button type="submit" id="searchButton">Tìm kiếm</button>
                </form>
            </div> 
        </div>
        <h3 class="text-center mb-3">Danh sách phụ huynh học sinh</h3>

        <?php
            if (isset($_SESSION['user_name'])){
                $user_name = $_SESSION['user_name'];
                if(isset($_POST['searchFilter'])){
                    $searchFilter = $_POST['searchFilter'];
                }else{
                    $searchFilter = '';
                }
                if(isset($_POST['search'])){
                    $searchValue = $_POST['search'];
                }else{
                    $searchValue = '';
                }
                // Đưa ra id lớp giáo viên phụ trách
                $sql_name = "SELECT *FROM giao_vien WHERE id_giao_vien = '$user_name'";
                $result_name = $conn->query($sql_name);
                $row = $result_name->fetch_assoc();
                $id_class = $row['lop_phu_trach'];
                $sql = "SELECT hoc_sinh.*, giam_ho.* FROM hoc_sinh JOIN giam_ho ON hoc_sinh.id_hoc_sinh = giam_ho.id_hoc_sinh WHERE id_lop ='$id_class'";
                if (!empty($searchValue)) {
                    switch ($searchFilter) {
                        case 'ten':
                            $sql .= " AND (ten_phu_huynh LIKE '%$searchValue%' OR hoc_sinh.ten_hoc_sinh LIKE '%$searchValue%')";
                            break;
                        case 'id':
                            $sql .= " AND (hoc_sinh.id_hoc_sinh LIKE '%$searchValue%' OR id_phu_huynh LIKE '%$searchValue%')";
                            break;
                        case 'quan_he':
                            $sql .= "AND (quan_he LIKE '%$searchValue%')";
                            break;
                    }
                }
                $result = $conn->query($sql);
                if ($result === false) {
                    die("Query failed: " . $conn->error);
                }
                if ($result->num_rows >0) {
                    echo "<table id='studentTable' class='my-table' border='2'>
                        <tr style='text-align:center'>
                            <th>#</th>
                            <th>ID Lớp</th>
                            <th>ID Học sinh</th>
                            <th>Họ tên</th>
                            <th>ID phụ huynh</th>
                            <th>Họ tên</th>
                            <th>Quan hệ</th>
                            <th>Thao tác</th>
                        </tr>";
                    $i = 0;
                    while ($i<$result->num_rows) {
                        $row = $result->fetch_assoc();
                        if ($i % 2 == 0) {
                            $class = 'even-row';
                        } else {
                            $class = 'odd-row';
                        }                    
                        echo "<tr class='$class'>
                                <td>". $i+1 ."</td>
                                <td>".$row["id_lop"]."</td>
                                <td>".$row["id_hoc_sinh"]."</td>
                                <td>".$row["ten_hoc_sinh"]."</td>
                                <td>".$row["id_phu_huynh"]."</td>
                                <td>".$row["ten_phu_huynh"]."</td>
                                <td>".$row["quan_he"]."</td>
                                <td style='width:20%'>";
                                    if ($position === 'Giáo viên') {
                                        echo "<a href='/PHP/BTL/php/teacher/info_parents.php?id_hoc_sinh=" . $row["id_hoc_sinh"] . "&id_phu_huynh=" . $row["id_phu_huynh"] . "' title='Xem thông tin đầy đủ'><img src='/PHP/BTL/images/full_info.png' style='width:20%'></a>";
                                    }
                            echo "</td>
                            </tr>";
                        $i++;
                    }
                    echo '</table>';
                } else {
                    echo '<table id="studentTable" class="my-table" border="2">';
                    echo "<tr><td>Không tìm thấy kết quả.</td></tr>";
                    echo '</table>';
                }
            }else{
                echo '<table id="studentTable" class="my-table" border="2">';
                    echo "<tr><td>Không tìm thấy kết quả.</td></tr>";
                    echo '</table>';
            }
            $conn->close();
        ?>
    </div>

</body>

</html>
