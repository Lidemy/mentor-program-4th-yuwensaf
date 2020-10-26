<?php
  require_once('conn.php');
  session_start();

  if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errCode=1');
    exit();
  }

  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = 'INSERT INTO saffran_admins (username, password) VALUES(?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $username, $password);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  $_SESSION['username'] = $username;
  header('Location: admin.php');
?>