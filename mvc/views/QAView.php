<?php
// Tạo search path đúng định dạng routing - thêm page cố định vào URL
$searchPath = isset($data['search']) && $data['search'] !== ''
    ? "QAController/search?keyword=" . urlencode($data['search'])
    : (isset($data['is_my_questions']) ? "QAController/myQuestions" : "QAController/list");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions & Answers - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <link rel="stylesheet" href="/Gear/public/css/header.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <link rel="stylesheet" href="/Gear/public/css/qa.css">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            color: #333333;
        }
        
        .qa-container {
            max-width: 1000px;
            margin: 110px auto 50px;
            padding: 0 20px;
        }
        
        /* Thống nhất kiểu header giống AboutView */
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
        
        .header-shop, .header-user {
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin-left: 20px;
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
                <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="header-menu" id="header-menu">
                <ul>
                    <li><a href="/Gear">HOME</a></li>
                    <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                    <li><a href="/Gear/ProductController/list">SHOP</a></li>
                    <li><a href="/Gear/ContactController">CONTACT</a></li>
                    <li><a href="/Gear/BlogController/list">BLOG</a></li>
                    <li><a href="/Gear/QAController/list">Q&A</a></li>
                    <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
            <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
        <?php endif; ?>
                </ul>
                </div>
                <div class="d-flex align-items-center">
                <div class="header-shop" style="display: flex; align-items: center;"><i class="fa-solid fa-bag-shopping"></i></div>
                <?php if(isset($_COOKIE['access_token'])): ?>
                  <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;">
                    <a href="/Gear/AuthController/profile" title="Thông tin cá nhân" style="color: white; text-decoration: none; display: flex; align-items: center;">
                      <i class="fa-solid fa-user"></i>
                    </a>
                  </div>
                  <div class="header-logout ml-3" style="display: flex; align-items: center;">
                    <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: white; text-decoration: none; display: flex; align-items: center;">
                      <i class="fa-solid fa-sign-out-alt" style="margin-right: 5px;"></i> <span>Đăng xuất</span>
                    </a>
                  </div>
                <?php else: ?>
                  <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;">
                    <a href="/Gear/AuthController/login" title="Đăng nhập" style="color: white; text-decoration: none; display: flex; align-items: center;">
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


    <!-- Main Content -->
    <div class="qa-container">
        <!-- Header section -->
        <div class="qa-header">
            <h1 style="color: #dc3545;" class="qa-title-main animate__animated animate__fadeIn">
                <?= isset($data['is_my_questions']) ? 'My Questions' : 'Questions & Answers' ?>
            </h1>
            <div class="qa-buttons animate__animated animate__fadeIn animate__delay-1s">
                <?php if (isset($_COOKIE['access_token'])): ?>
                    <?php if (!isset($data['is_my_questions'])): ?>
                        <a href="/Gear/QAController/myQuestions" class="qa-btn qa-btn-secondary mr-2">
                            <i class="fas fa-list"></i> My Questions
                        </a>
                    <?php else: ?>
                        <a href="/Gear/QAController/list" class="qa-btn qa-btn-secondary mr-2">
                            <i class="fas fa-globe"></i> All Questions
                        </a>
                    <?php endif; ?>
                    
                    <!-- Admin Control Panel -->
                    <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
                        <a href="/Gear/QAAdminController/dashboard" class="qa-btn qa-btn-admin mr-2">
                            <i class="fas fa-cog"></i> Admin Panel
                        </a>
                    <?php endif; ?>
                    
                    <a href="/Gear/QAController/create" class="qa-ask-btn">
                        <i class="fas fa-plus-circle"></i> Ask a Question
                    </a>
                <?php else: ?>
                    <a href="/Gear/AuthController/login" class="qa-ask-btn">
                        <i class="fas fa-plus-circle"></i> Ask a Question
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Admin Alert if admin user -->
        
        
        <!-- Search bar (don't show on my questions page) -->
        <?php if (!isset($data['is_my_questions'])): ?>
            <div class="qa-search-container animate__animated animate__fadeIn animate__delay-1s">
                <form method="get" action="/Gear/QAController/search" class="qa-search-container">
                    <input 
                        type="text" 
                        name="keyword"           
                        id="search-input" 
                        class="qa-search-input" 
                        placeholder="Search questions."
                        value="<?= htmlspecialchars($data['search'] ?? '') ?>"
                        required
                    >
                    <button type="submit" class="qa-search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        <?php endif; ?>
        
        <!-- Question cards -->
        <?php if ($data["questions"] && mysqli_num_rows($data["questions"]) > 0): ?>
            <?php while ($question = mysqli_fetch_assoc($data["questions"])): ?>
                <div class="qa-card">
                    <div class="qa-card-body">
                        <div class="qa-answer-count"><?= $question['answer_count'] ?? 0 ?></div>
                        <a href="/Gear/QAController/detail/<?= $question['id']; ?>" class="text-decoration-none">
                            <h3 class="qa-title"><?= htmlspecialchars($question['title']); ?></h3>
                        </a>
                        <div class="qa-meta">
                            <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($question['username'] ?? 'Anonymous'); ?></span>
                            <span><i class="far fa-clock"></i> <?= date('F j, Y', strtotime($question['created_at'])); ?></span>
                        </div>
                        <p><?= substr(strip_tags($question['content']), 0, 150) . (strlen(strip_tags($question['content'])) > 150 ? '...' : ''); ?></p>
                        
                        <?php if (!empty($question['tags'])): ?>
                            <div class="qa-tags">
                                <?php foreach (explode(',', $question['tags']) as $tag): ?>
                                    <span class="qa-tag"><?= trim(htmlspecialchars($tag)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="qa-stats">
                            <div class="qa-stat">
                                <i class="fas fa-comment-alt"></i>
                                <span><?= $question['answer_count'] ?? 0 ?> Answers</span>
                            </div>
                            <a href="/Gear/QAController/detail/<?= $question['id']; ?>" class="text-decoration-none">
                                <span class="text-purple">View Details <i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="qa-empty animate__animated animate__fadeIn">
                <?php if (isset($data['is_my_questions'])): ?>
                    <h3>You haven't asked any questions yet</h3>
                    <p>Ask your first question to get help from the community!</p>
                <?php else: ?>
                    <h3>No questions found</h3>
                    <p>Be the first to ask a question!</p>
                <?php endif; ?>
                <a href="/Gear/QAController/create" class="qa-ask-btn pulse-animation">
                    <i class="fas fa-plus-circle"></i> Ask a Question
                </a>
            </div>
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php if (isset($data["total_pages"]) && $data["total_pages"] > 1): ?>
            <div class="my-4">
                <nav aria-label="Question navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous -->
                        <li class="page-item <?= $data["page"] <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="/Gear/QAController/page/<?= $data["page"] - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>

                        <!-- Page numbers -->
                        <?php for ($i = 1; $i <= $data["total_pages"]; $i++): ?>
                            <li class="page-item <?= $i == $data["page"] ? 'active' : ''; ?>">
                                <a class="page-link" href="/Gear/QAController/page/<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <li class="page-item <?= $data["page"] >= $data["total_pages"] ? 'disabled' : ''; ?>">
                            <a class="page-link" href="/Gear/QAController/page/<?= $data["page"] + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="text-center text-white">Copyright © <?= date('Y'); ?> GearBK</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.qa-card');
            cards.forEach(card => {
                observer.observe(card);
            });
            
            // Hover effects for cards with jQuery for smoother transitions
            $('.qa-card').hover(
                function() {
                    $(this).find('.qa-title').css('color', '#dc3545');
                },
                function() {
                    $(this).find('.qa-title').css('color', '#b02a37');
                }
            );
            
            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const headerMenu = document.getElementById('header-menu');
            
            if (mobileMenuToggle && headerMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    headerMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a link
                const menuLinks = headerMenu.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenuToggle.classList.remove('active');
                        headerMenu.classList.remove('active');
                    });
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    const isClickInsideMenu = headerMenu.contains(event.target);
                    const isClickOnToggle = mobileMenuToggle.contains(event.target);
                    
                    if (!isClickInsideMenu && !isClickOnToggle && headerMenu.classList.contains('active')) {
                        mobileMenuToggle.classList.remove('active');
                        headerMenu.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html> 