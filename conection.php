<?php

    $mysqli = new mysqli("localhost", "root", "", "sistemaibot");


    if(mysqli_connect_errno()){
        echo 'Failed to connect: ', mysqli_connect_errno();
        exit();
    }

?>