<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();

  $username = NULL;
  $id = NULL;

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];
  }

  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
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
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="posts">
      <article class="post">
        <div class="post__header">
          <div><?php echo escape($row['title']) ?></div>
          <?php if ($username) { ?>
            <div class="post__actions">
              <a class="post__action" href="edit_post.php?id=<?php echo $row['id'] ?>">編輯</a>
            </div>
          <?php } ?>
        </div>
        <div class="post__info">
          <?php echo escape($row['created_at']) ?>
        </div>
        <div class="post__content"><?php echo escape($row['content']) ?></div>
      </article>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>