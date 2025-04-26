<?php
require_once 'mvc/models/QAModel.php';

class QAController {
    private $model;
    private $con;
    
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
            header('Location: /ltw/QAController/list');
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
            header('Location: /ltw/AuthController/login');
            exit;
        }
        
        // Lấy danh sách tags để hiển thị trong form
        $tags = $this->model->getAllTags();
        $data = [
            'tags' => $tags
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy ID người dùng từ token
            require_once "./mvc/models/UserModel.php";
            $userModel = new UserModel();
            $userId = $userModel->getUserIdFromToken($_COOKIE['access_token']);
            
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
                    header('Location: /ltw/QAController/list');
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
            header('Location: /ltw/AuthController/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            header('Location: /ltw/QAController/list');
            exit;
        }
        
        // Lấy ID người dùng từ token
        require_once "./mvc/models/UserModel.php";
        $userModel = new UserModel();
        $userId = $userModel->getUserIdFromToken($_COOKIE['access_token']);
        
        if (!$userId) {
            $userId = 1;
        }
        
        $content = $_POST['content'];
        
        if (empty($content)) {
            header('Location: /ltw/QAController/detail/' . $id);
            exit;
        }
        
        $result = $this->model->createAnswer($id, $userId, $content);
        
        header('Location: /ltw/QAController/detail/' . $id . '?answer_posted=success');
        exit;
    }
    
    public function search() {
        // Phân tích URL để lấy tham số
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        
        $keyword = isset($queryParams['keyword']) ? $queryParams['keyword'] : '';
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        
        if (empty($keyword)) {
            header('Location: /ltw/QAController/list');
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
            header('Location: /ltw/AuthController/login');
            exit;
        }
        
        // Lấy ID người dùng từ token
        require_once "./mvc/models/UserModel.php";
        $userModel = new UserModel();
        $userId = $userModel->getUserIdFromToken($_COOKIE['access_token']);
        
        if (!$userId) {
            header('Location: /ltw/AuthController/login');
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