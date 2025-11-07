<?php
include('config.php');
$res = $conn->query('SELECT username, message, created_at FROM messages ORDER BY id ASC');
$messages = [];
while ($row = $res->fetch_assoc()) {
  $messages[] = $row;
}
header('Content-Type: application/json');
echo json_encode($messages);
?>