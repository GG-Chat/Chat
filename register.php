<?php
// This file serves two purposes:
// 1. If only 'username' is POSTed it replies with 'in use' or 'ok-check-only' (used for availability check).
// 2. If 'username' and 'password' are POSTed it attempts to create the user and replies with 'success' or 'in use'.
include('config.php');

if (!isset($_POST['username'])) {
  echo 'error';
  exit;
}

$username = trim($_POST['username']);

// basic validation
if (strlen($username) < 4) {
  echo 'error';
  exit;
}

// check existing
$check = $conn->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
$check->bind_param('s', $username);
$check->execute();
$res = $check->get_result();

if ($res && $res->num_rows > 0) {
  echo 'in use';
  exit;
}

// if password not provided, this was just a check
if (!isset($_POST['password'])) {
  echo 'ok-check-only';
  exit;
}

$password = $_POST['password'];
if (strlen($password) < 5) {
  echo 'error';
  exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
$insert->bind_param('ss', $username, $hashed);
if ($insert->execute()) {
  echo 'success';
} else {
  echo 'error';
}
?>