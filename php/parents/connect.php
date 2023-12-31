<?php
    $servername="localhost";
    $username= "root";
    $password= "";
    $db="truong_mam_non";
    $conn = new mysqli($servername,$username,$password,$db);
    if ($conn->connect_error){
        die("connection failded :" .$conn->connect_error);
    }
?>
