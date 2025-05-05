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
        .qa-container {
    max-width: 1000px;
    margin: 150px auto 50px;
    padding: 0 20px;
}

.qa-card {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    position: relative;
    border-left: 5px solid #6a1b9a;
}

.qa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
}

.qa-card-body {
    padding: 25px;
}

.qa-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #4a0072;
    margin-bottom: 15px;
    transition: color 0.3s ease;
}

.qa-card:hover .qa-title {
    color: #6a1b9a;
}

.qa-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.qa-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 15px;
}

.qa-tag {
    background-color: #f0e6f5;
    color: #6a1b9a;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.qa-tag:hover {
    background-color: #6a1b9a;
    color: white;
}

.qa-stats {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    color: #666;
}

.qa-stat {
    display: flex;
    align-items: center;
    gap: 5px;
}

.qa-search-container {
    position: relative;
    margin-bottom: 40px;
}

.qa-search-input {
    width: 100%;
    height: 50px;
    border-radius: 25px;
    border: none;
    padding: 0 60px 0 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    font-size: 1rem;
    transition: box-shadow 0.3s ease;
}

.qa-search-input:focus {
    box-shadow: 0 4px 20px rgba(106, 27, 154, 0.2);
    outline: none;
}

.qa-search-btn {
    position: absolute;
    right: 5px;
    top: 5px;
    height: 40px;
    width: 40px;
    border-radius: 20px;
    background-color: #6a1b9a;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.qa-search-btn:hover {
    background-color: #4a0072;
}

.qa-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.qa-title-main {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.qa-ask-btn {
    background-color: #6a1b9a;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.qa-ask-btn:hover {
    background-color: #4a0072;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.qa-ask-btn i {
    font-size: 1.2rem;
}

.qa-empty {
    text-align: center;
    padding: 50px 0;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    margin-top: 30px;
}

.qa-empty h3 {
    color: #4a0072;
    margin-bottom: 15px;
}

.qa-empty p {
    color: #666;
    margin-bottom: 25px;
}

/* Buttons container */
.qa-buttons {
    display: flex;
    align-items: center;
}

/* Secondary button style */
.qa-btn {
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.qa-btn-secondary {
    background-color: transparent;
    color: white;
    border: 2px solid white;
}

.qa-btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.qa-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.qa-card:nth-child(1) { animation-delay: 0.1s; }
.qa-card:nth-child(2) { animation-delay: 0.2s; }
.qa-card:nth-child(3) { animation-delay: 0.3s; }
.qa-card:nth-child(4) { animation-delay: 0.4s; }
.qa-card:nth-child(5) { animation-delay: 0.5s; }
.qa-card:nth-child(6) { animation-delay: 0.6s; }

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.qa-answer-count {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: #6a1b9a;
    color: white;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.9rem;
    transition: transform 0.3s ease;
}

.qa-card:hover .qa-answer-count {
    transform: scale(1.1);
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


    <!-- Main Content -->
    <div class="qa-container">
        <!-- Header section -->
        <div class="qa-header">
            <h1 class="qa-title-main animate__animated animate__fadeIn">
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
                    $(this).find('.qa-title').css('color', '#6a1b9a');
                },
                function() {
                    $(this).find('.qa-title').css('color', '#4a0072');
                }
            );
        });
    </script>
</body>
</html> 