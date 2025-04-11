<?php
// Nếu muốn sử dụng các key trong $data, bạn có thể extract() chúng
$post     = $data['post'];
$comments = $data['comments'];
$post_id  = $data['post_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog Detail - <?= htmlspecialchars($post['title']); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../../public/css/blog-detail.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header>
    <div class="header-container">
      <div class="header-logo">
        <img src="../../public/images/LogoGearBK.webp" alt="GearBK Logo" />
        <span>GearBK</span>
      </div>
      <div class="header-menu">
        <ul>
          <li><a href="">HOME</a></li>
          <li><a href="">ABOUT</a></li>
          <li><a href="">SHOP</a></li>
          <li><a href="">CONTACT</a></li>
          <li><a href="">NEWS</a></li>
        </ul>
      </div>
      <div class="header-icons">
        <div class="header-shop">
          <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <div class="header-user">
          <i class="fa-solid fa-user"></i>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <article class="blog-detail">
      <div class="image-container">
        <!-- Cách hiển thị ảnh: thêm "../" trước đường dẫn (nếu CSDL lưu "public/uploads/xxx") -->
        <img class="blog-detail-image" src="<?= '../../' . htmlspecialchars($post['image']); ?>" alt="Blog Image" />
        <!-- Admin icons -->
        <div class="admin-icons">
          <a href="../edit/<?= $post['id']; ?>" title="Edit Post"><i class="bx bx-edit"></i></a>
          <a href=".//<?= $post['id']; ?>&action=delete" title="Delete Post" onclick="return confirm('Are you sure you want to delete this post?');"><i class="bx bx-trash"></i></a>
        </div>
      </div>
      <div class="blog-detail-content">
        <h1 class="blog-title"><?= htmlspecialchars($post['title']); ?></h1>
        <div class="blog-meta">
          <span class="blog-author">By <?= htmlspecialchars($post['author']); ?></span> | 
          <span class="blog-date"><?= date('F j, Y', strtotime($post['created_at'])); ?></span>
        </div>
        <div class="blog-text">
          <?= $post['content']; ?>
        </div>
      </div>
    </article>

    <!-- Nút BACK -->
    <div class="fixed-back-btn" id="back-btn">
      <a href="../list" class="btn btn-purple">Back</a>
    </div>

    <!-- Comments Section -->
    <section class="comments-section">
      <h2>Comments</h2>
      <div class="comments-list">
        <?php if ($comments->num_rows > 0): ?>
          <?php while ($comment = $comments->fetch_assoc()): ?>
            <div class="comment">
              <p class="comment-author"><?= htmlspecialchars($comment['name']); ?></p>
              <p class="comment-date"><?= date('F j, Y, H:i', strtotime($comment['created_at'])); ?></p>
              <p class="comment-text"><?= htmlspecialchars($comment['comment']); ?></p>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No comments yet.</p>
        <?php endif; ?>
      </div>

      <!-- Comment Form -->
      <div class="comment-form">
        <h3>Leave a Comment</h3>
        <!-- Lưu ý: action có thể thay đổi tùy vào routing của bạn -->
        <form action="detail?id=<?= $post_id; ?>" method="post">
          <input type="text" name="name" placeholder="Your Name" required />
          <input type="email" name="email" placeholder="Your Email" required />
          <textarea name="comment" placeholder="Your Comment" required></textarea>
          <button type="submit">Submit Comment</button>
        </form>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>© 2025 GearBK Blog. All rights reserved.</p>
  </footer>

  <style>
    .fixed-back-btn {
      position: fixed;
      top: 100px;
      right: 1150px;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .fixed-back-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .btn-purple {
      background-color: #4a0072;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
    }
    .btn-purple:hover {
      background-color: #6a1b9a;
      color: #fff;
    }
    .scroll-effect {
      transform: scale(1.05);
    }
  </style>
</body>
</html>
