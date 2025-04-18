<?php
class BlogModel extends Database {
    // Lấy danh sách bài viết cho trang hiện tại
    public function getBlogPosts($page, $limit) {
        $start = ($page - 1) * $limit;
    
        $stmt = $this->con->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ?, ?");
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
    
        return $stmt->get_result();
    }
    

    // Lấy tổng số bài viết
    public function getTotalPosts() {
        $qr = "SELECT COUNT(*) as total FROM posts";
        $result = $this->con->query($qr);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function createPost($title, $category, $image, $content) {
        $stmt = $this->con->prepare("INSERT INTO posts (title, category, image, content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $category, $image, $content);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function getPostById($id) {
        $stmt = $this->con->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        $stmt->close();
        return $post;
    }
    
    // Xóa bài viết theo ID
    public function deletePostById($id) {
        $stmt = $this->con->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    // Lấy danh sách bình luận của bài viết theo ID
    public function getComments($post_id) {
        $stmt = $this->con->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
    
    // Thêm bình luận cho bài viết
    public function createComment($post_id, $name, $email, $comment) {
        $stmt = $this->con->prepare("INSERT INTO comments (post_id, name, email, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $post_id, $name, $email, $comment);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function updatePost($post_id, $title, $category, $content, $image) {
        $stmt = $this->con->prepare("UPDATE posts SET title = ?, category = ?, content = ?, image = ? WHERE id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }
        $stmt->bind_param("ssssi", $title, $category, $content, $image, $post_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function searchPosts($keyword, $start, $limit) {
        $like = "%$keyword%";
        $stmt = $this->con->prepare("
            SELECT * FROM posts
            ORDER BY 
                CASE 
                    WHEN title LIKE ? THEN 0
                    WHEN content LIKE ? THEN 1
                    ELSE 2
                END,
                created_at DESC
            LIMIT ?, ?
        ");
    
        if (!$stmt) {
            die("Lỗi SQL: " . $this->con->error);
        }
    
        $stmt->bind_param("ssii", $like, $like, $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function countSearchPosts($keyword) {
        $keyword = "%$keyword%";
        $stmt = $this->con->prepare("SELECT COUNT(*) as total FROM posts WHERE title LIKE ? OR content LIKE ?");
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
    
    public function countTotalPosts() {
        $stmt = $this->con->query("SELECT COUNT(*) as total FROM posts");
        $result = $stmt->fetch_assoc();
        return $result['total'];
    }
    
    
}
?>
