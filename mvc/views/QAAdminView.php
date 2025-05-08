<?php
// Kiểm tra quyền admin
if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
    header("Location: /Gear/QAController/list");
    exit;
}

// Hiển thị thông báo nếu có
$message = isset($data['message']) ? $data['message'] : '';
$message_type = isset($data['message_type']) ? $data['message_type'] : 'success';

// Lấy dữ liệu từ controller
$questions = $data['questions'] ?? [];
$answers = $data['answers'] ?? [];
$page = $data['page'] ?? 1;
$total_pages = $data['total_pages'] ?? 1;
$active_tab = $data['active_tab'] ?? 'questions';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Admin Panel - GearBK</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for basic animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            /* background: url('/Gear/public/images/background_login.webp') no-repeat center center fixed;
            background-size: cover; */
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
        
        .header-menu ul li a:hover, .header-menu ul li a.active {
            color: #6a1b9a;
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 110px auto 50px;
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
        
        .nav-pills .nav-link.active {
            background-color: #6a1b9a;
        }
        
        .nav-pills .nav-link {
            color: #6a1b9a;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:hover {
            background-color: rgba(106, 27, 154, 0.1);
        }
        
        .table th {
            background-color: #6a1b9a;
            color: white;
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
        
        .alert-success {
            background-color: #e8f5e9;
            border-color: #a5d6a7;
            color: #2e7d32;
        }
        
        .alert-danger {
            background-color: #ffebee;
            border-color: #ef9a9a;
            color: #c62828;
        }
        
        .copyright-footer {
            text-align: center;
            padding: 20px 0;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            margin-top: 50px;
        }
        
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
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
                <li><a href="/Gear/ContactController">CONTACT</a></li>
                <li><a href="/Gear/BlogController/list">BLOG</a></li>
                <li><a href="/Gear/QAController/list">Q&A</a></li>
              </ul>
            </div>
            <div class="d-flex align-items-center">
              <div class="header-shop" style="display: flex; align-items: center;"><i class="fa-solid fa-bag-shopping"></i></div>
              <div class="header-user" style="display: flex; align-items: center; margin-left: 15px;"><i class="fa-solid fa-user"></i></div>
              <?php if(isset($_COOKIE['access_token'])): ?>
                <div class="header-logout ml-3" style="display: flex; align-items: center;">
                  <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fa-solid fa-sign-out-alt" style="margin-right: 5px;"></i> <span>Đăng xuất</span>
                  </a>
                </div>
              <?php endif; ?>
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
            <h1 class="text-white">Q&A Admin Panel</h1>
            <p class="text-white">Manage questions and answers for the GearBK Q&A section.</p>
        </div>
        
        <!-- Alert Messages -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <!-- Admin Content -->
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3">
                <div class="admin-card">
                    <h5 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard</h5>
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link <?= $active_tab === 'questions' ? 'active' : '' ?>" id="questions-tab" data-toggle="pill" href="#questions" role="tab">
                            <i class="fas fa-question-circle"></i> Manage Questions
                        </a>
                        <a class="nav-link <?= $active_tab === 'answers' ? 'active' : '' ?>" id="answers-tab" data-toggle="pill" href="#answers" role="tab">
                            <i class="fas fa-comment-alt"></i> Manage Answers
                        </a>
                        <a class="nav-link <?= $active_tab === 'tags' ? 'active' : '' ?>" id="tags-tab" data-toggle="pill" href="#tags" role="tab">
                            <i class="fas fa-tags"></i> Manage Tags
                        </a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="/Gear/QAController/list" class="btn btn-purple btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Q&A
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Questions Tab -->
                    <div class="tab-pane fade <?= $active_tab === 'questions' ? 'show active' : '' ?>" id="questions" role="tabpanel">
                        <div class="admin-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="m-0"><i class="fas fa-question-circle"></i> Manage Questions</h4>
                                <a href="/Gear/QAController/create" class="btn btn-purple">
                                    <i class="fas fa-plus"></i> Add New Question
                                </a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="35%">Title</th>
                                            <th width="15%">Author</th>
                                            <th width="15%">Date</th>
                                            <th width="10%">Answers</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($questions)): ?>
                                            <?php while ($question = mysqli_fetch_assoc($questions)): ?>
                                                <tr>
                                                    <td><?= $question['id'] ?></td>
                                                    <td class="truncate" title="<?= htmlspecialchars($question['title']) ?>"><?= htmlspecialchars($question['title']) ?></td>
                                                    <td><?= htmlspecialchars($question['username'] ?? 'Anonymous') ?></td>
                                                    <td><?= date('d/m/Y', strtotime($question['created_at'])) ?></td>
                                                    <td><?= $question['answer_count'] ?? 0 ?></td>
                                                    <td>
                                                        <a href="/Gear/QAController/detail/<?= $question['id'] ?>" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="/Gear/QAAdminController/editQuestion/<?= $question['id'] ?>" class="btn btn-sm btn-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger delete-question" data-id="<?= $question['id'] ?>" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No questions found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if (isset($total_pages) && $total_pages > 1): ?>
                                <nav aria-label="Questions pagination">
                                    <ul class="pagination justify-content-center mt-4">
                                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="/Gear/QAAdminController/dashboard?page=<?= $page - 1 ?>&tab=questions">Previous</a>
                                        </li>
                                        
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                                <a class="page-link" href="/Gear/QAAdminController/dashboard?page=<?= $i ?>&tab=questions"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="/Gear/QAAdminController/dashboard?page=<?= $page + 1 ?>&tab=questions">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Answers Tab -->
                    <div class="tab-pane fade <?= $active_tab === 'answers' ? 'show active' : '' ?>" id="answers" role="tabpanel">
                        <div class="admin-card">
                            <h4 class="mb-4"><i class="fas fa-comment-alt"></i> Manage Answers</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Question ID</th>
                                            <th width="40%">Content</th>
                                            <th width="15%">Author</th>
                                            <th width="15%">Date</th>
                                            <th width="10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($answers)): ?>
                                            <?php while ($answer = mysqli_fetch_assoc($answers)): ?>
                                                <tr>
                                                    <td><?= $answer['id'] ?></td>
                                                    <td>
                                                        <a href="/Gear/QAController/detail/<?= $answer['question_id'] ?>" title="View Question">
                                                            #<?= $answer['question_id'] ?>
                                                        </a>
                                                    </td>
                                                    <td class="truncate" title="<?= htmlspecialchars(strip_tags($answer['content'])) ?>"><?= htmlspecialchars(substr(strip_tags($answer['content']), 0, 50)) ?>...</td>
                                                    <td><?= htmlspecialchars($answer['username'] ?? 'Anonymous') ?></td>
                                                    <td><?= date('d/m/Y', strtotime($answer['created_at'])) ?></td>
                                                    <td>
                                                        <a href="/Gear/QAAdminController/editAnswer/<?= $answer['id'] ?>" class="btn btn-sm btn-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger delete-answer" data-id="<?= $answer['id'] ?>" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No answers found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination for Answers -->
                            <?php if (isset($data['answers_total_pages']) && $data['answers_total_pages'] > 1): ?>
                                <nav aria-label="Answers pagination">
                                    <ul class="pagination justify-content-center mt-4">
                                        <li class="page-item <?= $data['answers_page'] <= 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="/Gear/QAAdminController/dashboard?answers_page=<?= $data['answers_page'] - 1 ?>&tab=answers">Previous</a>
                                        </li>
                                        
                                        <?php for ($i = 1; $i <= $data['answers_total_pages']; $i++): ?>
                                            <li class="page-item <?= $data['answers_page'] == $i ? 'active' : '' ?>">
                                                <a class="page-link" href="/Gear/QAAdminController/dashboard?answers_page=<?= $i ?>&tab=answers"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <li class="page-item <?= $data['answers_page'] >= $data['answers_total_pages'] ? 'disabled' : '' ?>">
                                            <a class="page-link" href="/Gear/QAAdminController/dashboard?answers_page=<?= $data['answers_page'] + 1 ?>&tab=answers">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Tags Tab -->
                    <div class="tab-pane fade <?= $active_tab === 'tags' ? 'show active' : '' ?>" id="tags" role="tabpanel">
                        <div class="admin-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="m-0"><i class="fas fa-tags"></i> Manage Tags</h4>
                                <button type="button" class="btn btn-purple" data-toggle="modal" data-target="#tagModal" id="addTagBtn">
                                    <i class="fas fa-plus"></i> Add New Tag
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%">ID</th>
                                            <th width="60%">Name</th>
                                            <th width="20%">Question Count</th>
                                            <th width="10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($data['tags'])): ?>
                                            <?php foreach ($data['tags'] as $tag): ?>
                                                <tr>
                                                    <td><?= $tag['id'] ?></td>
                                                    <td><?= htmlspecialchars($tag['name']) ?></td>
                                                    <td><?= $tag['question_count'] ?? 0 ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary edit-tag" 
                                                                data-id="<?= $tag['id'] ?>" 
                                                                data-name="<?= htmlspecialchars($tag['name']) ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-tag" data-id="<?= $tag['id'] ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No tags found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Question Modal -->
    <div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Question</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this question? This action cannot be undone and will also delete all associated answers.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteQuestionForm" action="/Gear/QAAdminController/deleteQuestion" method="post">
                        <input type="hidden" id="delete_question_id" name="question_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Answer Modal -->
    <div class="modal fade" id="deleteAnswerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Answer</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this answer? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteAnswerForm" action="/Gear/QAAdminController/deleteAnswer" method="post">
                        <input type="hidden" id="delete_answer_id" name="answer_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Tag Modal -->
    <div class="modal fade" id="tagModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tagModalTitle">Add New Tag</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="tagForm" action="/Gear/QAAdminController/manageTag" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="tag_id" name="tag_id" value="">
                        <input type="hidden" id="tag_action" name="action" value="add">
                        
                        <div class="form-group">
                            <label for="tag_name">Tag Name</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <!-- <div class="copyright-footer">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> GearBK Admin Panel. All rights reserved.</p>
        </div>
    </div> -->
    
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation for cards
            $('.admin-card').addClass('animate__animated animate__fadeIn');
            
            // Delete Question
            $('.delete-question').click(function() {
                const questionId = $(this).data('id');
                $('#delete_question_id').val(questionId);
                $('#deleteQuestionModal').modal('show');
            });
            
            // Delete Answer
            $('.delete-answer').click(function() {
                const answerId = $(this).data('id');
                $('#delete_answer_id').val(answerId);
                $('#deleteAnswerModal').modal('show');
            });
            
            // Add new tag
            $('#addTagBtn').click(function() {
                $('#tagModalTitle').text('Add New Tag');
                $('#tag_id').val('');
                $('#tag_name').val('');
                $('#tag_action').val('add');
            });
            
            // Edit tag
            $('.edit-tag').click(function() {
                const tagId = $(this).data('id');
                const tagName = $(this).data('name');
                
                $('#tagModalTitle').text('Edit Tag');
                $('#tag_id').val(tagId);
                $('#tag_name').val(tagName);
                $('#tag_action').val('edit');
                $('#tagModal').modal('show');
            });
            
            // Delete tag
            $('.delete-tag').click(function() {
                if (confirm('Are you sure you want to delete this tag?')) {
                    const tagId = $(this).data('id');
                    
                    $.post('/Gear/QAAdminController/manageTag', {
                        tag_id: tagId,
                        action: 'delete'
                    }).done(function(response) {
                        window.location.reload();
                    });
                }
            });
            
            // Active tab handling from URL
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab) {
                $('.nav-pills a[href="#' + tab + '"]').tab('show');
            }
        });
    </script>
</body>
</html> 