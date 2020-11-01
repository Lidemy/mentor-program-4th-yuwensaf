<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  $sql = 'SELECT * FROM saffran_posts WHERE is_deleted=0 ORDER BY id DESC';
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();

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
  <nav class="navbar">
    <div class="wrapper navbar__wrapper">
      <div class="navbar__site-name">
        <a href='index.php'>Who's Blog</a>
      </div>
      <ul class="navbar__list">
        <div>
          <li><a href="all_posts.php">文章列表</a></li>
          <li><a href="#">分類專區</a></li>
          <li><a href="#">關於我</a></li>
        </div>
        <div>
          
          <?php if ($username) { ?> <!-- 如果有登入的話 -->
            <li><a href="admin.php">管理後台</a></li>
            <li><a href="handle_logout.php">登出</a></li>
          <?php } else { ?> <!-- 如果沒有登入的話 -->
          <li><a href="login.php">登入</a></li>
          <?php } ?>
        </div>
      </ul>
    </div>
  </nav>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>文章列表</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="posts">

      <?php while($row = $result->fetch_assoc()) { ?>
        <article class="post">
          <div class="post__header">
            <div><?php echo escape($row['title']) ?></div>
            <?php if($username) { ?>
              <div class="post__actions">
                <a class="post__action" href="edit_post.php?id=<?php echo escape($row['id']) ?>">編輯</a>
              </div>
            <?php } ?>
          </div>
          <div class="post__info"><?php echo escape($row['created_at']) ?></div>
          <div class="post__content"><?php echo substr(escape($row['content']), 0, 200) ?></div>
          <a class="btn-read-more" href="post.php?id=<?php echo $row['id'] ?>">READ MORE</a>
        </article>
      <?php } ?>

    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>