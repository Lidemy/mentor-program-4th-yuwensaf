<?php
  require_once('conn.php');

  // 如果欄位有缺
  if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: login.php?errCode=1');
    die();
  }

  // 如果欄位都有填寫，就去資料庫找是否有這個使用者
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = sprintf(
    'select * from saffran_users where username="%s" and password="%s"',
    $username,
    $password
  );

  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }

  if ($result->num_rows >= 1) { // 如果有找到這個使用者
    // 自己實作 session 機制
    // 產生 token
    // $token = '';
    // for($i=1; $i<=16; $i++){
    //   $token .= chr(rand(65, 90));
    // };
    // $expire = 3600 * 24 * 30; // 30 days
    // setcookie('token', $token, time() + $expire);

    // 把 username 和 token 寫進資料庫 tokens
    // $sql = sprintf(
    //   'insert into tokens (username, token) value("%s", "%s")',
    //   $username,
    //   $token
    // );
    // $conn->query($sql);

    // PHP 內建 session 機制
    session_start();
    $_SESSION['username'] = $username;
    echo $_SESSION['username'];
    header('Location: index.php');
  } else {
    header('Location: login.php?errCode=2');
    die();
  }

?>