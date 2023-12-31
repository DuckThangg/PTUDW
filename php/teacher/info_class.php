<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/list_class.css">
    <title>Document</title>
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


    <div class="form">
        <form action="" method="get">
            <h2>Xem thông tin lớp học</h2>
            <div class="input-group">
                <label for="id_lop">ID lớp học</label>
                <input type="text" id="id_lop" name="id_lop">
            </div>

            <input type="submit" value="Tìm">
        </form>
    </div>

    


    <?php
        if(isset($_GET["id_lop"])){
            echo "<div class='table'>";
            require 'connect.php';
            mysqli_set_charset($conn, 'UTF8');
            $id_lop=$_GET["id_lop"];

            $sql = "SELECT * FROM hoc_sinh WHERE id_lop = '$id_lop'";

            $result= $conn->query($sql);

            if($result->num_rows > 0){
                echo "<table class='my-table' border='2'>
                        <tr>
                            <th>#</th>
                            <th>ID Lớp</th>
                            <th>ID Học sinh</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>Năm học</th>
                            <th>Thao tác</th>
                        </tr>";
                $i = 0;
                while($row = $result->fetch_assoc()) {
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
                            <td>".$row["ngay_sinh_hs"]."</td>
                            <td>".$row["gioi_tinh"]."</td>
                            <td>".$row["nam_hoc"]."</td>
                        </tr>";
                    $i++;
                }
                echo "</table>";
            }
            else{
                echo "Không có thông tin để hiển thị";
            }
            $conn->close();
        }
        echo "</div>";
    ?>
    </div>

</body>
</html>