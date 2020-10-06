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
            <h1>Login</h1>
            <?php
              if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                if ($code === '1') {
                  echo '<h2 class="errMsg">請輸入帳號與密碼！</h2>';
                } else if ($code === '2') {
                  echo '<h2 class="errMsg">帳號或密碼輸入錯誤！</h2>';
                }
              }
            
            ?>
            <div class="buttons">
              <a href="index.php" class="comment-block__btn">回留言板</a>
              <a href="register.php" class="comment-block__btn">註冊</a>
            </div>            
            <form method="POST" action="handle_login.php">
              username: <input type="text" name="username" class="register-input">
              <br>
              password: <input type="password" name="password" class="register-input">
              <br>

              <input type="submit" class="submit-btn">
            </form>

          </div>

      </div>
    </div>

</body>
</html>