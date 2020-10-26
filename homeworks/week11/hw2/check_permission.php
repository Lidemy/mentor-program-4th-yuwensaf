<?php
  // 如果沒有登入
  if (empty($_SESSION['username'])) {
    header('Location: index.php');
    exit();
  }
?>