<?php
  require_once('conn.php');
  session_start();

  if (empty($_POST['title']) || empty($_POST['content'])) {
    header('Location: add_post.php?errCode=1');
    exit();
  }

  $title = $_POST['title'];
  $content = $_POST['content'];
  $username = $_SESSION['username'];

  $sql = 'INSERT INTO saffran_posts (username, title, content) VALUES(?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $username, $title, $content);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: admin.php');
?>