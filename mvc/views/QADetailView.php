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
    <style>
        /* Q&A Detail specific styles */
        .header-menu ul li a.active {
            color: #6a1b9a !important;
            font-weight: 700;
        }
        
        .qa-detail-container {
            max-width: 900px;
            margin: 150px auto 50px;
            padding: 0 20px;
        }
        
        .qa-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .qa-question-header {
            background-color: #4a0072;
            color: white;
            padding: 20px 25px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        
        .qa-question-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .qa-question-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .qa-question-body {
            padding: 25px;
        }
        
        .qa-question-content {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .qa-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }
        
        .qa-tag {
            background-color: #f0e6f5;
            color: #6a1b9a;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .qa-tag:hover {
            background-color: #6a1b9a;
            color: white;
            transform: translateY(-2px);
        }
        
        .qa-answers-section {
            margin-top: 40px;
        }
        
        .qa-answers-count {
            font-size: 1.4rem;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        .qa-answer {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            padding: 20px;
            position: relative;
            border-left: 4px solid #6a1b9a;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .qa-answer:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .qa-answer-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }
        
        .qa-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .qa-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #6a1b9a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .qa-answer-content {
            font-size: 1.05rem;
            line-height: 1.6;
        }
        
        .qa-your-answer {
            margin-top: 40px;
        }
        
        .qa-your-answer-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        .qa-form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .qa-form-label {
            font-weight: 600;
            color: #4a0072;
            margin-bottom: 10px;
        }
        
        .qa-textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 1rem;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .qa-textarea:focus {
            outline: none;
            border-color: #6a1b9a;
            box-shadow: 0 0 0 3px rgba(106, 27, 154, 0.2);
        }
        
        .qa-submit-btn {
            background-color: #6a1b9a;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .qa-submit-btn:hover {
            background-color: #4a0072;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .qa-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .qa-back-btn:hover {
            transform: translateX(-5px);
            color: #f0e6f5;
            text-decoration: none;
        }
        
        .qa-required-login {
            text-align: center;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            margin-top: 20px;
        }
        
        .qa-login-btn {
            background-color: #6a1b9a;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        
        .qa-login-btn:hover {
            background-color: #4a0072;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
        
        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .qa-answer {
            animation: slideInRight 0.5s ease forwards;
            opacity: 0;
        }
        
        .qa-answer:nth-child(1) { animation-delay: 0.1s; }
        .qa-answer:nth-child(2) { animation-delay: 0.2s; }
        .qa-answer:nth-child(3) { animation-delay: 0.3s; }
        .qa-answer:nth-child(4) { animation-delay: 0.4s; }
        .qa-answer:nth-child(5) { animation-delay: 0.5s; }
        
        .qa-highlight {
            background-color: rgba(106, 27, 154, 0.1);
            border-radius: 3px;
            padding: 2px 5px;
            transition: background-color 0.3s ease;
        }
        
        .qa-highlight:hover {
            background-color: rgba(106, 27, 154, 0.2);
        }
        
        .qa-empty-answers {
            text-align: center;
            padding: 40px 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            margin-bottom: 30px;
        }
        
        .qa-empty-answers h3 {
            color: #4a0072;
            margin-bottom: 15px;
        }
        
        .qa-empty-answers p {
            color: #666;
            margin-bottom: 0;
        }
        
        /* Flash message styles */
        .qa-flash-success {
            background-color: rgba(76, 175, 80, 0.9);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .qa-flash-success i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .qa-flash-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 0;
            margin: 0;
            line-height: 1;
        }
        
        .qa-flash-close:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                <li><a href="/Gear/shop">SHOP</a></li>
                <li><a href="/Gear/contact">CONTACT</a></li>
                <li><a href="/Gear/news">NEWS</a></li>
                <li><a href="/Gear/QAController/list">Q&A</a></li>
              </ul>
            </div>
            <div class="d-flex">
              <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
              <div class="header-user"><i class="fa-solid fa-user"></i></div>
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
    </script>
</body>
</html> 