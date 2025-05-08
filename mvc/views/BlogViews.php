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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <link rel="stylesheet" href="/Gear/public/css/blog2.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <link rel="stylesheet" href="/Gear/public/css/header.css">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        
        .fixed-add-posts-btn {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .fixed-add-posts-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-purple {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-purple:hover {
            background-color: #c82333;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .scroll-effect {
            transform: scale(1.05);
        }
        .search-bar-container {
            margin-top: 110px;
            margin-bottom: 40px;
            text-align: center;
            padding: 0 15px;
        }
        .search-bar-container form {
            display: inline-flex;
            align-items: center;
            margin-top: 0;
            background-color: white;
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .search-input {
            width: 400px;
            height: 45px;
            font-size: 16px;
            border-radius: 25px;
            padding: 0 20px;
            border: 1px solid #eee;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        .search-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        /* Cải thiện danh sách bài viết */
        .blog-posts-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .blog-posts {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin: 0 auto;
            padding: 0;
            max-width: 1200px;
        }
        
        .blog-post {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-decoration: none !important;
            display: block;
            height: 100%;
        }
        
        .blog-post:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .blog-post img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .blog-post:hover img {
            transform: scale(1.05);
        }
        
        .post-info {
            padding: 20px;
        }
        
        .category {
            display: inline-block;
            background-color: #f8d7da;
            color: #dc3545;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .post-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }
        
        .blog-post:hover .post-title {
            color: #dc3545;
        }
        
        .post-date {
            display: flex;
            align-items: center;
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .post-date i {
            margin-right: 5px;
            color: #dc3545;
        }
        
        /* Pagination cải tiến */
        .pagination {
            margin-top: 50px;
        }
        
        .page-link {
            border-radius: 50%;
            margin: 0 5px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dc3545;
            border: 1px solid #dc3545;
            font-weight: 600;
        }
        
        .page-link:hover {
            background-color: #f8d7da;
            color: #dc3545;
        }
        
        .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .footer {
            margin-top: 50px;
            padding: 20px 0;
            text-align: center;
            color: #333;
            font-weight: 500;
        }
        
        /* Thống nhất kiểu header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.7);
        }
        
        .header-inner-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
        }
        
        .header-logo img {
            height: 40px;
            margin-right: 10px;
        }
        
        .header-logo span {
            color: white;
            font-weight: 600;
            font-size: 20px;
        }
        
        .header-menu ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .header-menu ul li {
            margin-left: 30px;
        }
        
        .header-menu ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .header-menu ul li a:hover {
            color: #dc3545;
        }
        
        .header-shop, .header-user, .header-logout {
            color: white;
            font-size: 18px;
            cursor: pointer;
            margin-left: 20px;
            display: flex;
            align-items: center;
        }
        
        .header-shop i, 
        .header-user i, 
        .header-logout i {
            font-size: 18px;
            line-height: 1;
        }
        
        .header-logout a {
            display: flex;
            align-items: center;
            gap: 5px;
            line-height: 1;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .search-input {
                width: 300px;
            }
            
            .blog-posts {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .search-input {
                width: 250px;
            }
            
            .blog-posts {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 576px) {
            .search-bar-container form {
                flex-direction: column;
                width: 100%;
            }
            
            .search-input {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .blog-posts {
                grid-template-columns: 1fr;
            }
            
            .fixed-add-posts-btn {
                right: 10px;
            }
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
                <ul style="display: flex; align-items: center; justify-content: center;">
                    <li><a href="/Gear" style="display: inline-block; text-align: center;">HOME</a></li>
                    <li><a href="/Gear/AboutController/index" style="display: inline-block; text-align: center;">ABOUT</a></li>
                    <li><a href="/Gear/ProductController/list" style="display: inline-block; text-align: center;">SHOP</a></li>
                    <li><a href="/Gear/ContactController" style="display: inline-block; text-align: center;">CONTACT</a></li>
                    <li><a href="/Gear/BlogController/list" style="display: inline-block; text-align: center;">BLOG</a></li>
                    <li><a href="/Gear/QAController/list" style="display: inline-block; text-align: center;">Q&A</a></li>
                </ul>
                </div>
                <div class="d-flex align-items-center">
                <div class="header-shop" style="display: flex; align-items: center;"><i class="fas fa-shopping-bag"></i></div>
                <?php if(isset($_COOKIE['access_token'])): ?>
                  <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;">
                    <a href="/Gear/AuthController/profile" title="Thông tin cá nhân" style="color: white; text-decoration: none; display: flex; align-items: center;">
                      <i class="fas fa-user"></i>
                    </a>
                  </div>
                  <div class="header-logout ml-3" style="display: flex; align-items: center;">
                    <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: white; text-decoration: none; display: flex; align-items: center;">
                      <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> <span>Đăng xuất</span>
                    </a>
                  </div>
                <?php else: ?>
                  <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;">
                    <a href="/Gear/AuthController/login" title="Đăng nhập" style="color: white; text-decoration: none; display: flex; align-items: center;">
                      <i class="fas fa-user"></i>
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
            <a href="/Gear/BlogController/create" class="btn btn-purple">
                <i class="fas fa-plus"></i> Add Posts
            </a>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="search-bar-container">
        <form class="form-inline justify-content-center" onsubmit="return handleSearch(event)">
            <input type="text" id="search-input" class="form-control search-input" placeholder="Tìm kiếm bài viết..." value="<?= isset($data['search']) ? htmlspecialchars($data['search']) : '' ?>">
            <button type="submit" class="btn btn-purple ml-2">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Danh sách bài viết -->
    <div class="blog-posts-container">
        <section class="blog-posts">
            <?php if ($data["posts"] && mysqli_num_rows($data["posts"]) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($data["posts"])): ?>
                    <a href="/Gear/BlogController/detail/<?= $row['id']; ?>" class="blog-post">
                        <div>
                            <img src="<?= $row['image'] ? '/Gear/' . $row['image'] : 'https://via.placeholder.com/300x200'; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                            <div class="post-info">
                                <span class="category"><?= htmlspecialchars($row['category']); ?></span>
                                <h2 class="post-title"><?= htmlspecialchars($row['title']); ?></h2>
                                <p class="post-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= date('F j, Y', strtotime($row['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                    <h3>Không tìm thấy bài viết.</h3>
                    <p class="text-muted">Hãy thử tìm kiếm với từ khóa khác.</p>
                </div>
            <?php endif; ?>
        </section>

        <!-- PHÂN TRANG -->
        <div class="container my-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <!-- Previous -->
                    <li class="page-item <?= $data["page"] <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="../<?= $searchPath ?>&page=<?= $data["page"] - 1; ?>" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
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
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- <footer class="footer">
            <p>Copyright © <?= date('Y'); ?> GearBK. All rights reserved.</p>
        </footer> -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        
        // Tạo hiệu ứng xuất hiện cho các bài viết
        document.addEventListener('DOMContentLoaded', function() {
            const posts = document.querySelectorAll('.blog-post');
            posts.forEach((post, index) => {
                post.style.opacity = '0';
                post.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    post.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    post.style.opacity = '1';
                    post.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</body>
</html>
