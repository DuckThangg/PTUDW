<?php

require 'connect.php';

if (isset($_GET['id_hoc_sinh'])) {
    $id_hoc_sinh = $_GET['id_hoc_sinh'];
    $sql = "UPDATE hoc_sinh SET id_lop = NULL WHERE id_hoc_sinh = '$id_hoc_sinh'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa học sinh thành công!";
    } else {
        echo "Có lỗi khi xóa: " . $conn->error;
    }
    header("Location: /PHP/BTL/php/teacher/student.php");
    exit();
} else {
    echo "Không tồn tại yêu cầu !";
}
?>
