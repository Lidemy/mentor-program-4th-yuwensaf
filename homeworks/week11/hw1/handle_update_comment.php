<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  
  $id = $_GET['id'];
  $page = $_GET['page'];

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);

  if (empty($_POST['content'])) {
    header('Location: update_comment.php?id=' . $id);
    exit();
  }

  $content = $_POST['content'];

  if (hasPermission($user, 'update', NULL)) {
    $sql = 'UPDATE saffran_comments SET content=? WHERE id=?'; // admin 可以編輯任意留言
  } else {
    // 如果身份是 common 或是 banned，就只能編輯自己的留言
    $sql = 'UPDATE saffran_comments SET content=? WHERE id=? AND username=?'; // 加上 username 的條件（權限問題）
  }

  $stmt = $conn->prepare($sql);

  if (hasPermission($user, 'update', NULL)) {
    $stmt->bind_param('si', $content, $id);
  } else {
    $stmt->bind_param('sis', $content, $id, $username);
  }

  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php?page=' . $page); // 回到原本留言所在的那一頁
?>