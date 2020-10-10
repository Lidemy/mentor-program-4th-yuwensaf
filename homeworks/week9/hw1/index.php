<?php
  require_once('conn.php');
  session_start();

  // 去 tokens 資料庫查詢 cookie 對應的 username
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
  }

  // 去資料庫抓取所有留言並顯示在畫面上
  $sql = sprintf(
    'select * from saffran_comments order by id desc'
  );

  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }
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
        <div class="comment-block">
          <div class="comment-block__input">
            <h1>Comments</h1>
            <?php
              if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                if ($code === '1') {
                  echo '<h2 class="errMsg">請輸入留言！</h2>';
                }
              }
            
            ?>

            <form method="POST" action="handle_add_comment.php" class="comment-block__form">
              <?php if (!$username) { ?>
                <div class="buttons">
                  <a href="register.php" class="comment-block__btn">註冊</a>
                  <a href="login.php" class="comment-block__btn">登入</a>
                </div>
              <?php } else { ?>
                <div class="login-block">
                  <h3>Hello, <?php echo $username ?></h3>
                  <a href="logout.php" class="comment-block__btn">登出</a>
                </div>
              <?php } ?>
              <textarea name="comment"></textarea>
              <?php if (!$username) { ?>
                <h3 class="reminder">請先登入才能發布留言喔！</h3>
              <?php } else { ?>
                <input type="submit" class="submit-btn">
              <?php } ?>
              
            </form>

          </div>
          <div class="hr"></div>
          <div class="comment-block__post">

          <!-- 從 comments 資料庫裡面抓取 nickname, content 和留言時間 -->
            <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="card">
              <div class="card__img"></div>
              <div class="card__content">
                <div class="card__info"><?php echo $row['nickname'] ?><span class="time"><?php echo $row['created_at'] ?></span></div>
                <p class="card__text"><?php echo $row['content'] ?></p>
              </div>
            </div>

            <?php } ?>
          </div>
      </div>
    </div>

</body>
</html>