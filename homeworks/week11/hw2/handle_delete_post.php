<?php
  require_once('conn.php');
  session_start();

  if (empty($_GET['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
    exit();
  }

  $id = $_GET['id'];
  $username = $_SESSION['username'];

  $sql = 'UPDATE saffran_posts SET is_deleted=1 WHERE id=? AND username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('is', $id, $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: admin.php');
?>