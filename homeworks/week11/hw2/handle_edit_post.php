<?php
  require_once('conn.php');
  session_start();

  if (empty($_POST['title']) || empty($_POST['content'])) {
    header('Location: edit_post.php?errCode=1');
    exit();
  }

  $title = $_POST['title'];
  $content = $_POST['content'];
  $lastPage = $_POST['lastPage'];

  if (empty($_GET['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
    exit();
  }

  $id = $_GET['id'];
  $username = $_SESSION['username'];

  $sql = 'UPDATE saffran_posts SET title=?, content=? WHERE id=? AND username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssis', $title, $content, $id, $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: ' . $lastPage);

?>