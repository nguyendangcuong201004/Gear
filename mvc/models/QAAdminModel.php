<?php
// models/QAAdminModel.php
class QAAdminModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Lấy tất cả câu hỏi có phân trang
    public function getAllQuestions($page = 1, $limit = 10) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 10;
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
    
    // Lấy tổng số câu hỏi
    public function getTotalQuestions() {
        $sql = "SELECT COUNT(*) as total FROM questions";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Lấy tất cả câu trả lời với phân trang
    public function getAllAnswers($page = 1, $limit = 10) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 10;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT a.*, u.username, q.title as question_title, q.id as question_id
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
    
    // Lấy chi tiết câu hỏi theo ID
    public function getQuestionById($id) {
        $sql = "SELECT q.*, u.username 
                FROM questions q
                LEFT JOIN users u ON q.user_id = u.id
                WHERE q.id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Lấy chi tiết câu trả lời theo ID
    public function getAnswerById($id) {
        $sql = "SELECT a.*, u.username, q.title as question_title, q.id as question_id 
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
    
    // Lấy tất cả tags với số lượng câu hỏi (có phân trang)
    public function getAllTagsWithCount($page = 1, $limit = 10) {
        // Đảm bảo page và limit luôn là số nguyên dương
        $page = (int)$page > 0 ? (int)$page : 1;
        $limit = (int)$limit > 0 ? (int)$limit : 10;
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT t.id, t.name, COUNT(qt.question_id) as question_count
                FROM tags t
                LEFT JOIN question_tags qt ON t.id = qt.tag_id
                GROUP BY t.id
                ORDER BY t.name ASC
                LIMIT $offset, $limit";
                
        $result = $this->conn->query($sql);
        
        $tags = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row;
            }
        }
        
        return $tags;
    }
    
    // Lấy tổng số tags
    public function getTotalTags() {
        $sql = "SELECT COUNT(*) as total FROM tags";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    // Lấy tất cả tags
    public function getAllTags() {
        $sql = "SELECT id, name FROM tags ORDER BY name ASC";
        $result = $this->conn->query($sql);
        
        $tags = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row;
            }
        }
        
        return $tags;
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
    
    // Cập nhật câu hỏi
    public function updateQuestion($id, $title, $content, $tags = []) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // Cập nhật câu hỏi
            $sql = "UPDATE questions SET title = ?, content = ?, updated_at = NOW() WHERE id = ?";
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
                    $sql = "INSERT INTO question_tags (question_id, tag_id) VALUES (?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ii", $id, $tagId);
                    $stmt->execute();
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
        $sql = "UPDATE answers SET content = ?, updated_at = NOW() WHERE id = ?";
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
    
    // Tạo tag mới
    public function createTag($name) {
        $sql = "INSERT INTO tags (name) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        
        return $stmt->execute();
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
} 