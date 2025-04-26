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

    // Lấy user theo ID
    public function getUserById($userId) {
        $stmt = $this->con->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Tạo user mới (đăng ký)
    public function createUser($username, $passwordHash, $email, $fullname = null, $dob = null, $address = null) {
        $stmt = $this->con->prepare("
            INSERT INTO users (username, password, email, fullname, date_of_birth, address, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("ssssss", $username, $passwordHash, $email, $fullname, $dob, $address);
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

    // Lấy user ID từ access token
    public function getUserIdFromToken($token) {
        $stmt = $this->con->prepare("SELECT id FROM users WHERE access_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        
        return $user ? $user['id'] : null;
    }

    // Cập nhật thông tin cá nhân
    public function updateUserProfile($userId, $email, $fullname, $dob = null, $address = null) {
        $stmt = $this->con->prepare("
            UPDATE users
            SET email = ?, full_name = ?, date_of_birth = ?, address = ?
            WHERE id = ?
        ");
        $stmt->bind_param("ssssi", $email, $fullname, $dob, $address, $userId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    // Cập nhật mật khẩu
    public function updatePassword($userId, $newPasswordHash) {
        $stmt = $this->con->prepare("
            UPDATE users
            SET password = ?, updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("si", $newPasswordHash, $userId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
