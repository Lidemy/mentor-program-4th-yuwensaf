<?php
  require_once('conn.php');

  function getUserFromUsername($username) {
    $sql = 'SELECT * FROM saffran_admins WHERE username=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();

    if (!$result) {
      die($conn->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row; // 可以拿到 id, username, password
  }

  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }

?>


