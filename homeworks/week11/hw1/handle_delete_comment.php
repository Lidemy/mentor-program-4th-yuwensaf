<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  if ($_GET['id']) {
    $id = $_GET['id'];
  }

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);

  if (hasPermission($user, 'update', NULL)) { // 如果身份是 admin 的話，可以刪除任意留言
    $sql = 'UPDATE saffran_comments SET is_deleted=1 WHERE id=?';
  } else {
    $sql = 'UPDATE saffran_comments SET is_deleted=1 WHERE id=? AND username=?'; // 加上 username 的條件（權限問題）
  }

  $stmt = $conn->prepare($sql);

  if (hasPermission($user, 'update', NULL)) {
    $stmt->bind_param('i', $id);
  } else {
    $stmt->bind_param('is', $id, $username);
  }
  
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>