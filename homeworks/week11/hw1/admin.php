<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  // 如果身份是 common 或是 banned，就不能進入管理後台
  if (!hasPermission($user, NULL, NULL)) {
    header('Location: index.php?errCode=3');
    die();
  }

  // 如果身份是 admin
  $sql = 'SELECT * FROM saffran_users';
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板管理後台</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
  <div class="wrapper">
    <div class="warning">注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</div>
    <div class="users-block">
      <h1>管理後台</h1>
      <a class="go-back" href="index.php">回留言板</a>
      <h2>Hello, <?php echo $username ?></h2>
      
      <?php
        if (!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          if ($code === '1') {
            echo '<h2 class="errMsg>變更身份發生錯誤！</h2>';
          }
        }
      ?>
      <table>
        <tr class="users-block__item">
          <th class="id-column">user id</th>
          <th>nickname</th>
          <th>username</th>
          <th class="role-column">role</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['nickname'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td class="role-block">
              <?php if ($row['role'] == '2'){ ?>
                <a class="role-selected">管理員</a>
              <?php } else { ?>
                <a class="role" href="handle_update_role.php?id=<?php echo $row['id'] ?>&role=2">管理員</a>
              <?php } ?>

              <?php if ($row['role'] == '1'){ ?>
                <a class="role-selected">一般使用者</a>
              <?php } else { ?>
                <a class="role" href="handle_update_role.php?id=<?php echo $row['id'] ?>&role=1">一般使用者</a>
              <?php } ?>

              <?php if ($row['role'] == '3'){ ?>
                <a class="role-selected">遭停權使用者</a>
              <?php } else { ?>
                <a class="role" href="handle_update_role.php?id=<?php echo $row['id'] ?>&role=3">遭停權使用者</a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>



  <script src="all.js"></script>
</body>
</html>
