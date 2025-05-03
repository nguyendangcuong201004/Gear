<?php
class ContactModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Tạo bảng contact_messages nếu chưa tồn tại
    public function createContactMessagesTable() {
        $createTableSQL = "
            CREATE TABLE IF NOT EXISTS contact_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255),
                phone VARCHAR(50),
                message TEXT NOT NULL,
                admin_reply TEXT NULL,
                newsletter TINYINT(1) DEFAULT 0,
                status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
                replied_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        return mysqli_query($this->db->con, $createTableSQL);
    }

    // Lưu tin nhắn liên hệ mới
    public function saveContactMessage($name, $email, $subject, $phone, $message, $newsletter) {
        // Đảm bảo bảng đã được tạo
        $this->createContactMessagesTable();
        
        // Chuẩn bị dữ liệu
        $name = mysqli_real_escape_string($this->db->con, $name);
        $email = mysqli_real_escape_string($this->db->con, $email);
        $subject = mysqli_real_escape_string($this->db->con, $subject);
        $phone = mysqli_real_escape_string($this->db->con, $phone);
        $message = mysqli_real_escape_string($this->db->con, $message);
        $newsletter = (int)$newsletter;
        
        // Chèn dữ liệu
        $query = "INSERT INTO contact_messages (name, email, subject, phone, message, newsletter) 
                  VALUES ('$name', '$email', '$subject', '$phone', '$message', $newsletter)";
        
        $result = mysqli_query($this->db->con, $query);
        
        return $result;
    }
} 