<?php
// Tạo search path đúng định dạng routing
$searchPath = isset($data['search']) && $data['search'] !== ''
    ? "BlogController/search/" . urlencode(str_replace(' ', '-', $data['search']))
    : "BlogController/list";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="/Gear/public/css/blog2.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <link rel="stylesheet" href="/Gear/public/css/header.css">
    
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
        .search-bar-container {
            margin-top: 80px;
            margin-bottom: 20px;
            text-align: center;
        }
        .search-bar-container form {
            display: inline-flex;
            align-items: center;
            margin-top: 150px;
        }
        .search-input {
            width: 400px;
            height: 40px;
            font-size: 14px;
            border-radius: 6px;
            padding: 0 15px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                <div class="header-inner-content">
                    <div class="header-logo">
                    <img src="/Gear/public/images/LogoGearBK.webp" alt="Logo">
                    <span>GearBK</span>
                    </div>
                    <div class="header-menu">
                    <ul>
                        <li><a href="/Gear">HOME</a></li>
                        <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                        <li><a href="/Gear/ProductController/list">SHOP</a></li>
                        <li><a href="/Gear/contact">CONTACT</a></li>
                        <li><a href="/Gear/BlogController/list">BLOG</a></li>
                        <li><a href="/Gear/QAController/list">Q&A</a></li>
                    </ul>
                    </div>
                    <div class="d-flex">
                    <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                    <?php if(isset($_COOKIE['access_token'])): ?>
                    <div class="header-user">
                        <a href="/Gear/AuthController/profile" title="Thông tin cá nhân" style="color: white; text-decoration: none;">
                        <i class="fa-solid fa-user"></i>
                        </a>
                    </div>
                    <div class="header-logout ml-3">
                        <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: white; text-decoration: none;">
                        <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="header-user">
                        <a href="/Gear/AuthController/login" title="Đăng nhập" style="color: white; text-decoration: none;">
                        <i class="fa-solid fa-user"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Add Post (admin only) -->
    <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
        <div class="fixed-add-posts-btn" id="add-posts-btn">
            <a href="/Gear/BlogController/create" class="btn btn-purple">Add Posts</a>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="search-bar-container">
        <form class="form-inline justify-content-center" onsubmit="return handleSearch(event)">
            <input type="text" id="search-input" class="form-control search-input" placeholder="Tìm kiếm bài viết..." value="<?= isset($data['search']) ? htmlspecialchars($data['search']) : '' ?>">
            <button type="submit" class="btn btn-purple ml-2">Tìm kiếm</button>
        </form>
    </div>

    <!-- Danh sách bài viết -->
    <section class="blog-posts">
        <?php if ($data["posts"] && mysqli_num_rows($data["posts"]) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($data["posts"])): ?>
                <a href="/Gear/BlogController/detail/<?= $row['id']; ?>" class="blog-post">
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

    <!-- PHÂN TRANG -->
    <div class="container my-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Previous -->
                <li class="page-item <?= $data["page"] <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="../<?= $searchPath ?>&page=<?= $data["page"] - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>

                <!-- Số trang -->
                <?php for ($i = 1; $i <= $data["total_pages"]; $i++): ?>
                    <li class="page-item <?= $i == $data["page"] ? 'active' : ''; ?>">
                        <a class="page-link" href="../<?= $searchPath ?>&page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= $data["page"] >= $data["total_pages"] ? 'disabled' : ''; ?>">
                    <a class="page-link" href="../<?= $searchPath ?>&page=<?= $data["page"] + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
        <p class="text-center text-white">Copyright © 2025</p>
    </div>

    <script>
        function handleSearch(event) {
            event.preventDefault();
            const keyword = document.getElementById('search-input').value.trim().replace(/\s+/g, '-');
            if (keyword) {
                window.location.href = "/Gear/BlogController/search/" + keyword;
            } else {
                window.location.href = "/Gear/BlogController/list";
            }
        }

        window.addEventListener('scroll', function () {
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
