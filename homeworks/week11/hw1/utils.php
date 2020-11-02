<?php
  require_once('conn.php');

  // 自己實作 session 機制
  // function getUserFromToken($token) {
  //   global $conn;
  //   $sql = sprintf(
  //     'select username from tokens where token="%s"',
  //     $token
  //   );
  //   $result = $conn->query($sql);
  //   $row = $result->fetch_assoc();
  //   $username = $row['username'];

  //   $sql = sprintf(
  //     'select * from users where username="%s"',
  //     $username
  //   );
  //   $result = $conn->query($sql);
  //   $row = $result->fetch_assoc();
  //   return $row;
  // }

  // PHP 內建 session 機制
  function getUserFromUsername($username) {
    global $conn;
    $sql = sprintf(
      'select * from saffran_users where username="%s"',
      $username
    );

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  // 修正 XSS 的資安問題
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }

  // 檢查權限
  // role: 1 代表「一般使用者 common」，2 代表「管理員 admin」，3 代表「遭停權使用者 banned」
  // $action 的值會有 update（編輯、刪除） 或是 add（新增留言）
  function hasPermission($user, $action, $comment) {
    if ($user && $user['role'] === '2') { // 如果身份是 admin
      return true; // 管理員可以做任何事情
    }

    if ($user && $user['role'] === '1') { // 如果身份是 common
      if ($action === 'add') return true; // 可以新增留言
      return ($comment && $user['username'] === $comment['username']); // 可以編輯與刪除自己的留言
    }

    if ($user && $user['role'] === '3') { // 如果身份是 banned
      return ($action === 'update' && $comment && $user['username'] === $comment['username']); // 不能新增留言，但是可以編輯與刪除自己的留言
    }
  }

?>