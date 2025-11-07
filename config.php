<?php
// Update the password in this file after upload:
$host = "sql7.freesqldatabase.com";
$user = "sql7806479";
$pass = "@Gallant666"; // <-- replace with @Gallant666 in your IDE
$dbname = "sql7806479";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
?>
