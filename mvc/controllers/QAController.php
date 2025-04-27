<?php
require_once 'mvc/models/QAModel.php';
require_once 'mvc/models/UserModel.php';

class QAController {
    private $model;
    private $con;
    private $userModel;
    
    public function __construct() {
        // Kiểm tra xem biến $con đã được định nghĩa chưa
        if (isset($GLOBALS['con'])) {
            $this->con = $GLOBALS['con'];
        } else {
            // Kết nối database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname ="gear";
            
            $this->con = new mysqli($servername, $username, $password, $dbname);
            
            if ($this->con->connect_error) {
                die("Connection failed: " . $this->con->connect_error);
            }
        }
        
        $this->model = new QAModel($this->con);
        $this->userModel = new UserModel();
    }
    
    // Admin panel - Quản lý Q&A
    public function admin() {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Xử lý các tham số từ URL
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $answers_page = isset($queryParams['answers_page']) ? (int)$queryParams['answers_page'] : 1;
        $active_tab = isset($queryParams['tab']) ? $queryParams['tab'] : 'questions';
        
        // Lấy danh sách câu hỏi
        $questions = $this->model->getQuestions($page, 10);
        $totalQuestions = $this->model->getTotalQuestions();
        $totalPages = ceil($totalQuestions / 10);
        
        // Lấy danh sách câu trả lời
        $answers = $this->model->getAllAnswers($answers_page, 10);
        $totalAnswers = $this->model->getTotalAnswers();
        $answersTotalPages = ceil($totalAnswers / 10);
        
        // Lấy danh sách tags
        $tags = $this->model->getAllTagsWithCount();
        
        $data = [
            'questions' => $questions,
            'page' => $page,
            'total_pages' => $totalPages,
            'answers' => $answers,
            'answers_page' => $answers_page,
            'answers_total_pages' => $answersTotalPages,
            'active_tab' => $active_tab,
            'tags' => $tags
        ];
        
        require_once 'mvc/views/QAAdminView.php';
    }
    
    // Chỉnh sửa câu hỏi (Admin)
    public function edit($id) {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Lấy thông tin câu hỏi
        $question = $this->model->getQuestionById($id);
        
        if ($question->num_rows == 0) {
            header('Location: /Gear/QAController/admin');
            exit;
        }
        
        // Lấy danh sách tags
        $tags = $this->model->getAllTags();
        // Lấy tags của câu hỏi
        $questionTags = $this->model->getTagsByQuestionId($id);
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $tagIds = isset($_POST['tags']) ? $_POST['tags'] : [];
            
            // Cập nhật câu hỏi
            $success = $this->model->updateQuestion($id, $title, $content, $tagIds);
            
            if ($success) {
                header('Location: /Gear/QAController/admin?message=Question+updated+successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật câu hỏi. Vui lòng thử lại.";
            }
        }
        
        $data = [
            'question' => $question->fetch_assoc(),
            'tags' => $tags,
            'questionTags' => $questionTags,
            'error' => isset($error) ? $error : null
        ];
        
        require_once 'mvc/views/QAEditView.php';
    }
    
    // Chỉnh sửa câu trả lời (Admin)
    public function editAnswer($id) {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Lấy thông tin câu trả lời
        $answer = $this->model->getAnswerById($id);
        
        if (!$answer) {
            header('Location: /Gear/QAController/admin?tab=answers');
            exit;
        }
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            
            // Cập nhật câu trả lời
            $success = $this->model->updateAnswer($id, $content);
            
            if ($success) {
                header('Location: /Gear/QAController/admin?tab=answers&message=Answer+updated+successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật câu trả lời. Vui lòng thử lại.";
            }
        }
        
        $data = [
            'answer' => $answer,
            'error' => isset($error) ? $error : null
        ];
        
        require_once 'mvc/views/QAEditAnswerView.php';
    }
    
    // Xóa câu hỏi (Admin)
    public function deleteQuestion() {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Kiểm tra method và id
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['question_id'])) {
            header('Location: /Gear/QAController/admin');
            exit;
        }
        
        $id = $_POST['question_id'];
        
        // Xóa câu hỏi
        $success = $this->model->deleteQuestion($id);
        
        if ($success) {
            header('Location: /Gear/QAController/admin?message=Question+deleted+successfully');
        } else {
            header('Location: /Gear/QAController/admin?message=Error+deleting+question&message_type=error');
        }
        exit;
    }
    
    // Xóa câu trả lời (Admin)
    public function deleteAnswer() {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Kiểm tra method và id
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['answer_id'])) {
            header('Location: /Gear/QAController/admin?tab=answers');
            exit;
        }
        
        $id = $_POST['answer_id'];
        
        // Xóa câu trả lời
        $success = $this->model->deleteAnswer($id);
        
        if ($success) {
            header('Location: /Gear/QAController/admin?tab=answers&message=Answer+deleted+successfully');
        } else {
            header('Location: /Gear/QAController/admin?tab=answers&message=Error+deleting+answer&message_type=error');
        }
        exit;
    }
    
    // Quản lý tags (thêm, sửa, xóa)
    public function manageTag() {
        // Kiểm tra quyền admin
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Gear/QAController/admin?tab=tags');
            exit;
        }
        
        $action = $_POST['action'] ?? '';
        $success = false;
        
        if ($action === 'add') {
            // Thêm tag mới
            $tagName = $_POST['tag_name'] ?? '';
            if (!empty($tagName)) {
                $tagId = $this->model->addTagIfNotExists($tagName);
                $success = ($tagId > 0);
            }
        } else if ($action === 'edit') {
            // Cập nhật tag
            $tagId = $_POST['tag_id'] ?? 0;
            $tagName = $_POST['tag_name'] ?? '';
            if (!empty($tagId) && !empty($tagName)) {
                $success = $this->model->updateTag($tagId, $tagName);
            }
        } else if ($action === 'delete') {
            // Xóa tag
            $tagId = $_POST['tag_id'] ?? 0;
            if (!empty($tagId)) {
                $success = $this->model->deleteTag($tagId);
            }
        }
        
        if ($success) {
            header('Location: /Gear/QAController/admin?tab=tags&message=Tag+updated+successfully');
        } else {
            header('Location: /Gear/QAController/admin?tab=tags&message=Error+updating+tag&message_type=error');
        }
        exit;
    }
    
    public function list() {
        // Phân tích URL để lấy tham số
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $keyword = isset($queryParams['keyword']) ? $queryParams['keyword'] : '';
        
        if (!empty($keyword)) {
            $questions = $this->model->searchQuestions($keyword, $page);
            $totalQuestions = $this->model->getTotalQuestionsBySearch($keyword);
        } else {
            $questions = $this->model->getQuestions($page);
            $totalQuestions = $this->model->getTotalQuestions();
        }
        
        $totalPages = ceil($totalQuestions / 6);
        
        $data = [
            'questions' => $questions,
            'page' => $page,
            'total_pages' => $totalPages,
            'search' => $keyword
        ];
        
        require_once 'mvc/views/QAView.php';
    }
    
    public function detail($id) {
        $question = $this->model->getQuestionById($id);
        
        if ($question->num_rows == 0) {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        $answers = $this->model->getAnswersByQuestionId($id);
        
        $data = [
            'question' => $question->fetch_assoc(),
            'answers' => $answers
        ];
        
        require_once 'mvc/views/QADetailView.php';
    }
    
    public function create() {
        // Kiểm tra đăng nhập
        if (!isset($_COOKIE['access_token'])) {
            header('Location: /Gear/AuthController/login');
            exit;
        }
        
        // Lấy danh sách tags để hiển thị trong form
        $tags = $this->model->getAllTags();
        $data = [
            'tags' => $tags
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy ID người dùng từ token
            $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
            
            // Nếu không lấy được ID người dùng, sử dụng ID mặc định
            if (!$userId) {
                $userId = 1;
            }
            
            $title = $_POST['title'];
            $content = $_POST['content'];
            $selectedTags = isset($_POST['tags']) ? $_POST['tags'] : [];
            
            if (empty($title) || empty($content)) {
                $error = "Title and content are required";
            } else {
                $result = $this->model->createQuestion($userId, $title, $content, $selectedTags);
                
                if ($result) {
                    header('Location: /Gear/QAController/list');
                    exit;
                } else {
                    $error = "Failed to create question";
                }
            }
        }
        
        require_once 'mvc/views/CreateQAView.php';
    }
    
    public function answer($id = null) {
        // Kiểm tra đăng nhập
        if (!isset($_COOKIE['access_token'])) {
            header('Location: /Gear/AuthController/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        // Lấy ID người dùng từ token
        $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
        
        if (!$userId) {
            $userId = 1;
        }
        
        $content = $_POST['content'];
        
        if (empty($content)) {
            header('Location: /Gear/QAController/detail/' . $id);
            exit;
        }
        
        $result = $this->model->createAnswer($id, $userId, $content);
        
        header('Location: /Gear/QAController/detail/' . $id . '?answer_posted=success');
        exit;
    }
    
    public function search() {
        // Phân tích URL để lấy tham số
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        
        $keyword = isset($queryParams['keyword']) ? $queryParams['keyword'] : '';
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        
        if (empty($keyword)) {
            header('Location: /Gear/QAController/list');
            exit;
        }
        
        $questions = $this->model->searchQuestions($keyword, $page);
        $totalQuestions = $this->model->getTotalQuestionsBySearch($keyword);
        $totalPages = ceil($totalQuestions / 6);
        
        $data = [
            'questions' => $questions,
            'page' => $page,
            'total_pages' => $totalPages,
            'search' => $keyword
        ];
        
        require_once 'mvc/views/QAView.php';
    }
    
    public function myQuestions() {
        // Kiểm tra đăng nhập
        if (!isset($_COOKIE['access_token'])) {
            header('Location: /Gear/AuthController/login');
            exit;
        }
        
        // Lấy ID người dùng từ token
        $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
        
        if (!$userId) {
            header('Location: /Gear/AuthController/login');
            exit;
        }
        
        // Phân tích URL để lấy tham số
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        
        $questions = $this->model->getQuestionsByUserId($userId, $page);
        $totalQuestions = $this->model->getTotalQuestionsByUserId($userId);
        $totalPages = ceil($totalQuestions / 6);
        
        $data = [
            'questions' => $questions,
            'page' => $page,
            'total_pages' => $totalPages,
            'is_my_questions' => true
        ];
        
        require_once 'mvc/views/QAView.php';
    }
    
    // Phương thức cho phân trang
    public function page($pageNumber = 1) {
        $page = (int)$pageNumber;
        if ($page < 1) $page = 1;
        
        $questions = $this->model->getQuestions($page);
        $totalQuestions = $this->model->getTotalQuestions();
        
        $totalPages = ceil($totalQuestions / 6);
        
        $data = [
            'questions' => $questions,
            'page' => $page,
            'total_pages' => $totalPages,
            'search' => ''
        ];
        
        require_once 'mvc/views/QAView.php';
    }
}