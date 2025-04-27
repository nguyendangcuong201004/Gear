<?php
// controllers/QAAdminController.php
require_once 'mvc/models/QAAdminModel.php';
require_once 'mvc/models/UserModel.php';

class QAAdminController {
    private $model;
    private $userModel;
    
    public function __construct() {
        // Kiểm tra xem biến $con đã được định nghĩa chưa
        if (isset($GLOBALS['con'])) {
            $con = $GLOBALS['con'];
        } else {
            // Kết nối database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname ="gear";
            
            $con = new mysqli($servername, $username, $password, $dbname);
            
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
        }
        
        $this->model = new QAAdminModel($con);
        $this->userModel = new UserModel();
    }
    
    // Kiểm tra quyền admin
    private function checkAdminPermission() {
        if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
            header('Location: /ltw/QAController/list');
            exit;
        }
    }
    
    // Dashboard admin - Quản lý Q&A
    public function dashboard() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Xử lý các tham số từ URL
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($urlParts['query'] ?? '', $queryParams);
        
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $answers_page = isset($queryParams['answers_page']) ? (int)$queryParams['answers_page'] : 1;
        $active_tab = isset($queryParams['tab']) ? $queryParams['tab'] : 'questions';
        
        // Lấy danh sách câu hỏi
        $questions = $this->model->getAllQuestions($page, 10);
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
        
        // Hiển thị thông báo nếu có
        if (isset($queryParams['message'])) {
            $data['message'] = urldecode($queryParams['message']);
            $data['message_type'] = isset($queryParams['message_type']) ? $queryParams['message_type'] : 'success';
        }
        
        require_once 'mvc/views/QAAdminView.php';
    }
    
    // Chỉnh sửa câu hỏi
    public function editQuestion($id) {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Lấy thông tin câu hỏi
        $question = $this->model->getQuestionById($id);
        
        if (!$question) {
            header('Location: /ltw/QAAdminController/dashboard');
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
                header('Location: /ltw/QAAdminController/dashboard?message=Question+updated+successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật câu hỏi. Vui lòng thử lại.";
            }
        }
        
        $data = [
            'question' => $question,
            'tags' => $tags,
            'questionTags' => $questionTags,
            'error' => isset($error) ? $error : null
        ];
        
        require_once 'mvc/views/QAEditView.php';
    }
    
    // Chỉnh sửa câu trả lời
    public function editAnswer($id) {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Lấy thông tin câu trả lời
        $answer = $this->model->getAnswerById($id);
        
        if (!$answer) {
            header('Location: /ltw/QAAdminController/dashboard?tab=answers');
            exit;
        }
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            
            // Cập nhật câu trả lời
            $success = $this->model->updateAnswer($id, $content);
            
            if ($success) {
                header('Location: /ltw/QAAdminController/dashboard?tab=answers&message=Answer+updated+successfully');
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
    
    // Xóa câu hỏi
    public function deleteQuestion() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Kiểm tra method và id
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['question_id'])) {
            header('Location: /ltw/QAAdminController/dashboard');
            exit;
        }
        
        $id = $_POST['question_id'];
        
        // Xóa câu hỏi
        $success = $this->model->deleteQuestion($id);
        
        if ($success) {
            header('Location: /ltw/QAAdminController/dashboard?message=Question+deleted+successfully');
        } else {
            header('Location: /ltw/QAAdminController/dashboard?message=Error+deleting+question&message_type=error');
        }
        exit;
    }
    
    // Xóa câu trả lời
    public function deleteAnswer() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Kiểm tra method và id
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['answer_id'])) {
            header('Location: /ltw/QAAdminController/dashboard?tab=answers');
            exit;
        }
        
        $id = $_POST['answer_id'];
        
        // Xóa câu trả lời
        $success = $this->model->deleteAnswer($id);
        
        if ($success) {
            header('Location: /ltw/QAAdminController/dashboard?tab=answers&message=Answer+deleted+successfully');
        } else {
            header('Location: /ltw/QAAdminController/dashboard?tab=answers&message=Error+deleting+answer&message_type=error');
        }
        exit;
    }
    
    // Quản lý tags (thêm, sửa, xóa)
    public function manageTag() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Kiểm tra method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ltw/QAAdminController/dashboard?tab=tags');
            exit;
        }
        
        $action = $_POST['action'] ?? '';
        $success = false;
        
        if ($action === 'add') {
            // Thêm tag mới
            $tagName = $_POST['tag_name'] ?? '';
            if (!empty($tagName)) {
                $success = $this->model->createTag($tagName);
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
            header('Location: /ltw/QAAdminController/dashboard?tab=tags&message=Tag+operation+completed+successfully');
        } else {
            header('Location: /ltw/QAAdminController/dashboard?tab=tags&message=Error+during+tag+operation&message_type=error');
        }
        exit;
    }
} 