<?php
  require_once('conn.php');
  session_start();

  if (empty($_GET['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
    exit();
  }

  $id = $_GET['id'];
  $username = $_SESSION['username'];
  $lastPage = $_POST['lastPage'];

  if (empty($_POST['title']) || empty($_POST['content'])) {
    header("Location: " . $lastPage);
    exit();
  }

  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = "UPDATE saffran_posts SET title=?, content=? WHERE id=? AND username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssis', $title, $content, $id, $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header("Location: " . $lastPage); // 這裡一定要用雙引號，不能用單引號

?>