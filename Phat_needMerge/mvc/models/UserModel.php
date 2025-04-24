<?php
require_once "./mvc/core/Database.php";

class UserModel extends Database {
    // Lấy user theo username
    public function getUserByUsername($username) {
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Tạo user mới (đăng ký)
    public function createUser($username, $passwordHash, $email, $role = 'user') {
        $stmt = $this->con->prepare("
            INSERT INTO users (username, password, email, user_role, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("ssss", $username, $passwordHash, $email, $role);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
    
    // (Tùy chọn) Lưu access token
    public function storeAccessToken($user_id, $token) {
        $stmt = $this->con->prepare("
            UPDATE users
            SET access_token = ?, token_created = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("si", $token, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
