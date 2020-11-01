<?php
  require_once('conn.php');
  require_once('utils.php');

  // 如果欄位有缺
  if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: login.php?errCode=1');
    die();
  }

  // 如果欄位都有填寫，就去資料庫找是否有這個使用者
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = 'select * from saffran_users where username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  $result = $stmt->get_result();

  // 如果在資料庫裡面沒有找到這個 username
  if ($result->num_rows === 0) {
    header('login.php?errCode=2');
    exit(); // 不再繼續執行下面的程式碼
  }

  // 如果在資料庫裡面有找到這個 username
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) { // 檢查「使用者輸入的密碼」是否跟「資料庫裡面，經過 hash 的密碼」相等

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
    header('Location: index.php');
  } else {
    header('Location: login.php?errCode=2');
    die();
  }

?>