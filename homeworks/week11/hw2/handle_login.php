<?php
  require_once('conn.php');
  session_start();

  if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: login.php?errCode=1');
    exit();
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = 'SELECT * FROM saffran_admins WHERE username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute(); // 執行 query

  if (!$result) { // 先判斷 query 是否有執行成功
    die($conn->error);
  }
  
  $result = $stmt->get_result(); // 有執行成功，就去拿結果回來

  // 如果沒有找到此人
  if ($result->num_rows === 0) {
    header('Location: login.php?errCode=2');
    exit();
  }

  // 如果有找到此人
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) { // 如果密碼有相符
    $_SESSION['username'] = $username;
    header('Location: admin.php');
  } else { // 如果密碼沒有相符
    header('Location: login.php?errCode=3');
  }
?>