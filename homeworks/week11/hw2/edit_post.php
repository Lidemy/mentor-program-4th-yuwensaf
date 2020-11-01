<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  include_once('check_permission.php');

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];
  }

  $sql = 'SELECT * FROM saffran_posts WHERE id=?';
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

<html>
<head>
  <meta charset="utf-8">

  <title>部落格</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="normalize.css" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <?php include_once('navbar.php') ?>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>編輯文章</h1>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="container">
      <div class="edit-post">
        <form action="handle_edit_post.php?id=<?php echo $id ?>" method="POST">
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            if ($code === '1') {
              echo '<h3 class="errMsg">請輸入文章標題和內容！</h3>';
            }
          }
        ?>
          <div class="edit-post__title">
            編輯文章：
          </div>
          <div class="edit-post__input-wrapper">
            <input class="edit-post__input" placeholder="請輸入文章標題" name="title" value="<?php echo escape($row['title']) ?>" />
          </div>

          <div class="edit-post__input-wrapper">
            <textarea rows="20" class="edit-post__content" name="content"><?php echo escape($row['content']) ?></textarea>
          </div>

          <!-- 用 $_SERVER['HTTP_REFERER'] 取得「上一頁的網址」 -->
          <input type="hidden" name="lastPage" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
          <div class="edit-post__btn-wrapper">
            <input type="submit" class="edit-post__btn">
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>