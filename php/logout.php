<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">

    <title>Đăng xuất</title>
</head>

<body>


    <?php
    session_start();
    if (isset($_SESSION['user_name'])) {
        unset($_SESSION['user_name']);
        header("Location: /PHP/BTL/index.php");
    }

    ?>
</body>

</html>