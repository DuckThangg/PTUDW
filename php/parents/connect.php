<?php
    $servername="localhost";
    $username= "root";
    $password= "";
    $db="truong_mam_non_1";
    $conn = new mysqli($servername,$username,$password,$db);
    if ($conn->connect_error){
        die("connection failded :" .$conn->connect_error);
    }
?>