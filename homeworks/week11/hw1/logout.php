<?php
  require_once('conn.php');

  // 自己實作 session 機制
  // $token = $_COOKIE['token'];
  // $sql = sprintf(
  //   'delete from tokens where token="%s"',
  //   $token
  // );
  // $conn->query($sql);

  // setCookie('token', '', time() - 3600);

  // PHP 內建 session 機制
  session_start();
  session_destroy();

  // 導回 index.php
  header('Location: index.php');

?>