<?php  
  $username = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  $uri = $_SERVER['REQUEST_URI']; // 取得目前頁面的網址
  $isAdminPage = (strpos($uri, 'admin.php') !== false);
?>
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
          <?php if ($isAdminPage) { ?> <!-- 如果現在是位於 admin.php -->
            <li><a href="add_post.php">新增文章</a></li>
            <li><a href="handle_logout.php">登出</a></li>
          <?php } else { ?>
            <li><a href="admin.php">管理後台</a></li>
          <?php } ?>
        <?php } else { ?> <!-- 如果沒有登入的話 -->
        <li><a href="login.php">登入</a></li>
        <?php } ?>
      </div>
    </ul>
  </div>
</nav>