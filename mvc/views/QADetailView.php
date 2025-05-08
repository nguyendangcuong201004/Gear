<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['question']['title']); ?> - GearBK Q&A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Gear/public/css/QADetailView.css">
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
                                <li><a href="/Gear/QAController/list" class="active">Q&A</a></li>
                                <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
            <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
        <?php endif; ?>
                            </ul>
                        </div>
                        <div class="d-flex">
                            <div class="header-shop" style="display: flex; align-items: center;"><i class="fa-solid fa-bag-shopping"></i></div>
                            <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;"><i class="fa-solid fa-user"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="qa-detail-container">
        <!-- Back button -->
        <a href="/Gear/QAController/list" class="qa-back-btn animate__animated animate__fadeIn">
            <i class="fas fa-arrow-left"></i> Back to Questions
        </a>
        
        <!-- Flash message for answer success -->
        <?php if (isset($_GET['answer_posted']) && $_GET['answer_posted'] == 'success'): ?>
            <div class="qa-flash-success animate__animated animate__fadeIn">
                <i class="fas fa-check-circle"></i> Your answer has been posted successfully!
                <button class="qa-flash-close" onclick="this.parentElement.style.display='none'">×</button>
            </div>
        <?php endif; ?>
        
        <!-- Question card -->
        <div class="qa-card animate__animated animate__fadeIn animate__delay-1s">
            <div class="qa-question-header">
                <h1 class="qa-question-title"><?= htmlspecialchars($data['question']['title']); ?></h1>
                <div class="qa-question-meta">
                    <span><i class="fas fa-user-circle"></i> <?= htmlspecialchars($data['question']['username'] ?? 'Anonymous'); ?></span>
                    <span><i class="far fa-clock"></i> <?= date('F j, Y', strtotime($data['question']['created_at'])); ?></span>
                </div>
            </div>
            <div class="qa-question-body">
                <div class="qa-question-content">
                    <?= $data['question']['content']; ?>
                </div>
                
                <?php if (!empty($data['question']['tags'])): ?>
                    <div class="qa-tags">
                        <?php foreach (explode(',', $data['question']['tags']) as $tag): ?>
                            <span class="qa-tag"><?= trim(htmlspecialchars($tag)); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Answers section -->
        <div class="qa-answers-section">
            <h2 class="qa-answers-count animate__animated animate__fadeIn animate__delay-1s">
                <?= $data['answers']->num_rows ?> Answers
            </h2>
            
            <?php if ($data['answers']->num_rows > 0): ?>
                <?php while ($answer = $data['answers']->fetch_assoc()): ?>
                    <div class="qa-answer">
                        <div class="qa-answer-meta">
                            <div class="qa-user">
                                <div class="qa-user-avatar">
                                    <?= strtoupper(substr($answer['username'] ?? 'A', 0, 1)); ?>
                                </div>
                                <span><?= htmlspecialchars($answer['username'] ?? 'Anonymous'); ?></span>
                            </div>
                            <span><i class="far fa-clock"></i> <?= date('F j, Y', strtotime($answer['created_at'])); ?></span>
                        </div>
                        <div class="qa-answer-content">
                            <?= $answer['content']; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="qa-empty-answers animate__animated animate__fadeIn animate__delay-1s">
                    <h3>No answers yet</h3>
                    <p>Be the first to answer this question!</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Your answer section -->
        <div class="qa-your-answer">
            <h2 class="qa-your-answer-title animate__animated animate__fadeIn animate__delay-1s">Your Answer</h2>
            
            <?php if (isset($_COOKIE['access_token'])): ?>
                <div class="qa-form-container animate__animated animate__fadeIn animate__delay-1s">
                    <form action="/Gear/QAController/answer/<?= $data['question']['id']; ?>" method="post">
                        <label for="content" class="qa-form-label">Write your answer below:</label>
                        <textarea name="content" id="content" class="qa-textarea"></textarea>
                        <input type="hidden" id="content-hidden" name="content">
                        
                        <button type="submit" class="qa-submit-btn">
                            <i class="fas fa-paper-plane"></i> Post Your Answer
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="qa-required-login animate__animated animate__fadeIn animate__delay-1s">
                    <h3>You need to be logged in to answer</h3>
                    <p>Please log in to share your knowledge with the community</p>
                    <a href="/Gear/AuthController/login" class="qa-login-btn">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <p class="text-center text-white mt-4">Copyright © <?= date('Y'); ?> GearBK</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        // Animate answer cards on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Summernote rich text editor
            $('#content').summernote({
                placeholder: 'Viết câu trả lời của bạn ở đây...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            
            // Form submission handling to capture Summernote content
            $('form').on('submit', function() {
                // Get the content from Summernote before submitting
                const content = $('#content').summernote('code');
                // Update the hidden field with the HTML content
                $('#content-hidden').val(content);
            });

            const answers = document.querySelectorAll('.qa-answer');
            answers.forEach(answer => {
                observer.observe(answer);
            });
            
            // Highlight code or technical terms in content
            const contentElements = document.querySelectorAll('.qa-question-content, .qa-answer-content');
            contentElements.forEach(element => {
                // Simple regex to find code-like patterns
                const codePattern = /`([^`]+)`/g;
                element.innerHTML = element.innerHTML.replace(codePattern, '<span class="qa-highlight">$1</span>');
            });
            
            // Add subtle animation when hovering over the question card
            $('.qa-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-5px)');
                    $(this).css('box-shadow', '0 12px 30px rgba(0, 0, 0, 0.15)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                    $(this).css('box-shadow', '0 8px 20px rgba(0, 0, 0, 0.1)');
                }
            );
            
            // Focus animation for textarea
            $('.qa-textarea').focus(function() {
                $(this).css('transform', 'scale(1.01)');
            }).blur(function() {
                $(this).css('transform', 'scale(1)');
            });
        });

        // Add mobile menu JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
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