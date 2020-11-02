<?php
  require_once('conn.php');
  require('utils.php');
  session_start();

  // 去 tokens 資料庫查詢 cookie 對應的 username
  $user = NULL;
  $username = '';
  // 自己實作 session 機制
  // if (!empty($_COOKIE['token'])) {
  //   $token = $_COOKIE['token'];
  //   $sql = sprintf(
  //     'select username from tokens where token="%s"',
  //     $token
  //   );
  //   $result = $conn->query($sql);
  //   if ($result->num_rows >= 1) {
  //     $row = $result->fetch_assoc();
  //     $username = $row['username'];
  //   }
  // }

  // PHP 內建 session 機制
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $nickname = $user['nickname'];
  }

  // 分頁功能
  $items_per_page = 5; // 每頁有五筆留言
  $page = 1; // 目前在第幾頁
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $offset = ($page - 1) * $items_per_page;

  // 去資料庫抓取所有留言並顯示在畫面上
  $sql = 'SELECT '.
  'C.id as id, '.
  'U.nickname as nickname, '.
  'U.username AS username, '.
  'C.created_at AS created_at, '.
  'C.content AS content '.
  'FROM saffran_comments AS C '.
  'LEFT JOIN saffran_users AS U ON C.username = U.username '.
  'WHERE C.is_deleted IS NULL '. // 只顯示「沒有被刪除」的留言
  'ORDER BY C.id DESC '.
  'LIMIT ? OFFSET ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>My Discussion Board</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="wrapper">
      <div class="warning">注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</div>
      <div class="admin-block">
        <!-- 必須要是 admin 才能看到管理後台的入口 -->
        <?php if (hasPermission($user, NULL, NULL)) { ?>
          <a href="admin.php">進入管理後台</a>
        <?php } ?>
      </div>
      
      <main class="comment-block">
        <!-- 輸入留言的區塊 -->
        <div class="comment-block__input">
          <h1>Comments</h1>
          <?php
            if (!empty($_GET['errCode'])) {
              $code = $_GET['errCode'];

              switch($code) {
                case '1':
                  echo '<h2 class="errMsg">請輸入留言！</h2>';
                  break;
                case '2':
                  echo '<h2 class="errMsg">請輸入新的暱稱！</h2>';
                  break;
                case '3':
                  echo '<h2 class="errMsg">非管理員不可進入後台！</h2>';
                  break;
                case '4':
                  echo '<h2 class="errMsg">遭停權使用者不可留言！</h2>';
                  break;
              }
            }
          ?>
          
          <?php if (!$username) { ?>
            <div class="buttons">
              <a href="register.php" class="comment-block__btn">註冊</a>
              <a href="login.php" class="comment-block__btn">登入</a>
            </div>
          <?php } else { ?>
            <div class="login-block">
              <h3>Hello, <?php echo $nickname ?></h3>
              <a href="logout.php" class="comment-block__btn">登出</a>
              <a class="update-nickname-btn comment-block__btn">編輯暱稱</a>
            </div>
            <form method="POST" action="update_user.php" class="hide comment-block__form update-nickname">
              新的暱稱：<input type="text" name="new-nickname" class="update-nickname__input">
              <input type="submit" class="submit-btn">
            </form>
          <?php } ?>

          <form method="POST" action="handle_add_comment.php" class="comment-block__form">
            <textarea name="content"></textarea>
            
            <?php if (!$username) { ?> <!-- 如果沒有登入 -->
              <h3 class="reminder">請先登入才能發布留言喔！</h3>
            <?php } else if ($username && hasPermission($user, 'add', NULL)) { ?> <!-- 如果有登入，且身份是 admin 或是 common -->
              <input type="submit" class="submit-btn">
            <?php } else if ($username && !hasPermission($user, 'add', NULL)) { ?> <!-- 如果有登入，但身份是 banned -->
              <h3 class="reminder">你已被停權</h3>              
            <?php } ?>
    
          </form>

        </div>
        <div class="hr"></div>
        <!-- 顯示留言的區塊 -->
        <section class="comment-block__post">
          <!-- 從 comments 資料庫裡面抓取 username, content 和留言時間 -->
            <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="card">
              <div class="card__img"></div>
              <div class="card__content">
                <div class="card__info"><?php echo escape($row['nickname']) ?>(@<?php echo escape($row['username']) ?>)
                <span class="time"><?php echo escape($row['created_at']) ?></span>

                <?php if ($row['username'] === $username || hasPermission($user, 'update', $row)) { ?>
                  <a href="update_comment.php?id=<?php echo escape($row['id']) ?>&page=<?php echo $page ?>">編輯</a> <!-- 用 GET 帶 id 和頁數到 update_comment.php -->
                  <a href="handle_delete_comment.php?id=<?php echo escape($row['id']) ?>">刪除</a>
                <?php } ?>
                

              </div>
                <p class="card__text"><?php echo escape($row['content']) ?></p>
              </div>
            </div>

            <?php } ?>
          </section>
          <div class="hr"></div>
          <!-- 分頁功能的區塊 -->
          <?php
            $sql = 'SELECT COUNT(id) AS id FROM saffran_comments WHERE is_deleted IS NULL';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc(); // $row['id'] 就是「總共有幾筆資料」
            $total_page = ceil($row['id'] / $items_per_page); // 總共有幾頁
          
          ?>
          <div class="page-info">
            總共有 <?php echo $row['id'] ?> 筆資料，頁數：<?php echo $page ?> / <?php echo $total_page ?>
          </div>
          <div class="paginator">
            <?php if ($page != 1) { ?>
              <a href="index.php?page=1">首頁</a>
              <a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a>
            <?php } ?>

            <?php if ($page != $total_page) { ?>
              <a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a> 
              <a href="index.php?page=<?php echo $total_page ?>">最後一頁</a>
            <?php } ?>                        
          </div>

      </main>
    </div>

    <script src="all.js"></script>

</body>
</html>