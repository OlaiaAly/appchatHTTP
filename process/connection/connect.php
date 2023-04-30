<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quicktalk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(header("HTTP/1.0 401 Connection failed: " . $conn->connect_error));
}

?>