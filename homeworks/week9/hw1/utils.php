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

?>