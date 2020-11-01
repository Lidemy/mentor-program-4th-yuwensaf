<?php
  require_once('conn.php');
  session_start();

  if (empty($_POST['new-nickname'])) {
    header('Location: index.php?errCode=2');
    die();
  }

  $nickname = $_POST['new-nickname'];
  $username = $_SESSION['username'];

  // 把新的 nickname 寫進資料庫裡面
  $sql = 'UPDATE saffran_users SET nickname=? WHERE username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>