<?php
// Kiểm tra quyền admin
if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
    header("Location: /Gear/QAController/list");
    exit;
}

// Lấy dữ liệu từ controller
$answer = $data['answer'] ?? null;
$error = $data['error'] ?? null;

if (!$answer) {
    header("Location: /Gear/QAAdminController/dashboard?tab=answers");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Answer - GearBK Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for basic animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Summernote WYSIWYG Editor -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: url('/Gear/public/images/background_login.webp') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        
        /* Header styling */
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
            padding: 10px 0;
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
        
        .header-menu ul li a:hover, .header-menu ul li a.active {
            color: #6a1b9a;
        }
        
        .admin-container {
            max-width: 900px;
            margin: 120px auto 50px;
            padding: 0 20px;
        }
        
        .admin-header {
            margin-bottom: 30px;
        }
        
        .admin-badge {
            position: fixed;
            top: 80px;
            right: 20px;
            background-color: #6a1b9a;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 100;
            animation: fadeInRight 0.5s ease;
        }
        
        .admin-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-purple {
            background-color: #6a1b9a;
            border-color: #6a1b9a;
            color: white;
        }
        
        .btn-purple:hover {
            background-color: #9c27b0;
            border-color: #9c27b0;
            color: white;
        }
        
        .copyright-footer {
            text-align: center;
            padding: 20px 0;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            margin-top: 50px;
        }
        
        .note-editor .dropdown-toggle::after {
            display: none;
        }
        
        .question-info {
            background-color: #f8f4fc;
            border-left: 4px solid #6a1b9a;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .question-info h5 {
            color: #6a1b9a;
            margin-bottom: 10px;
        }
        
        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
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
                <li><a href="/Gear/ProductController/list">SHOP</a></li>
                <li><a href="/Gear/contact">CONTACT</a></li>
                <li><a href="/Gear/BlogController/list">BLOG</a></li>
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

    
    <!-- Admin Badge -->
    <div class="admin-badge">
        <i class="fas fa-user-shield"></i> Admin Mode
    </div>
    
    <div class="container admin-container">
        <!-- Admin Header -->
        <div class="admin-header">
            <h1 class="text-white">Edit Answer</h1>
            <p class="text-white">Make changes to the answer content below.</p>
        </div>
        
        <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <!-- Edit Form -->
        <div class="admin-card animate__animated animate__fadeIn">
            <!-- Question information -->
            <div class="question-info">
                <h5><i class="fas fa-question-circle"></i> Related Question</h5>
                <p class="mb-1"><strong>Title:</strong> <a href="/Gear/QAController/detail/<?= $answer['question_id'] ?>" target="_blank"><?= htmlspecialchars($answer['question_title'] ?? '') ?></a></p>
                <p class="mb-0"><strong>ID:</strong> <?= $answer['question_id'] ?? 'Unknown' ?></p>
            </div>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="content"><i class="fas fa-align-left"></i> Answer Content</label>
                    <textarea class="form-control" id="summernote" name="content"><?= $answer['content'] ?? '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-info-circle"></i> Additional Information</label>
                    <div class="card card-body bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Answer ID:</strong> <?= $answer['id'] ?? 'Unknown' ?></p>
                                <p class="mb-1"><strong>Author:</strong> <?= htmlspecialchars($answer['username'] ?? 'Anonymous') ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created:</strong> <?= isset($answer['created_at']) ? date('F j, Y g:i a', strtotime($answer['created_at'])) : 'Unknown' ?></p>
                                <p class="mb-1"><strong>Last Updated:</strong> <?= isset($answer['updated_at']) ? date('F j, Y g:i a', strtotime($answer['updated_at'])) : 'N/A' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <a href="/Gear/QAAdminController/dashboard?tab=answers" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-purple">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="copyright-footer">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> GearBK Admin Panel. All rights reserved.</p>
        </div>
    </div>
    
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Summernote editor
            $('#summernote').summernote({
                placeholder: 'Enter answer content here...',
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</body>
</html> 