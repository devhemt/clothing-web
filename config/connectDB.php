<?php 
$serverName = 'localhost';
$userName = 'root';
$password = '';
$database = 'clothing_db';

$conn = mysqli_connect($serverName, $userName, $password, $database);

if(!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}else{
    mysqli_set_charset($conn, "utf8");
}
?>