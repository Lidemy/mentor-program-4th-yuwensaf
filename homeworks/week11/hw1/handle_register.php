<?php
  require_once('conn.php');
  session_start();

  // 如果欄位有缺
  if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errCode=1');
    die();
  }

  // 如果欄位都有填寫，就把欄位的資料寫進 users 資料庫
  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 把密碼經過 hash（PHP 內建的 hash 機制）

  // 組 SQL query 的字串，把註冊資料寫進 users 資料庫
  $sql = 'insert into saffran_users (nickname, username, password) values(?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $nickname, $username, $password);
  $result = $stmt->execute();

  if (!$result) { // 如果註冊失敗
    if ($conn->errno === 1062) { // 如果 username 重複了（不能有重複的 username）
      header('Location: register.php?errCode=2');
      die();
    }
    die($conn->error);
  }

  // 如果註冊成功，就直接變成登入狀態（啟用 session 機制）
  $_SESSION['username'] = $username;
  header('Location: index.php');
?>