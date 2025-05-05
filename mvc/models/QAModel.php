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
    
    // Lấy thông tin một câu trả lời
    public function getAnswerById($id) {
        $sql = "SELECT a.*, u.username, q.title as question_title 
                FROM answers a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN questions q ON a.question_id = q.id
                WHERE a.id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Lấy tất cả câu trả lời với phân trang (cho admin)
    public function getAllAnswers($page = 1, $limit = 10) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 10;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT a.*, u.username, q.title as question_title 
                FROM answers a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN questions q ON a.question_id = q.id
                ORDER BY a.created_at DESC
                LIMIT $offset, $limit";
                
        $result = $this->conn->query($sql);
        
        return $result;
    }
    
    // Lấy tổng số câu trả lời
    public function getTotalAnswers() {
        $sql = "SELECT COUNT(*) as total FROM answers";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Cập nhật câu hỏi
    public function updateQuestion($id, $title, $content, $tags = []) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Cập nhật câu hỏi
            $sql = "UPDATE questions SET title = ?, content = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $title, $content, $id);
            $success = $stmt->execute();
            
            if (!$success) {
                $this->conn->rollback();
                return false;
            }
            
            // Xóa các liên kết tag cũ
            $sql = "DELETE FROM question_tags WHERE question_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Thêm các liên kết tag mới
            if (!empty($tags)) {
                foreach ($tags as $tagId) {
                    $this->linkTagToQuestion($id, $tagId);
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
    
    // Cập nhật câu trả lời
    public function updateAnswer($id, $content) {
        $sql = "UPDATE answers SET content = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $content, $id);
        
        return $stmt->execute();
    }
    
    // Xóa câu hỏi
    public function deleteQuestion($id) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Xóa các liên kết tag
            $sql = "DELETE FROM question_tags WHERE question_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Xóa câu trả lời
            $sql = "DELETE FROM answers WHERE question_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Xóa câu hỏi
            $sql = "DELETE FROM questions WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            
            if (!$success) {
                $this->conn->rollback();
                return false;
            }
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    
    // Xóa câu trả lời
    public function deleteAnswer($id) {
        $sql = "DELETE FROM answers WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    // Lấy tất cả tags kèm theo số lượng câu hỏi sử dụng
    public function getAllTagsWithCount() {
        $sql = "SELECT t.id, t.name, COUNT(qt.question_id) as question_count
                FROM tags t
                LEFT JOIN question_tags qt ON t.id = qt.tag_id
                GROUP BY t.id
                ORDER BY t.name ASC";
                
        $result = $this->conn->query($sql);
        
        $tags = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row;
            }
        }
        
        return $tags;
    }
    
    // Cập nhật tag
    public function updateTag($id, $name) {
        $sql = "UPDATE tags SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        
        return $stmt->execute();
    }
    
    // Xóa tag
    public function deleteTag($id) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Xóa các liên kết question_tags
            $sql = "DELETE FROM question_tags WHERE tag_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Xóa tag
            $sql = "DELETE FROM tags WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            
            if (!$success) {
                $this->conn->rollback();
                return false;
            }
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    
    // Lấy tags của một câu hỏi
    public function getTagsByQuestionId($questionId) {
        $sql = "SELECT t.id, t.name
                FROM tags t
                JOIN question_tags qt ON t.id = qt.tag_id
                WHERE qt.question_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $tags = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row;
            }
        }
        
        return $tags;
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
        
        // Tạo điều kiện tìm kiếm LIKE chỉ cho title
        $searchConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $searchConditions[] = "q.title LIKE '%$kw%'";
        }
        $searchSql = implode(' OR ', $searchConditions);
        
        // Kết hợp các điều kiện tìm kiếm
        $sql = "SELECT DISTINCT q.*, u.username, 
                (SELECT COUNT(*) FROM answers WHERE question_id = q.id) as answer_count
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                WHERE ($searchSql)
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
        
        // Tạo điều kiện tìm kiếm LIKE chỉ cho title
        $searchConditions = [];
        foreach ($keywords as $kw) {
            $kw = $this->conn->real_escape_string($kw);
            $searchConditions[] = "q.title LIKE '%$kw%'";
        }
        $searchSql = implode(' OR ', $searchConditions);
        
        // Kết hợp các điều kiện tìm kiếm
        $sql = "SELECT COUNT(DISTINCT q.id) as total 
                FROM questions q
                WHERE ($searchSql)";
        
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