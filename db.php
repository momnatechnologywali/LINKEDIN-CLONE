<?php
$servername = "localhost"; // Assuming localhost; change if needed
$username = "um4u5gpwc3dwc";
$password = "neqhgxo10ioe";
$dbname = "dbanwhx4o4with";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Set charset to UTF-8 for proper encoding
$conn->set_charset("utf8mb4");
?>
