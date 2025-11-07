<?php
include('config.php');
if (!isset($_POST['username']) || !isset($_POST['message'])) {
  http_response_code(400);
  echo 'bad';
  exit;
}
$username = $_POST['username'];
$message = $_POST['message'];

$stmt = $conn->prepare('INSERT INTO messages (username, message) VALUES (?, ?)');
$stmt->bind_param('ss', $username, $message);
if ($stmt->execute()) {
  echo 'ok';
} else {
  http_response_code(500);
  echo 'error';
}
?>