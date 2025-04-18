<?php
// mvc/models/CommentModel.php

class CommentModel extends Database {
    public function getCommentsByPostId($post_id) {
        $stmt = $this->con->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addComment($post_id, $name, $comment) {
        $stmt = $this->con->prepare("INSERT INTO comments (post_id, name, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $post_id, $name, $comment);
        return $stmt->execute();
    }

    public function getCommentById($id) {
        $stmt = $this->con->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateComment($id, $comment) {
        $stmt = $this->con->prepare("UPDATE comments SET comment = ? WHERE id = ?");
        $stmt->bind_param("si", $comment, $id);
        return $stmt->execute();
    }

    public function deleteComment($id) {
        $stmt = $this->con->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
