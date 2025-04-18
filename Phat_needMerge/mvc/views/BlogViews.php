<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/blog2.css">
    <link rel="stylesheet" href="../public/css/blog.css">
    <style>
        .fixed-add-posts-btn {
            position: fixed;
            top: 200px;
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .fixed-add-posts-btn:hover {
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
</head>
<body>
    <!-- Header của trang -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-inner-content">
                        <div class="header-logo">
                            <img src="../public/images/LogoGearBK.webp" alt="">
                            <span>GearBK</span>
                        </div>
                        <div class="header-menu">
                            <ul>
                                <li><a href="">HOME</a></li>
                                <li><a href="">ABOUT</a></li>
                                <li><a href="">SHOP</a></li>
                                <li><a href="">CONTACT</a></li>
                                <li><a href="">NEWS</a></li>
                                <li><a href="../AuthController/logout">ĐĂNG XUẤT</a></li>
                                
                            </ul>
                        </div>
                        <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="header-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Nút Add Posts cố định -->
    <?php if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] === 'admin'): ?>
        <div class="fixed-add-posts-btn" id="add-posts-btn">
            <a href="../index.php?url=BlogController/create" class="btn btn-purple">Add Posts</a>
        </div>
    <?php endif; ?>

    <!-- Danh sách bài viết -->
    <section class="blog-posts">
        <?php if ($data["posts"] && mysqli_num_rows($data["posts"]) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($data["posts"])): ?>
                <a href="detail/<?= $row['id']; ?>" class="blog-post">
                    <div class="blog-post">
                    <img src="<?= $row['image'] ? '../' . $row['image'] : 'https://via.placeholder.com/300x200'; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                        <div class="post-info">
                            <span class="category"><?= htmlspecialchars($row['category']); ?></span>
                            <h2 class="post-title"><?= htmlspecialchars($row['title']); ?></h2>
                            <p class="post-date"><?= date('F j, Y', strtotime($row['created_at'])); ?></p>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </section>

    <!-- Phân trang -->
    <div class="container my-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Nút Previous -->
                <li class="page-item <?= $data["page"] <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= $data["page"] - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>

                <!-- Các số trang -->
                <?php for ($i = 1; $i <= $data["total_pages"]; $i++): ?>
                    <li class="page-item <?= $i == $data["page"] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Nút Next -->
                <li class="page-item <?= $data["page"] >= $data["total_pages"] ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= $data["page"] + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
        <p class="text-center text-white">Copyright © 2025</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('add-posts-btn');
            if (window.scrollY > 50) {
                btn.classList.add('scroll-effect');
            } else {
                btn.classList.remove('scroll-effect');
            }
        });
    </script>
</body>
</html>
