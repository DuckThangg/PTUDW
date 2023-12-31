<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PHP/BTL/css/bootstrap.css">
    <link rel="stylesheet" href="/PHP/BTL/css/teachers.css">
    <title>Thông tin học sinh</title>
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
        // Nếu đưa vào id_hoc_sinh
        if (isset($_GET['id_hoc_sinh']) && isset($_GET['id_phu_huynh'])) {
            require "connect.php";
            mysqli_set_charset($conn, 'UTF8');

            $id_hoc_sinh = $_GET['id_hoc_sinh'];
            $id_phu_huynh = $_GET['id_phu_huynh'];

        }
    ?>

    <div class="table">
        <h3>Thông tin chi tiết</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img src="/PHP/BTL/images/account.png" alt="account">
                    <p>
                        <?php
                        if (isset($_GET['id_phu_huynh'])){
                            $sql = "SELECT * FROM phu_huynh WHERE id_phu_huynh = '$id_phu_huynh'";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0){
                                $row = $result->fetch_assoc();
                                echo "<h4>". $row['ten_phu_huynh'] . "</h4>";
                            }
                            else{
                                echo "<h3>Không có thông tin hiển thị</h3>";
                            }
                        }else{
                            echo "<h3>Không có thông tin hiển thị</h3>";
                        }
                        ?>
                    </p>
                </div>
                <div class="col-md-9">
                    <div class="head">
                        <a href="/PHP/BTL/php/teacher/account.php">Thông tin chi tiết</a>
                    </div>
                    <div class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5" style="text-align:left">
                                    <p>ID Phụ huynh</p>
                                    <p>Họ và tên</p>
                                    <p>Ngày sinh</p>
                                    <p>Giới tính</p>
                                    <p>Người được giám hộ</p>
                                    <p>ID học sinh</p>
                                    <p>Điện thoại</p>
                                </div>
                                <!-- Hiển thị thông tin chi tiết của học sinh từ bảng học sinh với bảng giám hộ và phụ huynh-->
                                <div class="col-md-7" style="text-align:left">
                                    <?php
                                    if (isset($_GET['id_hoc_sinh']) && isset($_GET['id_phu_huynh'])){
                                        $sql = "SELECT hoc_sinh.*, giam_ho.*, phu_huynh.*
                                        FROM hoc_sinh
                                        JOIN giam_ho ON hoc_sinh.id_hoc_sinh = giam_ho.id_hoc_sinh
                                        JOIN phu_huynh ON giam_ho.id_phu_huynh = phu_huynh.id_phu_huynh
                                        WHERE hoc_sinh.id_hoc_sinh = '$id_hoc_sinh';
                                        ";
                                        $result= $conn->query($sql);
                                        if($result->num_rows > 0){
                                            $i = 0;
                                            while ($i<$result->num_rows) {
                                                $row = $result->fetch_assoc();
                                                echo "<p>" . ($id_phu_huynh ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["ten_phu_huynh"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["ngay_sinh_ph"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["gioi_tinh_ph"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["ten_hoc_sinh"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["id_hoc_sinh"] ?? "Không có") . "</p>";
                                                echo "<p>" . ($row["dien_thoai_ph"] ?? "Không có") . "</p>";
                                                $i++;
                                            }
                                        }
                                        else{
                                            echo "<p>Không có thông tin hiển thị</p>";
                                        }
                                    }else{
                                        echo "<p>Không có thông tin hiển thị</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
