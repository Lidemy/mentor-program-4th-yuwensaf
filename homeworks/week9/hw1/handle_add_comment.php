<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  // 如果欄位有缺
  if (empty($_POST['comment'])) {
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

  // PHP 內建 session 機制
  // 藉由 username 去拿到對應的 nickname
  if ($_SESSION['username']) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username); // 可以拿到所有資料，包括 id, nickname, username, password, created_at
    $nickname = $user['nickname'];
  }

  $comment = $_POST['comment'];
  // 組 SQL query 的字串
  $sql = sprintf(
    'insert into saffran_comments (nickname, content) value("%s", "%s")',
    $nickname,
    $comment
  );

  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }

  // 導回 index.php
  header('Location: index.php');

?>