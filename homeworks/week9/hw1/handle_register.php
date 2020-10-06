<?php
  require_once('conn.php');

  // 如果欄位有缺
  if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errCode=1');
    die();
  }

  // 如果欄位都有填寫，就把欄位的資料寫進 users 資料庫
  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 組 SQL query 的字串
  $sql = sprintf(
    'insert into saffran_users (nickname, username, password) value("%s", "%s", "%s")',
    $nickname,
    $username,
    $password
  );

  // 把註冊資料寫進 users 資料庫
  $result = $conn->query($sql);
  if (!$result) {
    if ($conn->errno === 1062) { // 如果 username 重複了（不能有重複的 username）
      header('Location: register.php?errCode=2');
      die();
    }
    die($conn->error);
  }

  header('Location: index.php');
?>