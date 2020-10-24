<?php
  require_once('conn.php');
  require('utils.php');
  session_start();

  $id = '';
  $page = '';
  if (!empty($_GET['id']) && !empty($_GET['page'])) {
    $id = $_GET['id'];
    $page = $_GET['page'];
  }

  // 去資料庫抓取該 id 的留言內容，並顯示在畫面上
  $sql = 'SELECT content FROM saffran_comments WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
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
            <h1>編輯留言</h1>
            <?php
              if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                if ($code === '1') {
                  echo '<h2 class="errMsg">請輸入留言！</h2>';
                }
              }
            
            ?>

            <form method="POST" action="handle_update_comment.php?id=<?php echo $id ?>&page=<?php echo $page ?>" class="comment-block__form">
              <textarea name="content"><?php echo escape($row['content'])?></textarea>
              <input type="submit" class="submit-btn">
            </form>

          </div>
      </div>
    </div>

    <script src="all.js"></script>

</body>
</html>