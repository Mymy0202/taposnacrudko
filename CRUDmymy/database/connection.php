<?php
//DATABASE CONNECTION STRING
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mymy_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error)
{
    die("Connection failed: ". $conn->connect_error);
}

?>