<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  // 如果身份是 common 或是 banned，就不能變更使用者的身份
  if (!hasPermission($user, NULL, NULL)) {
    header('Location: index.php');
    die();
  }

  if (empty($_GET['id']) || empty($_GET['role'])) {
    header('Location: admin.php?errCode=1');
    exit();
  }

  $id = $_GET['id'];
  $role = $_GET['role'];

  $sql = 'UPDATE saffran_users SET role=? WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $role, $id);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  header('Location: admin.php');

?>