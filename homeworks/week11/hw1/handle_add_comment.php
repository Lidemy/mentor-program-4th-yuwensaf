<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  // 如果欄位有缺
  if (empty($_POST['content'])) {
    header('Location: index.php?errCode=1');
    die();
  }

  // 如果欄位都有填寫，就把欄位的資料寫進資料庫

  // 自己實作 session 機制
  // 藉由 token 對應的 username 去拿到對應的 nickname
  // if ($_COOKIE['token']) {
  //   $token = $_COOKIE['token'];
  //   $user = getUserFromToken($token); // 可以拿到所有資料，包括 id, nickname, username, password, created_at
  //   $nickname = $user['nickname'];
  // }

  $username = $_SESSION['username']; // 用 PHP 內建 session 機制來撈出使用者的 username
  $user = getUserFromUsername($username);
  $content = $_POST['content'];

  // 如果身份是 banned，就不能新增留言
  if (!hasPermission($user, 'add', NULL)) {
    header('Location: index.php?errCode=4');
    die();
  }

  // 如果身份是 admin 或是 common 的話
  // 組 SQL query 的字串
  $sql = 'insert into saffran_comments (username, content) values(?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $username, $content);

  $result = $stmt->execute();
  // 如果 query 執行失敗
  if (!$result) {
    die($conn->error);
  }

  // 如果 query 執行成功，就導回 index.php
  header('Location: index.php');
?>