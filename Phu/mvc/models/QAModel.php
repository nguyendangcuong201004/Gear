<?php
class QAModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getQuestions($page = 1, $limit = 6) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 6;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT q.*, u.username, 
                (SELECT COUNT(*) FROM answers WHERE question_id = q.id) as answer_count 
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                ORDER BY q.created_at DESC
                LIMIT $offset, $limit";
                
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    public function getQuestionById($id) {
        $sql = "SELECT q.*, u.username 
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                WHERE q.id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
    public function getAnswersByQuestionId($questionId) {
        $sql = "SELECT a.*, u.username 
                FROM answers a
                LEFT JOIN users u ON a.user_id = u.id
                WHERE a.question_id = ?
                ORDER BY a.created_at ASC";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
    public function createQuestion($userId, $title, $content, $tags) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Chèn câu hỏi mới không có tags
            $sql = "INSERT INTO questions (user_id, title, content, created_at) 
                    VALUES (?, ?, ?, NOW())";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $userId, $title, $content);
            $success = $stmt->execute();
            
            if (!$success) {
                $this->conn->rollback();
                return false;
            }
            
            // Lấy ID của câu hỏi vừa tạo
            $questionId = $this->conn->insert_id;
            
            // Xử lý tags nếu có
            if (!empty($tags) && is_array($tags)) {
                foreach ($tags as $tagName) {
                    // Thêm tag mới hoặc lấy ID nếu đã tồn tại
                    $tagId = $this->addTagIfNotExists($tagName);
                    
                    // Liên kết tag với câu hỏi
                    $this->linkTagToQuestion($questionId, $tagId);
                }
            } else if (!empty($tags) && is_string($tags)) {
                // Nếu tags là chuỗi, tách ra và xử lý từng tag
                $tagsArray = explode(',', $tags);
                foreach ($tagsArray as $tagName) {
                    $tagName = trim($tagName);
                    if (!empty($tagName)) {
                        $tagId = $this->addTagIfNotExists($tagName);
                        $this->linkTagToQuestion($questionId, $tagId);
                    }
                }
            }
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    
    public function createAnswer($questionId, $userId, $content) {
        $sql = "INSERT INTO answers (question_id, user_id, content, created_at) 
                VALUES (?, ?, ?, NOW())";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $questionId, $userId, $content);
        
        return $stmt->execute();
    }
    
    public function searchQuestions($keyword, $page = 1, $limit = 6) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 6;
        $offset = ($page - 1) * $limit;
        
        // Trích xuất từ khóa với hỗ trợ tiếng Việt
        $keywords = $this->extractKeywords($keyword);
        if (empty($keywords)) {
            // Nếu không có từ khóa, trả về danh sách rỗng
            $emptyResult = $this->conn->query("SELECT * FROM questions WHERE 1=0");
            return $emptyResult;
        }
        
        // Tạo điều kiện tìm kiếm LIKE
        $searchConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $searchConditions[] = "(q.title LIKE '%$kw%' OR q.content LIKE '%$kw%')";
        }
        $searchSql = implode(' OR ', $searchConditions);
        
        // Tạo SQL cho tìm kiếm tags
        $tagConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $tagConditions[] = "t.name LIKE '%$kw%'";
        }
        $tagSql = !empty($tagConditions) ? 
            "OR q.id IN (SELECT qt.question_id FROM question_tags qt JOIN tags t ON qt.tag_id = t.id WHERE " . 
            implode(' OR ', $tagConditions) . ")" : "";
        
        // Kết hợp các điều kiện tìm kiếm
        $sql = "SELECT DISTINCT q.*, u.username, 
                (SELECT COUNT(*) FROM answers WHERE question_id = q.id) as answer_count
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                WHERE ($searchSql $tagSql)
                ORDER BY q.created_at DESC
                LIMIT $offset, $limit";
        
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    public function getTotalQuestions() {
        $sql = "SELECT COUNT(*) as total FROM questions";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    public function getTotalQuestionsBySearch($keyword) {
        // Trích xuất từ khóa với hỗ trợ tiếng Việt
        $keywords = $this->extractKeywords($keyword);
        if (empty($keywords)) {
            return 0;
        }
        
        // Tạo điều kiện tìm kiếm LIKE
        $searchConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $searchConditions[] = "(q.title LIKE '%$kw%' OR q.content LIKE '%$kw%')";
        }
        $searchSql = implode(' OR ', $searchConditions);
        
        // Tạo SQL cho tìm kiếm tags
        $tagConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $tagConditions[] = "t.name LIKE '%$kw%'";
        }
        $tagSql = !empty($tagConditions) ? 
            "OR q.id IN (SELECT qt.question_id FROM question_tags qt JOIN tags t ON qt.tag_id = t.id WHERE " . 
            implode(' OR ', $tagConditions) . ")" : "";
        
        // Kết hợp các điều kiện tìm kiếm
        $sql = "SELECT COUNT(DISTINCT q.id) as total 
                FROM questions q
                WHERE ($searchSql $tagSql)";
        
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Lấy danh sách tất cả các tags hiện có
    public function getAllTags() {
        $sql = "SELECT id, name FROM tags ORDER BY name ASC";
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    // Thêm tag mới nếu chưa tồn tại
    public function addTagIfNotExists($tagName) {
        $tagName = trim($tagName);
        
        // Kiểm tra xem tag đã tồn tại chưa
        $sql = "SELECT id FROM tags WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $tagName);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Nếu tag đã tồn tại, trả về ID của tag đó
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            // Nếu tag chưa tồn tại, thêm mới và trả về ID vừa thêm
            $sql = "INSERT INTO tags (name) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $tagName);
            $stmt->execute();
            
            return $this->conn->insert_id;
        }
    }
    
    // Liên kết tag với câu hỏi trong bảng question_tags
    public function linkTagToQuestion($questionId, $tagId) {
        $sql = "INSERT INTO question_tags (question_id, tag_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $questionId, $tagId);
        
        return $stmt->execute();
    }
    
    // Lấy câu hỏi từ một người dùng cụ thể
    public function getQuestionsByUserId($userId, $page = 1, $limit = 6) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 6;
        $offset = ($page - 1) * $limit;
        $userId = (int)$userId;
        
        $sql = "SELECT q.*, u.username, 
                (SELECT COUNT(*) FROM answers WHERE question_id = q.id) as answer_count 
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                WHERE q.user_id = $userId
                ORDER BY q.created_at DESC
                LIMIT $offset, $limit";
                
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    // Lấy tổng số câu hỏi của một người dùng
    public function getTotalQuestionsByUserId($userId) {
        $sql = "SELECT COUNT(*) as total FROM questions WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Phương thức trích xuất từ khóa tìm kiếm
    private function extractKeywords($keyword) {
        if (empty($keyword)) {
            return [];
        }
        
        // Loại bỏ các ký tự đặc biệt và dấu câu
        $cleanKeyword = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $keyword);
        
        // Tách thành các từ riêng biệt
        $words = explode(' ', $cleanKeyword);
        
        // Loại bỏ khoảng trắng và từ trống
        $words = array_filter($words, function($word) {
            return trim($word) !== '';
        });
        
        // Loại bỏ các từ quá ngắn (dưới 2 ký tự)
        $words = array_filter($words, function($word) {
            return mb_strlen(trim($word), 'UTF-8') >= 2;
        });
        
        return array_values($words);
    }
} 