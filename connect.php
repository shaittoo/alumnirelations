<?php
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "backinup";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->select_db($dbname);
?>



