<?php

$dbcon = mysqli_connect('localhost', 'root', 'Honeykanna2024@', 'courierdb');

if (!$dbcon) {
   
    die("Database connection failed: " . mysqli_connect_error());
} 

?>
